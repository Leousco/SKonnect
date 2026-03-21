<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireRole('moderator');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Warnings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root{--bg:#0f0f14;--surface:#18181f;--surface2:#1f1f28;--border:#2e2e3a;--accent:#a78bfa;--accent-dim:#2d1f5e;--danger:#f87171;--warn:#fb923c;--text:#e2e8f0;--text-muted:#94a3b8;--success:#10b981;--radius:12px;}
        *{box-sizing:border-box;margin:0;padding:0;}
         body { font-family: 'Segoe UI', system-ui, sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }
        .sidebar { position: fixed; top: 0; left: 0;width: 240px; height: 100vh;background: var(--surface); border-right: 1px solid var(--border);display: flex; flex-direction: column; padding: 24px 0; z-index: 100;}
        .sidebar-logo { font-size: 1.4rem; font-weight: 700; color: var(--accent); padding: 0 24px 24px; border-bottom: 1px solid var(--border); }
        .sidebar-logo span { color: var(--text-muted); font-weight: 400; font-size: .75rem; display: block; margin-top: 2px; }
        .nav-section { padding: 20px 12px 8px; font-size: .7rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); }
        .nav-item { display: flex; align-items: center; gap: 12px; padding: 10px 24px; font-size: .9rem; color: var(--text-muted);  text-decoration: none; transition: color .15s, background .15s; cursor: pointer; border: none; background: none; width: 100%; text-align: left; }
        .nav-item:hover  { color: var(--text); background: var(--surface2); }
        .nav-item.active { color: var(--accent); background: var(--accent-dim); font-weight: 600; }
        .nav-item i { width: 18px; text-align: center; }
        .badge-count{margin-left:auto;background:var(--danger);color:#fff;font-size:.68rem;font-weight:700;border-radius:50px;padding:1px 7px;min-width:20px;}
        .sidebar-bottom{margin-top:auto;border-top:1px solid var(--border);padding-top:16px;}
        .main{margin-left:240px;padding:32px;}
        .topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;}
        .topbar h1{font-size:1.5rem;font-weight:700;}
        .topbar h1 span{color:var(--accent);}
        .user-pill{display:flex;align-items:center;gap:10px;background:var(--surface);border:1px solid var(--border);border-radius:50px;padding:8px 16px;font-size:.88rem;}
        .avatar{width:30px;height:30px;border-radius:50%;background:var(--accent-dim);color:var(--accent);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.8rem;}
        .role-badge{font-size:.7rem;background:var(--accent-dim);color:var(--accent);padding:2px 8px;border-radius:50px;font-weight:600;text-transform:uppercase;letter-spacing:.5px;}
        .stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:28px;}
        .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px;}
        .stat-card .label{font-size:.8rem;color:var(--text-muted);margin-bottom:8px;}
        .stat-card .value{font-size:2rem;font-weight:700;}
        .stat-card.warn-card{border-color:var(--warn);}
        .stat-card.warn-card .value{color:var(--warn);}
        .stat-card .icon{float:right;font-size:1.4rem;color:var(--text-muted);margin-top:-4px;}
        .new-warning{background:var(--surface);border:2px solid var(--warn);border-radius:var(--radius);padding:24px;margin-bottom:28px;}
        .new-warning h3{font-size:1.1rem;font-weight:600;margin-bottom:16px;color:var(--warn);}
        .warning-form{display:grid;grid-template-columns:1fr 200px;gap:16px;align-items:end;}
        .form-group{display:flex;flex-direction:column;gap:6px;}
        .form-input,.form-select{background:var(--surface2);border:1px solid var(--border);border-radius:8px;padding:12px 16px;color:var(--text);font-size:.95rem;transition:all .15s;}
        .form-input:focus,.form-select:focus{outline:none;border-color:var(--accent);box-shadow:0 0 0 3px rgba(167,139,250,.1);}
        .form-textarea{resize:vertical;min-height:100px;}
        .btn{font-size:.85rem;padding:12px 24px;border-radius:8px;cursor:pointer;transition:all .15s;font-weight:600;text-decoration:none;display:inline-flex;align-items:center;gap:8px;}
        .btn-primary{background:var(--accent);color:#fff;border:1px solid var(--accent);}
        .btn-primary:hover{background:#8b5cf6;transform:translateY(-1px);}
        .btn-success{background:var(--success);color:#fff;border:1px solid var(--success);}
        .btn-danger{background:var(--danger);color:#fff;border:1px solid var(--danger);}
        .btn-secondary{background:var(--surface2);color:var(--text);border:1px solid var(--border);}
        .btn-secondary:hover{background:var(--surface);}
        .filters{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px;margin-bottom:24px;}
        .filters-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;}
        .filter-row{display:flex;gap:12px;flex-wrap:wrap;}
        .filter-btn{padding:8px 16px;border:1px solid var(--border);background:var(--surface2);color:var(--text-muted);border-radius:8px;font-size:.85rem;cursor:pointer;transition:all .15s;}
        .filter-btn:hover{background:var(--surface);border-color:var(--accent);color:var(--text);}
        .filter-btn.active{background:var(--accent);color:#fff;border-color:var(--accent);}
        .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:24px;}
        .warning-item{padding:20px 0;border-bottom:1px solid var(--border);transition:all .15s;display:flex;align-items:flex-start;gap:16px;}
        .warning-item:hover{background:var(--surface2);border-radius:var(--radius);margin:0 -24px;padding-left:24px;padding-right:24px;padding-top:20px;padding-bottom:20px;}
        .warning-item:last-child{border-bottom:none;}
        .warning-avatar{width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,var(--warn),#f59e0b);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:1rem;flex-shrink:0;}
        .warning-content{flex:1;}
        .warning-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px;gap:12px;}
        .warning-user{font-size:1rem;font-weight:600;}
        .warning-date{font-size:.8rem;color:var(--text-muted);}
        .warning-level{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:20px;font-size:.75rem;font-weight:600;}
        .level-1{background:rgba(251,146,60,.2);color:var(--warn);}
        .level-2{background:rgba(248,113,113,.2);color:var(--danger);}
        .warning-reason{font-size:.85rem;color:var(--text);background:var(--surface2);padding:12px;border-radius:8px;border-left:3px solid var(--warn);margin-bottom:12px;}
        .warning-actions{display:flex;gap:8px;flex-wrap:wrap;}
        .pagination{display:flex;justify-content:center;gap:8px;margin-top:32px;}
        .page-btn{padding:10px 14px;border:1px solid var(--border);background:var(--surface2);color:var(--text-muted);border-radius:8px;cursor:pointer;transition:all .15s;font-weight:500;}
        .page-btn:hover:not(.disabled),.page-btn.active{background:var(--accent);color:#fff;border-color:var(--accent);}
        .page-btn.disabled{opacity:.5;cursor:not-allowed;}
        @media(max-width:900px){.sidebar{width:60px;}.sidebar-logo,.nav-section,.nav-item span,.badge-count{display:none;}.nav-item{justify-content:center;padding:12px;}.main{margin-left:60px;}.warning-form{grid-template-columns:1fr;}.warning-item:hover{margin:0;padding:20px 0;}.warning-header{flex-direction:column;gap:8px;align-items:flex-start;}.warning-actions{flex-direction:column;width:100%;}.btn{justify-content:center;width:100%;padding:12px;}}
    </style>
</head>
<body>
<?php $userName = $_SESSION['user_name'] ?? 'Moderator'; $initials = implode('', array_map(fn($w) => strtoupper($w[0]), explode(' ', $userName))); ?>

<aside class="sidebar">
    <div class="sidebar-logo">SKonnect <span>Moderator Panel</span></div>
    <div class="nav-section">Moderation</div>
    <a href="mod_dashboard.php" class="nav-item"><i class="fa-solid fa-shield-halved"></i><span>Dashboard</span></a>
    <a href="mod_reports.php" class="nav-item"><i class="fa-solid fa-flag"></i><span>Reports</span><span class="badge-count">12</span></a>
    <a href="mod_community.php" class="nav-item"><i class="fa-solid fa-comments"></i><span>Community Feed</span></a>
    <a href="mod_warnings.php" class="nav-item active"><i class="fa-solid fa-triangle-exclamation"></i><span>Warnings</span><span class="badge-count">15</span></a>
    <a href="mod_locked.php" class="nav-item"><i class="fa-solid fa-lock"></i><span>Locked Threads</span></a>
    <div class="nav-section">Account</div>
    <a href="mod_profile.php" class="nav-item"><i class="fa-solid fa-user"></i><span>Profile</span></a>
    <div class="sidebar-bottom">
        <a href="../../../backend/routes/logout.php" class="nav-item"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a>
    </div>
</aside>

<main class="main">
    <div class="topbar">
        <h1>Warnings <span>Management</span></h1>
        <div class="user-pill">
            <div class="avatar"><?=htmlspecialchars($initials)?></div>
            <span><?=htmlspecialchars($userName)?></span>
            <span class="role-badge">Moderator</span>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card warn-card">
            <div class="icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="label">Total Warnings</div><div class="value">15</div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fa-solid fa-fire"></i></div>
            <div class="label">Level 2 (Critical)</div><div class="value">3</div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fa-solid fa-users"></i></div>
            <div class="label">Repeat Offenders</div><div class="value">4</div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fa-solid fa-clock"></i></div>
            <div class="label">Issued Today</div><div class="value">2</div>
        </div>
    </div>

    <div class="new-warning">
        <h3><i class="fa-solid fa-plus" style="color:var(--warn);margin-right:8px;"></i> Issue New Warning</h3>
        <form class="warning-form">
            <div class="form-group">
                <label style="font-size:.85rem;color:var(--text-muted);">User</label>
                <input type="text" class="form-input" placeholder="@username" />
            </div>
            <div class="form-group">
                <label style="font-size:.85rem;color:var(--text-muted);">Level</label>
                <select class="form-select">
                    <option>Level 1 - Verbal</option>
                    <option>Level 2 - Written</option>
                    <option selected>Level 3 - Final</option>
                </select>
            </div>
            <div class="form-group">
                <label style="font-size:.85rem;color:var(--text-muted);">Reason</label>
                <textarea class="form-input form-textarea" placeholder="Describe the violation..."></textarea>
            </div>
            <div style="display:flex;gap:12px;justify-self:start;">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Issue Warning</button>
                <button type="button" class="btn btn-secondary"><i class="fa-solid fa-times"></i> Cancel</button>
            </div>
        </form>
    </div>

    <div class="filters">
        <div class="filters-top">
            <h3 style="font-size:1rem;font-weight:600;">Recent Warnings</h3>
            <div style="font-size:.85rem;color:var(--text-muted);">Showing 1-10 of 15 warnings</div>
        </div>
        <div class="filter-row">
            <button class="filter-btn active">All</button>
            <button class="filter-btn">Level 3</button>
            <button class="filter-btn">Repeat Offenders</button>
            <button class="filter-btn">Today</button>
        </div>
    </div>

    <div class="card">
        <div class="warning-item">
            <div class="warning-avatar">JD</div>
            <div class="warning-content">
                <div class="warning-header">
                    <div class="warning-user">@juan_d - Harassment (3rd warning)</div>
                    <div class="warning-date">2h ago by Moderator</div>
                    <span class="warning-level level-2"><i class="fa-solid fa-triangle-exclamation"></i> Level 3 - Final</span>
                </div>
                <div class="warning-reason">Repeated harassment against barangay officials despite previous warnings. Thread locked.</div>
                <div class="warning-actions">
                    <a href="#" class="btn btn-primary"><i class="fa-solid fa-eye"></i> View Profile</a>
                    <a href="#" class="btn btn-success"><i class="fa-solid fa-check"></i> Dismiss</a>
                    <a href="#" class="btn btn-danger"><i class="fa-solid fa-ban"></i> Ban User</a>
                </div>
            </div>
        </div>

        <div class="warning-item">
            <div class="warning-avatar">S1</div>
            <div class="warning-content">
                <div class="warning-header">
                    <div class="warning-user">@seller123 - Spam</div>
                    <div class="warning-date">4h ago by Moderator</div>
                    <span class="warning-level level-1"><i class="fa-solid fa-circle-exclamation"></i> Level 1</span>
                </div>
                <div class="warning-reason">Multiple spam posts promoting external links. Please follow community guidelines.</div>
                <div class="warning-actions">
                    <a href="#" class="btn btn-primary"><i class="fa-solid fa-eye"></i> View</a>
                    <a href="#" class="btn btn-success"><i class="fa-solid fa-check"></i> Dismiss</a>
                </div>
            </div>
        </div>

        <div class="warning-item">
            <div class="warning-avatar">PC</div>
            <div class="warning-content">
                <div class="warning-header">
                    <div class="warning-user">@pedro_c - Inappropriate Language</div>
                    <div class="warning-date">1d ago by Moderator</div>
                    <span class="warning-level level-1"><i class="fa-solid fa-circle-exclamation"></i> Level 2</span>
                </div>
                <div class="warning-reason">Use of profanity in road repair discussion. Keep discussions civil.</div>
                <div class="warning-actions">
                    <a href="#" class="btn btn-primary"><i class="fa-solid fa-eye"></i> View</a>
                    <a href="#" class="btn btn-success"><i class="fa-solid fa-check"></i> Dismiss</a>
                </div>
            </div>
        </div>
    </div>

    <div class="pagination">
        <button class="page-btn disabled"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="page-btn active">1</button>
        <button class="page-btn">2</button>
        <button class="page-btn"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
</main>

<script>
document.querySelectorAll('.filter-btn').forEach(btn=>{
    btn.onclick=()=>{document.querySelectorAll('.filter-btn').forEach(b=>b.classList.remove('active'));btn.classList.add('active');}
});
</script>
</body>
</html>


