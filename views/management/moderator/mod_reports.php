<?php
require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireRole('moderator');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | Moderator Panel</title>
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="../../../styles/public/community.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:         #0f0f14;
            --surface:    #18181f;
            --surface2:   #1f1f28;
            --border:     #2e2e3a;
            --accent:     #a78bfa;
            --accent-dim: #2d1f5e;
            --danger:     #f75959;
            --warn:       #fb923c;
            --resolve:    #28c95e;
            --text:       #e2e8f0;
            --text-muted: #94a3b8;
            --radius:     12px;
        }

        body { font-family: 'Segoe UI', system-ui, sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

        .sidebar {
            position: fixed; top: 0; left: 0;
            width: 240px; height: 100vh;
            background: var(--surface); border-right: 1px solid var(--border);
            display: flex; flex-direction: column; padding: 24px 0; z-index: 100;
        }
        .sidebar-logo { font-size: 1.4rem; font-weight: 700; color: var(--accent); padding: 0 24px 24px; border-bottom: 1px solid var(--border); }
        .sidebar-logo span { color: var(--text-muted); font-weight: 400; font-size: .75rem; display: block; margin-top: 2px; }
        .nav-section { padding: 20px 12px 8px; font-size: .7rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); }
        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 24px; font-size: .9rem; color: var(--text-muted);
            text-decoration: none; transition: color .15s, background .15s;
            cursor: pointer; border: none; background: none; width: 100%; text-align: left;
        }
        .nav-item:hover  { color: var(--text); background: var(--surface2); }
        .nav-item.active { color: var(--accent); background: var(--accent-dim); font-weight: 600; }
        .nav-item i { width: 18px; text-align: center; }
        .badge-count {
            margin-left: auto; background: var(--danger); color: #fff;
            font-size: .68rem; font-weight: 700; border-radius: 50px;
            padding: 1px 7px; min-width: 20px; text-align: center;
        }
        .sidebar-bottom { margin-top: auto; border-top: 1px solid var(--border); padding-top: 16px; }

        .main { margin-left: 240px; padding: 32px; }

        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
        .topbar h1 { font-size: 1.5rem; font-weight: 700; }
        .topbar h1 span { color: var(--accent); }
        .user-pill {
            display: flex; align-items: center; gap: 10px;
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 50px; padding: 8px 16px; font-size: .88rem;
        }
        .user-pill .avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: var(--accent-dim); color: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: .8rem;
        }
        .role-badge { font-size: .7rem; background: var(--accent-dim); color: var(--accent); padding: 2px 8px; border-radius: 50px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin-bottom: 28px; }
        .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px; }
        .stat-card .label { font-size: .8rem; color: var(--text-muted); margin-bottom: 8px; }
        .stat-card .value { font-size: 2rem; font-weight: 700; }
        .stat-card.alert-card { border-color: var(--danger); }
        .stat-card.alert-card .value { color: var(--danger); }
        .stat-card .icon { float: right; font-size: 1.4rem; color: var(--text-muted); margin-top: -4px; }

        .content-grid { display: grid; grid-template-columns: 1fr 10px; gap: 20px; }
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 22px; }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
        .card-header h3 { font-size: 1rem; font-weight: 600; }
        .card-header a { font-size: .8rem; color: var(--accent); text-decoration: none; }

        .report-item { padding: 14px 0; border-bottom: 1px solid var(--border); }
        .report-item:last-child { border-bottom: none; }
        .report-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px; }
        .report-title { font-size: .9rem; font-weight: 600; }
        .report-meta  { font-size: .78rem; color: var(--text-muted); }
        .report-reason { font-size: .8rem; color: var(--text-muted); margin-bottom: 10px; }
        .action-row { display: flex; gap: 8px; flex-wrap: wrap; }
        .btn-sm {
            font-size: .75rem; padding: 5px 12px; border-radius: 6px; border: 1px solid var(--border);
            cursor: pointer; background: var(--surface2); color: var(--text); transition: background .15s, border-color .15s;
        }
        .btn-sm:hover      { background: var(--surface); }
        .btn-sm.btn-danger { border-color: var(--danger); color: var(--danger); }
        .btn-sm.btn-danger:hover { background: rgba(248,113,113,.1); }
        .btn-sm.btn-warn   { border-color: var(--warn); color: var(--warn); }
        .btn-sm.btn-warn:hover { background: rgba(251,146,60,.1); }
        .btn-sm.btn-accent { border-color: var(--accent); color: var(--accent); }
        .btn-sm.btn-accent:hover { background: var(--accent-dim); }

        .thread-item { padding: 12px 0; border-bottom: 1px solid var(--border); }
        .thread-item:last-child { border-bottom: none; }
        .thread-title { font-size: .88rem; font-weight: 600; margin-bottom: 3px; }
        .thread-meta  { font-size: .75rem; color: var(--text-muted); display: flex; gap: 12px; }

        .badge { font-size: .72rem; padding: 3px 10px; border-radius: 50px; font-weight: 600; }
        .badge-red    { background: rgba(248,113,113,.15); color: var(--danger); }
        .badge-orange { background: rgba(251,146,60,.15);  color: var(--warn); }
        .badge-purple { background: var(--accent-dim);     color: var(--accent); }
           .filters{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:20px;margin-bottom:24px;}
        .filters-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;}
        .filter-row{display:flex;gap:12px;flex-wrap:wrap;}
        
        .filter-btn{padding:8px 16px;border:1px solid var(--border);background:var(--surface2);color:var(--text-muted);border-radius:8px;font-size:.85rem;cursor:pointer;transition:all .15s;}
        .filter-btn:hover{background:var(--surface);border-color:var(--accent);color:var(--text);}
        .filter-btn.active{background:var(--accent);color:#fff;border-color:var(--accent);}
.filter-btn.view{background:var(--accent);color:#fff;border-color:var(--accent);font-size:11px;}
.filter-btn.warn{background:var(--warn);color:#fff;border-color:var(--accent);font-size:11px;}
.filter-btn.danger{background:#f84848;;color:#fff;border-color:var(--accent);font-size:11px;}
.filter-btn.resolve{background:var(--resolve);;color:#fff;border-color:var(--accent);font-size:11px;}

        @media (max-width: 900px) {
            .sidebar { width: 60px; }
            .sidebar-logo, .nav-section, .nav-item span, .badge-count { display: none; }
            .nav-item { justify-content: center; padding: 12px; }
            .main { margin-left: 60px; }
            .content-grid { grid-template-columns: 1fr; }
        }
</style>
</head>
<body>
<?php

$userName = $_SESSION['user_name'] ?? 'Moderator';
$initials = implode('', array_map(fn($w) => strtoupper($w[0]), explode(' ', $userName)));
?>

<aside class="sidebar">
    <div class="sidebar-logo">SKonnect <span>Moderator Panel</span></div>

    <div class="nav-section">Moderation</div>
    <a href="mod_dashboard.php" class="nav-item "><i class="fa-solid fa-shield-halved"></i><span>Dashboard</span></a>
    <a href="mod_reports.php"    class="nav-item active"><i class="fa-solid fa-flag"></i><span>Reports</span><span class="badge-count">1</span></a>
    <a href="mod_community.php"  class="nav-item"><i class="fa-solid fa-comments"></i><span>Community Feed</span></a>
    <a href="mod_warnings.php"   class="nav-item"><i class="fa-solid fa-triangle-exclamation"></i><span>Warnings</span></a>
    <a href="mod_locked.php"     class="nav-item"><i class="fa-solid fa-lock"></i><span>Locked Threads</span></a>

    <div class="nav-section">Account</div>
    <a href="mod_profile.php" class="nav-item"><i class="fa-solid fa-user"></i><span>My Profile</span></a>

    <div class="sidebar-bottom">
        <a href="../../../backend/routes/logout.php" class="nav-item">
            <i class="fa-solid fa-right-from-bracket"></i><span>Logout</span>
        </a>
    </div>
</aside>

<main class="main">
    <div class="topbar">
        <h1> Reports <span>Panel</span></h1>
        <div class="user-pill">
            <div class="avatar"><?= htmlspecialchars($initials) ?></div>
            <span><?= htmlspecialchars($userName) ?></span>
            <span class="role-badge">Moderator</span>
        </div>
    </div>


    <div class="filters">
        <div class="filters-top">
            <h3 style="font-size:1rem;font-weight:600;">Filters</h3>
            <div style="font-size:.85rem;color:var(--text-muted);">1-10 of 12 reports</div>
        </div>
        <div class="filter-row">
            <button class="filter-btn active">All</button>
            <button class="filter-btn">Harassment</button>
            <button class="filter-btn">Spam</button>
            <button class="filter-btn">Pending</button>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 style="font-size:1rem;font-weight:600;">Recent Reports</h3>
            <div style="display:flex;gap:12px;">
                <a href="#" class="btn btn-accent"><i class="fa-solid fa-file-export"></i>Export</a>
                <a href="#" class="btn"><i class="fa-solid fa-plus"></i>Bulk</a>
            </div>
        </div>

        <div class="report-item">
            <div class="report-top">
                <div class="report-title">Thread: "Barangay officials are useless!"</div>
                <span class="badge badge-red">Harassment</span>
            </div>
            <div class="report-meta">by juan_d · 2h ago</div>
            <div class="report-details">
                <div class="report-user">
                    <div class="user-avatar">JD</div>
                    <span>Target: @sk_official</span>
                </div>
            </div>
            <div class="report-reason">Repeated personal attacks against officials with threatening language.</div>
            <div class="action-row">
                <a href="#" class="filter-btn view"><i class="fa-solid fa-eye"></i>View</a>
                <a href="#" class="filter-btn warn"><i class="fa-solid fa-triangle-exclamation"></i>Warn</a>
                <a href="#" class="filter-btn danger"><i class="fa-solid fa-trash"></i>Delete</a>
                <a href="#" class="filter-btn resolve"><i class="fa-solid fa-check"></i>Resolve</a>
            </div>
        </div>

        <div class="report-item">
            <div class="report-top">
                <div class="report-title">"DM me for cheap phones!"</div>
                <span class="badge badge-orange">Spam</span>
            </div>
            <div class="report-meta">by maria_s · 4h ago</div>
            <div class="report-details">
                <div class="report-user">
                    <div class="user-avatar">MS</div>
                    <span>By: @seller123</span>
                </div>
            </div>
            <div class="report-reason">Identical spam posts across multiple threads with external links.</div>
            <div class="action-row">
                <a href="#" class="filter-btn view"><i class="fa-solid fa-eye"></i>View</a>
                <a href="#" class="filter-btn warn"><i class="fa-solid fa-triangle-exclamation"></i>Warn</a>
                <a href="#" class="filter-btn danger"><i class="fa-solid fa-trash"></i>Delete</a>
                <a href="#" class="filter-btn resolve"><i class="fa-solid fa-check"></i>Resolve</a>
            </div>
        </div>

        <div class="report-item">
            <div class="report-top">
                <div class="report-title">Comment on "Road concerns"</div>
                <span class="badge badge-red">Inappropriate</span>
            </div>
            <div class="report-meta">by pedro_c · 1d ago</div>
            <div class="report-details">
                <div class="report-user">
                    <div class="user-avatar">PC</div>
                    <span>By: @troll_user</span>
                </div>
            </div>
            <div class="report-reason">Contains profanity and off-topic personal attacks.</div>
            <div class="action-row">
                <a href="#" class="filter-btn view"><i class="fa-solid fa-eye"></i>View</a>
                <a href="#" class="filter-btn warn"><i class="fa-solid fa-triangle-exclamation"></i>Warn</a>
                <a href="#" class="filter-btn danger"><i class="fa-solid fa-trash"></i>Delete</a>
                <a href="#" class="filter-btn resolve"><i class="fa-solid fa-check"></i>Resolve</a>
            </div>
        </div>

         <div class="report-item">
            <div class="report-top">
                <div class="report-title">Comment on "Light Road Concern"</div>
                <span class="badge badge-red">Inappropriate</span>
            </div>
            <div class="report-meta">by pedro_c · 1d ago</div>
            <div class="report-details">
                <div class="report-user">
                    <div class="user-avatar">PC</div>
                    <span>By: @troll_user</span>
                </div>
            </div>
            <div class="report-reason">Contains profanity and off-topic personal attacks.</div>
            <div class="action-row">
                <a href="#" class="filter-btn view"><i class="fa-solid fa-eye"></i>View</a>
                <a href="#" class="filter-btn warn"><i class="fa-solid fa-triangle-exclamation"></i>Warn</a>
                <a href="#" class="filter-btn danger"><i class="fa-solid fa-trash"></i>Delete</a>
                <a href="#" class="filter-btn resolve"><i class="fa-solid fa-check"></i>Resolve</a>
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


