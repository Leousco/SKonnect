<?php
// backend/controllers/ServiceRequestController.php

require_once __DIR__ . '/../models/ServiceRequestModel.php';

class ServiceRequestController
{
    private ServiceRequestModel $model;

    private string $fulfillmentDir;
    private array $allowedMimes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
    ];
    private array $allowedExts      = ['pdf', 'doc', 'docx', 'xlsx', 'jpg', 'jpeg', 'png', 'gif', 'webp'];
    private int   $maxFileSizeBytes = 5 * 1024 * 1024; // 5 MB
    private string $uploadDir;

    public function __construct()
    {
        $this->model     = new ServiceRequestModel();
        $this->uploadDir = __DIR__ . '/../../uploads/applications/';
        $this->fulfillmentDir = __DIR__ . '/../../uploads/fulfillment/';

        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0755, true);
        }
        if (!is_dir($this->fulfillmentDir)) {
            mkdir($this->fulfillmentDir, 0755, true);
        }
    }

    // ──────────────────────────────────────────────────────────
    //  READ (officer-facing)
    // ──────────────────────────────────────────────────────────

    public function getAll(array $filters = []): array
    {
        return $this->model->getAll($filters);
    }

    public function getById(int $id): ?array
    {
        return $this->model->getById($id);
    }

    public function getStatusCounts(): array
    {
        return $this->model->getStatusCounts();
    }

    // ──────────────────────────────────────────────────────────
    //  SUBMIT (resident-facing, new application)
    // ──────────────────────────────────────────────────────────

    public function submit(array $data, ?array $filesArray, int $residentId): array
    {
        $validation = $this->validateSubmit($data);
        if (!$validation['ok']) {
            return ['success' => false, 'errors' => $validation['errors']];
        }

        if ($this->model->residentHasActiveApplication($residentId, (int)$data['service_id'])) {
            return ['success' => false, 'errors' => ['You already have an active application for this service.']];
        }

        $applicationId = $this->model->insert($data, $residentId);

        $uploadedFiles = $this->normaliseFilesArray($filesArray);
        foreach ($uploadedFiles as $file) {
            if ($file['error'] !== UPLOAD_ERR_OK) continue;
            $upload = $this->handleUpload($file, $applicationId);
            if (!$upload['ok']) {
                $this->model->updateStatus($applicationId, 'rejected');
                return ['success' => false, 'errors' => [$upload['error']]];
            }
        }

        return [
            'success'        => true,
            'application_id' => $applicationId,
            'message'        => 'Your request has been submitted! You will be notified once it is reviewed.',
        ];
    }

    // ──────────────────────────────────────────────────────────
    //  REAPPLY (resident-facing, update an action_required app)
    //  - Updates contact details and purpose
    //  - Removes documents by ID if requested
    //  - Adds new uploaded documents
    //  - Resets status back to 'pending'
    // ──────────────────────────────────────────────────────────

    public function reapply(int $applicationId, int $residentId, array $data, ?array $filesArray, array $removeDocIds = []): array
    {
        // Load the existing application
        $existing = $this->model->getById($applicationId);
        if (!$existing) {
            return ['success' => false, 'message' => 'Application not found.'];
        }

        // Ownership check — the resident can only reapply their own application
        if ((int)$existing['resident_id'] !== $residentId) {
            return ['success' => false, 'message' => 'You are not authorised to update this application.'];
        }

        // Only allow reapply when status is action_required
        if ($existing['status'] !== 'action_required') {
            return ['success' => false, 'message' => 'This application cannot be resubmitted in its current status.'];
        }

        // Validate the updated fields
        $validation = $this->validateReapply($data);
        if (!$validation['ok']) {
            return ['success' => false, 'errors' => $validation['errors']];
        }

        // Update the core fields and reset status → pending
        $this->model->updateApplication($applicationId, [
            'full_name' => trim($data['full_name']),
            'contact'   => trim($data['contact']),
            'email'     => trim($data['email']),
            'address'   => trim($data['address']),
            'purpose'   => isset($data['purpose']) ? trim($data['purpose']) : null,
        ]);

        // Remove documents the resident unchecked
        foreach ($removeDocIds as $docId) {
            $docId = (int)$docId;
            if ($docId > 0) {
                // Optionally delete the physical file here if desired
                $this->model->deleteDocument($docId, $applicationId);
            }
        }

        // Upload any new files
        $uploadedFiles = $this->normaliseFilesArray($filesArray);
        foreach ($uploadedFiles as $file) {
            if ($file['error'] !== UPLOAD_ERR_OK) continue;
            $upload = $this->handleUpload($file, $applicationId);
            if (!$upload['ok']) {
                return ['success' => false, 'errors' => [$upload['error']]];
            }
        }

        // Reset status to pending so officers see it as a fresh review
        $this->model->updateStatus($applicationId, 'pending');

        return [
            'success'        => true,
            'application_id' => $applicationId,
            'message'        => 'Your application has been resubmitted and is pending review.',
        ];
    }

    // ──────────────────────────────────────────────────────────
    //  UPDATE STATUS (officer-facing)
    // ──────────────────────────────────────────────────────────

    public function getApprovalMessage(int $applicationId): array
    {
        $existing = $this->model->getById($applicationId);
        if (!$existing) {
            return ['success' => false, 'message' => 'Application not found.'];
        }
        $msg = $this->model->getApprovalMessage((int)$existing['service_id']);
        return ['success' => true, 'approval_message' => $msg ?? ''];
    }

    public function updateStatus(int $id, string $status, int $officerId, string $note = '', ?array $fulfillmentFile = null): array
    {
        $allowedStatuses = ['approved', 'rejected'];
        if (!in_array($status, $allowedStatuses, true)) {
            return ['success' => false, 'message' => 'Invalid status. Only "approved" or "rejected" can be set here.'];
        }

        $existing = $this->model->getById($id);
        if (!$existing) {
            return ['success' => false, 'message' => 'Application not found.'];
        }

        if (in_array($existing['status'], ['approved', 'rejected'], true)) {
            return ['success' => false, 'message' => 'This application is already finalized and cannot be changed.'];
        }

        // Rejection requires a mandatory reason
        if ($status === 'rejected' && trim($note) === '') {
            return ['success' => false, 'message' => 'A reason is required when declining an application.'];
        }

        // Handle optional fulfillment file upload (approvals only)
        $fulfillmentPath = null;
        if ($status === 'approved' && $fulfillmentFile && ($fulfillmentFile['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_OK) {
            $upload = $this->handleFulfillmentUpload($fulfillmentFile);
            if (!$upload['ok']) {
                return ['success' => false, 'message' => $upload['error']];
            }
            $fulfillmentPath = $upload['path'];
        }

        // Persist the status (and fulfillment file path if present)
        $this->model->updateStatus($id, $status, $fulfillmentPath);

        // Build and insert the thread message.
        // Pass setActionRequired=false so this note never flips the finalized status back.
        if ($status === 'approved') {
            $trimmedNote = trim($note);
            $threadNote  = $trimmedNote !== ''
                ? 'Request Approved! ' . $trimmedNote
                : 'Request Approved!';
        } else {
            $threadNote = 'Request Declined. Reason: ' . trim($note);
        }

        if ($officerId > 0) {
            $this->model->insertNote($id, $officerId, $threadNote, false);
        }

        return [
            'success'     => true,
            'id'          => $id,
            'status'      => $status,
            'application' => $this->model->getById($id),
        ];
    }

    // ──────────────────────────────────────────────────────────
    //  ADD NOTE (officer-facing)
    // ──────────────────────────────────────────────────────────

    public function addNote(int $applicationId, int $officerId, string $note): array
    {
        $note = trim($note);
        if ($note === '') {
            return ['success' => false, 'message' => 'Note cannot be empty.'];
        }

        $existing = $this->model->getById($applicationId);
        if (!$existing) {
            return ['success' => false, 'message' => 'Application not found.'];
        }

        if (in_array($existing['status'], ['approved', 'rejected'], true)) {
            return ['success' => false, 'message' => 'Cannot add notes to a finalized application.'];
        }

        $this->model->insertNote($applicationId, $officerId, $note);

        return [
            'success'     => true,
            'application' => $this->model->getById($applicationId),
        ];
    }

    // ──────────────────────────────────────────────────────────
    //  PRIVATE HELPERS
    // ──────────────────────────────────────────────────────────

    private function validateSubmit(array $data): array
    {
        $errors = [];

        if (empty($data['service_id']) || (int)$data['service_id'] < 1) {
            $errors[] = 'Invalid service selected.';
        }
        if (empty(trim($data['full_name'] ?? ''))) {
            $errors[] = 'Full name is required.';
        }
        if (empty(trim($data['contact'] ?? ''))) {
            $errors[] = 'Contact number is required.';
        } elseif (!preg_match('/^(09|\+639)\d{9}$/', preg_replace('/\s/', '', $data['contact']))) {
            $errors[] = 'Enter a valid PH mobile number (e.g. 09XX XXX XXXX).';
        }
        if (empty(trim($data['email'] ?? ''))) {
            $errors[] = 'Email address is required.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Enter a valid email address.';
        }
        if (empty(trim($data['address'] ?? ''))) {
            $errors[] = 'Home address is required.';
        }

        return ['ok' => empty($errors), 'errors' => $errors];
    }

    private function validateReapply(array $data): array
    {
        $errors = [];

        if (empty(trim($data['full_name'] ?? ''))) {
            $errors[] = 'Full name is required.';
        }
        if (empty(trim($data['contact'] ?? ''))) {
            $errors[] = 'Contact number is required.';
        } elseif (!preg_match('/^(09|\+639)\d{9}$/', preg_replace('/\s/', '', $data['contact']))) {
            $errors[] = 'Enter a valid PH mobile number (e.g. 09XX XXX XXXX).';
        }
        if (empty(trim($data['email'] ?? ''))) {
            $errors[] = 'Email address is required.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Enter a valid email address.';
        }
        if (empty(trim($data['address'] ?? ''))) {
            $errors[] = 'Home address is required.';
        }

        return ['ok' => empty($errors), 'errors' => $errors];
    }

    private function normaliseFilesArray(?array $files): array
    {
        if (!$files || !isset($files['name'])) return [];

        if (is_array($files['name'])) {
            $out   = [];
            $count = count($files['name']);
            for ($i = 0; $i < $count; $i++) {
                $out[] = [
                    'name'     => $files['name'][$i],
                    'type'     => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error'    => $files['error'][$i],
                    'size'     => $files['size'][$i],
                ];
            }
            return $out;
        }

        return [$files];
    }

    private function handleFulfillmentUpload(array $file): array
    {
        if ($file['size'] > $this->maxFileSizeBytes) {
            return ['ok' => false, 'error' => "\"{$file['name']}\" exceeds the 5 MB file size limit."];
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $this->allowedExts, true)) {
            return ['ok' => false, 'error' => "File type \".{$ext}\" is not allowed."];
        }

        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $this->allowedMimes, true)) {
            return ['ok' => false, 'error' => "Invalid file type detected for \"{$file['name']}\"."];
        }

        $safeName    = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($file['name']));
        $uniqueName  = 'fulfillment_' . uniqid('', true) . '_' . $safeName;
        $destination = $this->fulfillmentDir . $uniqueName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return ['ok' => false, 'error' => "Failed to save \"{$file['name']}\". Please try again."];
        }

        return ['ok' => true, 'path' => '/uploads/fulfillment/' . $uniqueName];
    }

    private function handleUpload(array $file, int $applicationId): array
    {
        if ($file['size'] > $this->maxFileSizeBytes) {
            return ['ok' => false, 'error' => "\"{$file['name']}\" exceeds the 5 MB file size limit."];
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $this->allowedExts, true)) {
            return ['ok' => false, 'error' => "File type \".{$ext}\" is not allowed."];
        }

        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $this->allowedMimes, true)) {
            return ['ok' => false, 'error' => "Invalid file type detected for \"{$file['name']}\"."];
        }

        $safeName    = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($file['name']));
        $uniqueName  = 'app_' . $applicationId . '_' . uniqid('', true) . '_' . $safeName;
        $destination = $this->uploadDir . $uniqueName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return ['ok' => false, 'error' => "Failed to save \"{$file['name']}\". Please try again."];
        }

        $this->model->insertDocument(
            $applicationId,
            $file['name'],
            '/uploads/applications/' . $uniqueName,
            $file['size'],
            $mimeType
        );

        return ['ok' => true];
    }
}