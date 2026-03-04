<?php

require_once __DIR__ . '/../../../backend/middleware/RoleMiddleware.php';
RoleMiddleware::requireRole('sk_officer');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SKonnect | SK Officer Portal</title>
    <link rel="stylesheet" href="../../styles/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:         #0a0e1a;
            --surface:    #111827;
            --surface2:   #1a2235;
            --border:     #1e2d45;
            --accent:     #38bdf8;
            --accent-dim: #0c2d45;
            --success:    #34d399;
            --warn:       #fbbf24;
            --text:       #f1f5f9;
            --text-muted: #94a3b8;
            --radius:     12px;
        }

        body { font-family: 'Segoe UI', system-ui, sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

        .sidebar {
            position: fixed; top: 0; left: 0; width: 240px; height: 100vh;
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
        .badge-count { margin-left: auto; background: var(--warn); color: #000; font-size: .68rem; font-weight: 700; border-radius: 50px; padding: 1px 7px; }
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
        .user-pill .avatar { width: 30px; height: 30px; border-radius: 50%; background: var(--accent-dim); color: var(--accent); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: .8rem; }
        .role-badge { font-size: .7rem; background: var(--accent-dim); color: var(--accent); padding: 2px 8px; border-radius: 50px; font-weight: 600; text-transform: uppercase; }

        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px,1fr)); gap: 16px; margin-bottom: 28px; }
        .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px; }
        .stat-card .label { font-size: .8rem; color: var(--text-muted); margin-bottom: 8px; }
        .stat-card .value { font-size: 2rem; font-weight: 700; }
        .stat-card .icon  { float: right; font-size: 1.4rem; color: var(--text-muted); margin-top: -4px; }
        .stat-card.highlight { border-color: var(--warn); }
        .stat-card.highlight .value { color: var(--warn); }

        .content-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 22px; }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; }
        .card-header h3 { font-size: 1rem; font-weight: 600; }
        .card-header a { font-size: .8rem; color: var(--accent); text-decoration: none; }

        /* Analytics bars */
        .analytics-row { margin-bottom: 14px; }
        .analytics-label { display: flex; justify-content: space-between; font-size: .82rem; margin-bottom: 5px; }
        .analytics-label span:last-child { color: var(--text-muted); }
        .bar-track { height: 6px; background: var(--surface2); border-radius: 50px; overflow: hidden; }
        .bar-fill  { height: 100%; border-radius: 50px; background: var(--accent); transition: width .4s; }

        /* Request items */
        .req-item { display: flex; align-items: center; gap: 14px; padding: 12px 0; border-bottom: 1px solid var(--border); }
        .req-item:last-child { border-bottom: none; }
        .req-icon { width: 36px; height: 36px; border-radius: 8px; background: var(--accent-dim); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: .9rem; flex-shrink: 0; }
        .req-info { flex: 1; }
        .req-info .name { font-size: .88rem; font-weight: 600; }
        .req-info .sub  { font-size: .75rem; color: var(--text-muted); }
        .badge { font-size: .72rem; padding: 3px 10px; border-radius: 50px; font-weight: 600; }
        .badge-warn  { background: rgba(251,191,36,.15); color: var(--warn); }
        .badge-blue  { background: rgba(56,189,248,.15);  color: var(--accent); }
        .badge-green { background: rgba(52,211,153,.15);  color: var(--success); }

        /* Announcement list */
        .ann-item { padding: 12px 0; border-bottom: 1px solid var(--border); }
        .ann-item:last-child { border-bottom: none; }
        .ann-title { font-size: .88rem; font-weight: 600; margin-bottom: 3px; }
        .ann-meta  { font-size: .75rem; color: var(--text-muted); }

        .btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 8px; font-size: .85rem; font-weight: 600; cursor: pointer; transition: all .15s; text-decoration: none; border: none; }
        .btn-primary { background: var(--accent); color: #000; }
        .btn-primary:hover { opacity: .85; }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text); }
        .btn-outline:hover { border-color: var(--accent); color: var(--accent); }

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

$userName = $_SESSION['user_name'] ?? 'SK Officer';
$initials = implode('', array_map(fn($w) => strtoupper($w[0]), explode(' ', $userName)));
?>

<aside class="sidebar">
    <div class="sidebar-logo">SKonnect <span>SK Officer Portal</span></div>

    <div class="nav-section">Management</div>
    <a href="officer_dashboard.php" class="nav-item active"><i class="fa-solid fa-gauge-high"></i><span>Dashboard</span></a>
    <a href="announcements_mgmt.php" class="nav-item"><i class="fa-solid fa-bullhorn"></i><span>Announcements</span></a>
    <a href="services_mgmt.php"      class="nav-item"><i class="fa-solid fa-gears"></i><span>Services</span><span class="badge-count">8</span></a>
    <a href="requests_mgmt.php"      class="nav-item"><i class="fa-solid fa-inbox"></i><span>Requests</span></a>
    <a href="events_mgmt.php"        class="nav-item"><i class="fa-solid fa-calendar-days"></i><span>Events</span></a>

    <div class="nav-section">Insights</div>
    <a href="analytics.php" class="nav-item"><i class="fa-solid fa-chart-line"></i><span>Analytics</span></a>
    <a href="reports_mgmt.php" class="nav-item"><i class="fa-solid fa-file-chart-column"></i><span>Reports</span></a>

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
        <h1>SK Officer <span>Portal</span></h1>
        <div class="user-pill">
            <div class="avatar"><?= htmlspecialchars($initials) ?></div>
            <span><?= htmlspecialchars($userName) ?></span>
            <span class="role-badge">SK Officer</span>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card highlight">
            <div class="icon"><i class="fa-solid fa-inbox"></i></div>
            <div class="label">Pending Requests</div>
            <div class="value">8</div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fa-solid fa-bullhorn"></i></div>
            <div class="label">Active Announcements</div>
            <div class="value">3</div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fa-solid fa-gears"></i></div>
            <div class="label">Available Services</div>
            <div class="value">6</div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fa-solid fa-users"></i></div>
            <div class="label">Total Residents</div>
            <div class="value">124</div>
        </div>
    </div>

    <div class="content-grid">

        <!-- Pending service requests -->
        <div class="card">
            <div class="card-header">
                <h3>Pending Service Requests</h3>
                <a href="requests_mgmt.php">Manage all →</a>
            </div>
            <div class="req-item">
                <div class="req-icon"><i class="fa-solid fa-file-lines"></i></div>
                <div class="req-info">
                    <div class="name">Barangay Clearance — Pedro Cruz</div>
                    <div class="sub">Submitted 1 hour ago</div>
                </div>
                <span class="badge badge-warn">Pending</span>
            </div>
            <div class="req-item">
                <div class="req-icon"><i class="fa-solid fa-house"></i></div>
                <div class="req-info">
                    <div class="name">Certificate of Residency — Ana Reyes</div>
                    <div class="sub">Submitted 2 hours ago</div>
                </div>
                <span class="badge badge-blue">Processing</span>
            </div>
            <div class="req-item">
                <div class="req-icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
                <div class="req-info">
                    <div class="name">Indigency Certificate — Jose Lim</div>
                    <div class="sub">Submitted Yesterday</div>
                </div>
                <span class="badge badge-warn">Pending</span>
            </div>
            <div class="req-item">
                <div class="req-icon"><i class="fa-solid fa-file-lines"></i></div>
                <div class="req-info">
                    <div class="name">Barangay Clearance — Maria Santos</div>
                    <div class="sub">Submitted Yesterday</div>
                </div>
                <span class="badge badge-green">Approved</span>
            </div>
            <div style="margin-top:16px;">
                <a href="requests_mgmt.php" class="btn btn-primary"><i class="fa-solid fa-inbox"></i> Manage Requests</a>
            </div>
        </div>

        <!-- Analytics overview -->
        <div class="card">
            <div class="card-header">
                <h3>Service Analytics (This Month)</h3>
                <a href="analytics.php">Full report →</a>
            </div>
            <div class="analytics-row">
                <div class="analytics-label"><span>Barangay Clearance</span><span>42 requests</span></div>
                <div class="bar-track"><div class="bar-fill" style="width:85%"></div></div>
            </div>
            <div class="analytics-row">
                <div class="analytics-label"><span>Certificate of Residency</span><span>28 requests</span></div>
                <div class="bar-track"><div class="bar-fill" style="width:56%"></div></div>
            </div>
            <div class="analytics-row">
                <div class="analytics-label"><span>Indigency Certificate</span><span>15 requests</span></div>
                <div class="bar-track"><div class="bar-fill" style="width:30%"></div></div>
            </div>
            <div class="analytics-row">
                <div class="analytics-label"><span>Business Permit Support</span><span>9 requests</span></div>
                <div class="bar-track"><div class="bar-fill" style="width:18%"></div></div>
            </div>
        </div>

        <!-- Announcements management -->
        <div class="card">
            <div class="card-header">
                <h3>Recent Announcements</h3>
                <a href="announcements_mgmt.php">Manage →</a>
            </div>
            <div class="ann-item">
                <div class="ann-title">Community Clean-up Drive</div>
                <div class="ann-meta">Published · Mar 3, 2026</div>
            </div>
            <div class="ann-item">
                <div class="ann-title">Barangay Assembly — March 10</div>
                <div class="ann-meta">Published · Mar 2, 2026</div>
            </div>
            <div class="ann-item">
                <div class="ann-title">Livelihood Training Program</div>
                <div class="ann-meta">Published · Mar 1, 2026</div>
            </div>
            <div style="margin-top:16px;">
                <a href="announcements_mgmt.php?action=new" class="btn btn-primary"><i class="fa-solid fa-plus"></i> New Announcement</a>
            </div>
        </div>

        <!-- Quick actions -->
        <div class="card">
            <div class="card-header"><h3>Quick Actions</h3></div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                <a href="services_mgmt.php?action=new" class="btn btn-outline"><i class="fa-solid fa-plus"></i> Add Service</a>
                <a href="events_mgmt.php?action=new"   class="btn btn-outline"><i class="fa-solid fa-calendar-plus"></i> Add Event</a>
                <a href="analytics.php"                class="btn btn-outline"><i class="fa-solid fa-chart-line"></i> View Analytics</a>
                <a href="reports_mgmt.php"             class="btn btn-outline"><i class="fa-solid fa-download"></i> Export Reports</a>
            </div>
        </div>
    </div>
</main>
</body>
</html>