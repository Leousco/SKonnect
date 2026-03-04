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
            --danger:     #f87171;
            --warn:       #fb923c;
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

        .content-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; }
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
    <a href="moderator_dashboard.php" class="nav-item active"><i class="fa-solid fa-shield-halved"></i><span>Dashboard</span></a>
    <a href="reports.php"    class="nav-item"><i class="fa-solid fa-flag"></i><span>Reports</span><span class="badge-count">5</span></a>
    <a href="community.php"  class="nav-item"><i class="fa-solid fa-comments"></i><span>Community Feed</span></a>
    <a href="warnings.php"   class="nav-item"><i class="fa-solid fa-triangle-exclamation"></i><span>Warnings</span></a>
    <a href="locked.php"     class="nav-item"><i class="fa-solid fa-lock"></i><span>Locked Threads</span></a>

    <div class="nav-section">Account</div>
    <a href="profile.php" class="nav-item"><i class="fa-solid fa-user"></i><span>My Profile</span></a>

    <div class="sidebar-bottom">
        <a href="../../../backend/routes/logout.php" class="nav-item">
            <i class="fa-solid fa-right-from-bracket"></i><span>Logout</span>
        </a>
    </div>
</aside>

<main class="main">
    <div class="topbar">
        <h1>Moderator <span>Panel</span></h1>
        <div class="user-pill">
            <div class="avatar"><?= htmlspecialchars($initials) ?></div>
            <span><?= htmlspecialchars($userName) ?></span>
            <span class="role-badge">Moderator</span>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card alert-card">
            <div class="icon"><i class="fa-solid fa-flag"></i></div>
            <div class="label">Pending Reports</div>
            <div class="value">5</div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fa-solid fa-comments"></i></div>
            <div class="label">Active Threads</div>
            <div class="value">38</div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fa-solid fa-lock"></i></div>
            <div class="label">Locked Threads</div>
            <div class="value">4</div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="label">Warnings Issued</div>
            <div class="value">9</div>
        </div>
    </div>

    <div class="content-grid">

        <!-- Pending reports -->
        <div class="card">
            <div class="card-header">
                <h3>Pending Reports</h3>
                <a href="reports.php">View all →</a>
            </div>

            <div class="report-item">
                <div class="report-top">
                    <div class="report-title">Thread: "Is the barangay doing anything?"</div>
                    <span class="badge badge-red">Harassment</span>
                </div>
                <div class="report-meta">Reported by juan_d · 1 hour ago</div>
                <div class="report-reason">Contains targeted insults against SK officials.</div>
                <div class="action-row">
                    <button class="btn-sm btn-accent">View Thread</button>
                    <button class="btn-sm btn-warn">Warn User</button>
                    <button class="btn-sm">Lock Thread</button>
                    <button class="btn-sm btn-danger">Delete</button>
                </div>
            </div>

            <div class="report-item">
                <div class="report-top">
                    <div class="report-title">Post: "Free items, dm me"</div>
                    <span class="badge badge-orange">Spam</span>
                </div>
                <div class="report-meta">Reported by maria_s · 3 hours ago</div>
                <div class="report-reason">Repeated identical posts promoting external links.</div>
                <div class="action-row">
                    <button class="btn-sm btn-accent">View Thread</button>
                    <button class="btn-sm btn-warn">Warn User</button>
                    <button class="btn-sm btn-danger">Delete</button>
                </div>
            </div>

            <div class="report-item">
                <div class="report-top">
                    <div class="report-title">Comment on "Road Repair Concern"</div>
                    <span class="badge badge-red">Inappropriate</span>
                </div>
                <div class="report-meta">Reported by pedro_c · Yesterday</div>
                <div class="report-reason">Off-topic comment with offensive language.</div>
                <div class="action-row">
                    <button class="btn-sm btn-accent">View Thread</button>
                    <button class="btn-sm btn-warn">Warn User</button>
                    <button class="btn-sm btn-danger">Delete</button>
                </div>
            </div>
        </div>

        <!-- Right -->
        <div style="display:flex;flex-direction:column;gap:20px;">
            <div class="card">
                <div class="card-header"><h3>Recent Community Posts</h3><a href="community.php">See all →</a></div>
                <div class="thread-item">
                    <div class="thread-title">When is the next livelihood training?</div>
                    <div class="thread-meta"><span><i class="fa-regular fa-comment"></i> 12 replies</span><span>2 hrs ago</span></div>
                </div>
                <div class="thread-item">
                    <div class="thread-title">Streetlight on Calle Uno is broken</div>
                    <div class="thread-meta"><span><i class="fa-regular fa-comment"></i> 5 replies</span><span>5 hrs ago</span></div>
                </div>
                <div class="thread-item">
                    <div class="thread-title">Lost dog — brown Aspin near purok 3</div>
                    <div class="thread-meta"><span><i class="fa-regular fa-comment"></i> 8 replies</span><span>Yesterday</span></div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h3>Quick Actions</h3></div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <a href="reports.php" class="btn-sm btn-accent" style="text-decoration:none;text-align:center;padding:10px">
                        <i class="fa-solid fa-flag"></i> Review All Reports
                    </a>
                    <a href="community.php" class="btn-sm" style="text-decoration:none;text-align:center;padding:10px">
                        <i class="fa-solid fa-comments"></i> Browse Community Feed
                    </a>
                    <a href="locked.php" class="btn-sm" style="text-decoration:none;text-align:center;padding:10px">
                        <i class="fa-solid fa-lock"></i> Manage Locked Threads
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>