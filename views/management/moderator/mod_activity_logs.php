<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireRole('moderator');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Activity Logs — Moderator</title>
    <link rel="stylesheet" href="../../../styles/management/mod_mgmt.css">
    <link rel="stylesheet" href="../../../styles/management/moderator/mod_sidebar.css">
    <link rel="stylesheet" href="../../../styles/management/moderator/mod_topbar.css">
    <link rel="stylesheet" href="../../../styles/management/moderator/mod_activity_logs.css">
</head>
<body>

<div class="mod-layout">

    <?php include __DIR__ . '/../../../components/management/moderator/mod_sidebar.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="mod-content">

    <?php
    $pageTitle      = 'Activity Logs';
    $pageBreadcrumb = [['Home', '#'], ['System', null], ['Activity Logs', null]];
    $modName        = $_SESSION['user_name'] ?? 'Moderator';
    $modRole        = 'Moderator';
    $notifCount     = 5;
    include __DIR__ . '/../../../components/management/moderator/mod_topbar.php';
    ?>

        <!-- STAT WIDGETS -->
        <section class="mod-widgets">

            <div class="mod-widget-card widget-teal">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Total Actions</span>
                    <p class="widget-number">142</p>
                    <span class="widget-trend up">&#9650; This month</span>
                </div>
            </div>

            <div class="mod-widget-card widget-red">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3l1.664 1.664M21 21l-1.5-1.5m-5.485-1.242L12 17.25 4.5 21V8.742m.164-4.078a2.15 2.15 0 0 1 1.743-1.342 48.507 48.507 0 0 1 11.186 0c1.1.128 1.907 1.077 1.907 2.185V19.5M4.664 4.664 19.5 19.5"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Reports Handled</span>
                    <p class="widget-number">38</p>
                    <span class="widget-trend danger">5 still pending</span>
                </div>
            </div>

            <div class="mod-widget-card widget-amber">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Sanctions Issued</span>
                    <p class="widget-number">9</p>
                    <span class="widget-trend warning">&#9654; This month</span>
                </div>
            </div>

            <div class="mod-widget-card widget-indigo">
                <div class="widget-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                </div>
                <div class="widget-body">
                    <span class="widget-label">Threads Locked</span>
                    <p class="widget-number">4</p>
                    <span class="widget-trend neutral">No change</span>
                </div>
            </div>

        </section>

        <!-- FILTERS -->
        <section class="log-filters-bar">

            <!-- Search -->
            <div class="log-search-wrap">
                <svg class="log-search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                <input type="text" id="log-search" placeholder="Search by user or thread…" class="log-search-input">
            </div>

            <!-- Action type -->
            <select id="log-action-type" class="log-select">
                <option value="all">All Action Types</option>
                <optgroup label="Mod Actions">
                    <option value="lock">Lock Thread</option>
                    <option value="unlock">Unlock Thread</option>
                    <option value="flag">Flag Thread</option>
                    <option value="unflag">Unflag Thread</option>
                    <option value="remove">Remove Thread</option>
                    <option value="remove_comment">Remove Comment</option>
                </optgroup>
                <optgroup label="Sanctions">
                    <option value="warning">Warning Issued</option>
                    <option value="mute">User Muted</option>
                    <option value="ban">User Banned</option>
                    <option value="sanction_lifted">Sanction Lifted</option>
                </optgroup>
                <optgroup label="Reports">
                    <option value="report_reviewed">Report Reviewed</option>
                    <option value="report_dismissed">Report Dismissed</option>
                    <option value="report_escalated">Report Escalated</option>
                </optgroup>
            </select>

            <!-- Moderator -->
            <select id="log-moderator" class="log-select">
                <option value="all">All Moderators</option>
                <option value="1">Juan Dela Cruz</option>
                <option value="2">Maria Santos</option>
                <option value="3">Pedro Cruz</option>
            </select>

            <!-- Date range -->
            <div class="log-date-range">
                <div class="log-date-field">
                    <label for="log-date-from" class="log-date-label">From</label>
                    <input type="date" id="log-date-from" class="log-date-input">
                </div>
                <span class="log-date-sep">—</span>
                <div class="log-date-field">
                    <label for="log-date-to" class="log-date-label">To</label>
                    <input type="date" id="log-date-to" class="log-date-input">
                </div>
            </div>

            <!-- Clear -->
            <button class="log-clear-btn" id="log-clear-btn" title="Clear all filters">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                Clear
            </button>

        </section>

        <!-- LOG TABLE -->
        <div class="log-table-panel">

            <div class="panel-header">
                <h2 class="section-label">Log Entries</h2>
                <div class="log-table-meta">
                    <span class="log-count" id="log-count">Showing 15 entries</span>
                    <button class="btn-mod-sm" id="log-export-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        Export CSV
                    </button>
                </div>
            </div>

            <div class="log-table-wrap">
                <table class="log-table" id="log-table">
                    <thead>
                        <tr>
                            <th class="col-id sortable" data-col="id">
                                # <span class="sort-icon">↕</span>
                            </th>
                            <th class="col-datetime sortable" data-col="datetime">
                                Date &amp; Time <span class="sort-icon">↕</span>
                            </th>
                            <th class="col-moderator sortable" data-col="moderator">
                                Moderator <span class="sort-icon">↕</span>
                            </th>
                            <th class="col-action">Action</th>
                            <th class="col-target">Target</th>
                            <th class="col-notes">Notes</th>
                        </tr>
                    </thead>
                    <tbody id="log-tbody">

                        <!-- ROW 1 -->
                        <tr data-action="remove" data-moderator="1" data-datetime="2026-03-05T14:32:00" data-target="thread">
                            <td class="col-id">001</td>
                            <td class="col-datetime">
                                <span class="log-date">Mar 5, 2026</span>
                                <span class="log-time">2:32 PM</span>
                            </td>
                            <td class="col-moderator">
                                <div class="log-mod-cell">
                                    <div class="log-mod-avatar">JD</div>
                                    <span>Juan Dela Cruz</span>
                                </div>
                            </td>
                            <td class="col-action">
                                <span class="log-action-badge badge-remove">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                    Remove Thread
                                </span>
                            </td>
                            <td class="col-target">
                                <span class="log-target-type type-thread">Thread</span>
                                <span class="log-target-name">"Is the barangay doing anything?"</span>
                                <span class="log-target-user">by juan_d</span>
                            </td>
                            <td class="col-notes"><span class="log-notes-text">Violated community guidelines — harassment.</span></td>
                        </tr>

                        <!-- ROW 2 -->
                        <tr data-action="warning" data-moderator="1" data-datetime="2026-03-05T11:15:00" data-target="user">
                            <td class="col-id">002</td>
                            <td class="col-datetime">
                                <span class="log-date">Mar 5, 2026</span>
                                <span class="log-time">11:15 AM</span>
                            </td>
                            <td class="col-moderator">
                                <div class="log-mod-cell">
                                    <div class="log-mod-avatar">JD</div>
                                    <span>Juan Dela Cruz</span>
                                </div>
                            </td>
                            <td class="col-action">
                                <span class="log-action-badge badge-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                                    Warning Issued
                                </span>
                            </td>
                            <td class="col-target">
                                <span class="log-target-type type-user">User</span>
                                <span class="log-target-name">maria_s</span>
                            </td>
                            <td class="col-notes"><span class="log-notes-text">Repeated spam posts in community feed.</span></td>
                        </tr>

                        <!-- ROW 3 -->
                        <tr data-action="report_reviewed" data-moderator="2" data-datetime="2026-03-05T09:50:00" data-target="thread">
                            <td class="col-id">003</td>
                            <td class="col-datetime">
                                <span class="log-date">Mar 5, 2026</span>
                                <span class="log-time">9:50 AM</span>
                            </td>
                            <td class="col-moderator">
                                <div class="log-mod-cell">
                                    <div class="log-mod-avatar">MS</div>
                                    <span>Maria Santos</span>
                                </div>
                            </td>
                            <td class="col-action">
                                <span class="log-action-badge badge-report-reviewed">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                    Report Reviewed
                                </span>
                            </td>
                            <td class="col-target">
                                <span class="log-target-type type-thread">Thread</span>
                                <span class="log-target-name">"Free items, dm me"</span>
                                <span class="log-target-user">by maria_s</span>
                            </td>
                            <td class="col-notes"><span class="log-notes-text">Confirmed spam. Forwarded to sanctions.</span></td>
                        </tr>

                        <!-- ROW 4 -->
                        <tr data-action="lock" data-moderator="1" data-datetime="2026-03-04T16:05:00" data-target="thread">
                            <td class="col-id">004</td>
                            <td class="col-datetime">
                                <span class="log-date">Mar 4, 2026</span>
                                <span class="log-time">4:05 PM</span>
                            </td>
                            <td class="col-moderator">
                                <div class="log-mod-cell">
                                    <div class="log-mod-avatar">JD</div>
                                    <span>Juan Dela Cruz</span>
                                </div>
                            </td>
                            <td class="col-action">
                                <span class="log-action-badge badge-lock">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                    Lock Thread
                                </span>
                            </td>
                            <td class="col-target">
                                <span class="log-target-type type-thread">Thread</span>
                                <span class="log-target-name">"Off-topic political debate"</span>
                                <span class="log-target-user">by pedro_c</span>
                            </td>
                            <td class="col-notes"><span class="log-notes-text">Escalating off-topic arguments.</span></td>
                        </tr>

                        <!-- ROW 5 -->
                        <tr data-action="mute" data-moderator="2" data-datetime="2026-03-04T14:20:00" data-target="user">
                            <td class="col-id">005</td>
                            <td class="col-datetime">
                                <span class="log-date">Mar 4, 2026</span>
                                <span class="log-time">2:20 PM</span>
                            </td>
                            <td class="col-moderator">
                                <div class="log-mod-cell">
                                    <div class="log-mod-avatar">MS</div>
                                    <span>Maria Santos</span>
                                </div>
                            </td>
                            <td class="col-action">
                                <span class="log-action-badge badge-mute">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 9.75 19.5 12m0 0 2.25 2.25M19.5 12l2.25-2.25M19.5 12l-2.25 2.25m-10.5-6 4.72-4.72a.75.75 0 0 1 1.28.53v15.88a.75.75 0 0 1-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.009 9.009 0 0 1 2.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75Z"/></svg>
                                    User Muted
                                </span>
                            </td>
                            <td class="col-target">
                                <span class="log-target-type type-user">User</span>
                                <span class="log-target-name">pedro_c</span>
                            </td>
                            <td class="col-notes"><span class="log-notes-text">3-day mute. Second offense for offensive language.</span></td>
                        </tr>

                        <!-- ROW 6 -->
                        <tr data-action="flag" data-moderator="3" data-datetime="2026-03-04T11:00:00" data-target="thread">
                            <td class="col-id">006</td>
                            <td class="col-datetime">
                                <span class="log-date">Mar 4, 2026</span>
                                <span class="log-time">11:00 AM</span>
                            </td>
                            <td class="col-moderator">
                                <div class="log-mod-cell">
                                    <div class="log-mod-avatar">PC</div>
                                    <span>Pedro Cruz</span>
                                </div>
                            </td>
                            <td class="col-action">
                                <span class="log-action-badge badge-flag">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></svg>
                                    Flag Thread
                                </span>
                            </td>
                            <td class="col-target">
                                <span class="log-target-type type-thread">Thread</span>
                                <span class="log-target-name">"Road Repair Concern"</span>
                                <span class="log-target-user">by carlo_m</span>
                            </td>
                            <td class="col-notes"><span class="log-notes-text">Comment section has inappropriate replies.</span></td>
                        </tr>

                        <!-- ROW 7 -->
                        <tr data-action="report_dismissed" data-moderator="3" data-datetime="2026-03-03T15:45:00" data-target="thread">
                            <td class="col-id">007</td>
                            <td class="col-datetime">
                                <span class="log-date">Mar 3, 2026</span>
                                <span class="log-time">3:45 PM</span>
                            </td>
                            <td class="col-moderator">
                                <div class="log-mod-cell">
                                    <div class="log-mod-avatar">PC</div>
                                    <span>Pedro Cruz</span>
                                </div>
                            </td>
                            <td class="col-action">
                                <span class="log-action-badge badge-report-dismissed">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                                    Report Dismissed
                                </span>
                            </td>
                            <td class="col-target">
                                <span class="log-target-type type-thread">Thread</span>
                                <span class="log-target-name">"Scholarship Application Inquiry"</span>
                                <span class="log-target-user">by maria_s</span>
                            </td>
                            <td class="col-notes"><span class="log-notes-text">Report found to be invalid — no violation.</span></td>
                        </tr>

                        <!-- ROW 8 -->
                        <tr data-action="remove_comment" data-moderator="2" data-datetime="2026-03-03T10:30:00" data-target="comment">
                            <td class="col-id">008</td>
                            <td class="col-datetime">
                                <span class="log-date">Mar 3, 2026</span>
                                <span class="log-time">10:30 AM</span>
                            </td>
                            <td class="col-moderator">
                                <div class="log-mod-cell">
                                    <div class="log-mod-avatar">MS</div>
                                    <span>Maria Santos</span>
                                </div>
                            </td>
                            <td class="col-action">
                                <span class="log-action-badge badge-remove">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                    Remove Comment
                                </span>
                            </td>
                            <td class="col-target">
                                <span class="log-target-type type-comment">Comment</span>
                                <span class="log-target-name">Comment on "Noise Complaint"</span>
                                <span class="log-target-user">by rey_s</span>
                            </td>
                            <td class="col-notes"><span class="log-notes-text">Profanity and personal attacks.</span></td>
                        </tr>

                        <!-- ROW 9 -->
                        <tr data-action="ban" data-moderator="1" data-datetime="2026-03-02T16:00:00" data-target="user">
                            <td class="col-id">009</td>
                            <td class="col-datetime">
                                <span class="log-date">Mar 2, 2026</span>
                                <span class="log-time">4:00 PM</span>
                            </td>
                            <td class="col-moderator">
                                <div class="log-mod-cell">
                                    <div class="log-mod-avatar">JD</div>
                                    <span>Juan Dela Cruz</span>
                                </div>
                            </td>
                            <td class="col-action">
                                <span class="log-action-badge badge-ban">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                    User Banned
                                </span>
                            </td>
                            <td class="col-target">
                                <span class="log-target-type type-user">User</span>
                                <span class="log-target-name">lito_g</span>
                            </td>
                            <td class="col-notes"><span class="log-notes-text">Permanent ban. Repeated harassment after two warnings.</span></td>
                        </tr>

                        <!-- ROW 10 -->
                        <tr data-action="unlock" data-moderator="3" data-datetime="2026-03-02T09:20:00" data-target="thread">
                            <td class="col-id">010</td>
                            <td class="col-datetime">
                                <span class="log-date">Mar 2, 2026</span>
                                <span class="log-time">9:20 AM</span>
                            </td>
                            <td class="col-moderator">
                                <div class="log-mod-cell">
                                    <div class="log-mod-avatar">PC</div>
                                    <span>Pedro Cruz</span>
                                </div>
                            </td>
                            <td class="col-action">
                                <span class="log-action-badge badge-unlock">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                    Unlock Thread
                                </span>
                            </td>
                            <td class="col-target">
                                <span class="log-target-type type-thread">Thread</span>
                                <span class="log-target-name">"Barangay ID Renewal Schedule"</span>
                                <span class="log-target-user">by lita_p</span>
                            </td>
                            <td class="col-notes"><span class="log-notes-text">Issue resolved. Thread reopened for follow-ups.</span></td>
                        </tr>

                        <!-- ROW 11 -->
                        <tr data-action="report_escalated" data-moderator="2" data-datetime="2026-03-01T14:10:00" data-target="thread">
                            <td class="col-id">011</td>
                            <td class="col-datetime">
                                <span class="log-date">Mar 1, 2026</span>
                                <span class="log-time">2:10 PM</span>
                            </td>
                            <td class="col-moderator">
                                <div class="log-mod-cell">
                                    <div class="log-mod-avatar">MS</div>
                                    <span>Maria Santos</span>
                                </div>
                            </td>
                            <td class="col-action">
                                <span class="log-action-badge badge-report-escalated">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18"/></svg>
                                    Report Escalated
                                </span>
                            </td>
                            <td class="col-target">
                                <span class="log-target-type type-thread">Thread</span>
                                <span class="log-target-name">"Flooding Near Purok 4"</span>
                                <span class="log-target-user">by roberto_g</span>
                            </td>
                            <td class="col-notes"><span class="log-notes-text">Escalated to admin — involves public safety concern.</span></td>
                        </tr>

                        <!-- ROW 12 -->
                        <tr data-action="sanction_lifted" data-moderator="1" data-datetime="2026-03-01T10:00:00" data-target="user">
                            <td class="col-id">012</td>
                            <td class="col-datetime">
                                <span class="log-date">Mar 1, 2026</span>
                                <span class="log-time">10:00 AM</span>
                            </td>
                            <td class="col-moderator">
                                <div class="log-mod-cell">
                                    <div class="log-mod-avatar">JD</div>
                                    <span>Juan Dela Cruz</span>
                                </div>
                            </td>
                            <td class="col-action">
                                <span class="log-action-badge badge-sanction-lifted">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                                    Sanction Lifted
                                </span>
                            </td>
                            <td class="col-target">
                                <span class="log-target-type type-user">User</span>
                                <span class="log-target-name">pedro_c</span>
                            </td>
                            <td class="col-notes"><span class="log-notes-text">Mute period ended. User acknowledged guidelines.</span></td>
                        </tr>

                        <!-- ROW 13 -->
                        <tr data-action="unflag" data-moderator="3" data-datetime="2026-02-28T13:30:00" data-target="thread">
                            <td class="col-id">013</td>
                            <td class="col-datetime">
                                <span class="log-date">Feb 28, 2026</span>
                                <span class="log-time">1:30 PM</span>
                            </td>
                            <td class="col-moderator">
                                <div class="log-mod-cell">
                                    <div class="log-mod-avatar">PC</div>
                                    <span>Pedro Cruz</span>
                                </div>
                            </td>
                            <td class="col-action">
                                <span class="log-action-badge badge-unflag">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/></svg>
                                    Unflag Thread
                                </span>
                            </td>
                            <td class="col-target">
                                <span class="log-target-type type-thread">Thread</span>
                                <span class="log-target-name">"Community Clean-Up Drive"</span>
                                <span class="log-target-user">by ana_r</span>
                            </td>
                            <td class="col-notes"><span class="log-notes-text">Review complete — no violation found.</span></td>
                        </tr>

                        <!-- ROW 14 -->
                        <tr data-action="warning" data-moderator="2" data-datetime="2026-02-27T09:05:00" data-target="user">
                            <td class="col-id">014</td>
                            <td class="col-datetime">
                                <span class="log-date">Feb 27, 2026</span>
                                <span class="log-time">9:05 AM</span>
                            </td>
                            <td class="col-moderator">
                                <div class="log-mod-cell">
                                    <div class="log-mod-avatar">MS</div>
                                    <span>Maria Santos</span>
                                </div>
                            </td>
                            <td class="col-action">
                                <span class="log-action-badge badge-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                                    Warning Issued
                                </span>
                            </td>
                            <td class="col-target">
                                <span class="log-target-type type-user">User</span>
                                <span class="log-target-name">sofia_v</span>
                            </td>
                            <td class="col-notes"><span class="log-notes-text">First warning for posting misleading information.</span></td>
                        </tr>

                        <!-- ROW 15 -->
                        <tr data-action="report_reviewed" data-moderator="1" data-datetime="2026-02-26T16:50:00" data-target="thread">
                            <td class="col-id">015</td>
                            <td class="col-datetime">
                                <span class="log-date">Feb 26, 2026</span>
                                <span class="log-time">4:50 PM</span>
                            </td>
                            <td class="col-moderator">
                                <div class="log-mod-cell">
                                    <div class="log-mod-avatar">JD</div>
                                    <span>Juan Dela Cruz</span>
                                </div>
                            </td>
                            <td class="col-action">
                                <span class="log-action-badge badge-report-reviewed">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                    Report Reviewed
                                </span>
                            </td>
                            <td class="col-target">
                                <span class="log-target-type type-thread">Thread</span>
                                <span class="log-target-name">"Noise Complaint Against Neighbor"</span>
                                <span class="log-target-user">by sofia_v</span>
                            </td>
                            <td class="col-notes"><span class="log-notes-text">Valid report. Warning issued to subject user.</span></td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- NO RESULTS -->
            <div class="log-no-results" id="log-no-results" style="display:none;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                <p>No log entries match your current filters.</p>
            </div>

        </div>

        <!-- PAGINATION -->
        <section class="mod-pagination">
            <button class="mod-page-btn" id="log-prev-btn" disabled>&#8249; Previous</button>
            <div class="mod-page-numbers" id="log-page-numbers">
                <button class="mod-page-num active">1</button>
                <button class="mod-page-num">2</button>
                <button class="mod-page-num">3</button>
            </div>
            <button class="mod-page-btn" id="log-next-btn">Next &#8250;</button>
        </section>

    </main>
</div>

<script src="../../../scripts/management/moderator/mod_activity_logs.js"></script>

</body>
</html>