<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require_once __DIR__ . '/../db/db_connect.php';


// Dashboard counts
$totalApplicants = 0;
$activeJobs = 0;
$totalCompanies = 0;

$res = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role IN ('user','applicant')");
if ($res) {
    $totalApplicants = (int)($res->fetch_assoc()['total'] ?? 0);
}

$res = $conn->query("SELECT COUNT(*) AS total FROM jobs WHERE status='active'");
if ($res) {
    $activeJobs = (int)($res->fetch_assoc()['total'] ?? 0);
}

$res = $conn->query("SELECT COUNT(*) AS total FROM companies");
if ($res) {
    $totalCompanies = (int)($res->fetch_assoc()['total'] ?? 0);
}

// Recent jobs (latest 6)
$recentJobs = [];
$rj = $conn->query("
    SELECT 
        j.id,
        j.title,
        COALESCE(c.name, '-') AS company,
        j.created_at,
        j.education,
        j.skills,
        j.location
    FROM jobs j
    LEFT JOIN companies c ON c.id = j.company_id
    ORDER BY j.created_at DESC
    LIMIT 6
");

if ($rj) {
    while ($row = $rj->fetch_assoc()) $recentJobs[] = $row;
}

// Recent activities (latest 8)
$recentActivities = [];
$ra = $conn->query("SELECT type, message, related_id, created_at FROM activities ORDER BY created_at DESC LIMIT 8");
if ($ra) {
    while ($row = $ra->fetch_assoc()) $recentActivities[] = $row;
}

// Applicants list (latest 50) with count of applications
$applicants = [];
$ap = $conn->query("
    SELECT u.id, u.firstname, u.lastname, u.email, u.created_at,
      (SELECT COUNT(*) FROM applications a WHERE a.user_id = u.id) AS applications_count,
      (SELECT GROUP_CONCAT(j.title SEPARATOR ', ') FROM applications a JOIN jobs j ON a.job_id = j.id WHERE a.user_id = u.id) AS applied_jobs
    FROM users u
    WHERE u.role IN ('user','applicant')
    ORDER BY u.created_at DESC
    LIMIT 50
");
if ($ap) {
    while ($row = $ap->fetch_assoc()) $applicants[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel - Call Center Jobs</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        /* Layout: wrapper controls collapsed state so page content stays visible */
        #wrapper {
            display: flex;
            min-height: 100vh;
            transition: all .20s ease;
        }

        #sidebar-wrapper {
            width: 220px;
            flex: 0 0 220px;
            transition: width .20s ease, min-width .20s ease;
            overflow: hidden;
        }

        #page-content-wrapper {
            flex: 1 1 auto;
            transition: margin .20s ease;
        }

        /* Collapsed sidebar */
        #wrapper.collapsed #sidebar-wrapper {
            width: 64px;
            flex: 0 0 64px;
        }

        /* When collapsed, shorten heading and allow small icons/text overflow */
        #sidebar-wrapper .sidebar-heading {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-left: .75rem;
        }

        #sidebar-wrapper .list-group-item {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Keep content readable on narrow sidebar */
        .page-section {
            margin-top: 10px;
        }
Z
        .card-glass {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0.25));
        }

        .list-group-activity {
            max-height: 320px;
            overflow: auto;
        }

        /* small responsive tweak */
        @media (max-width: 768px) {
            #sidebar-wrapper {
                position: absolute;
                z-index: 1030;
                left: -220px;
            }

            #wrapper.open-sidebar #sidebar-wrapper {
                left: 0;
            }

            #page-content-wrapper {
                padding-left: 0;
            }
        }
    </style>
</head>

<body>





    <div id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark text-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 border-bottom border-secondary">
                <h4>KM Services</h4>
            </div>
            <div class="list-group list-group-flush mt-3">
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white active" data-page="dashboard">Dashboard</a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white" data-page="applicants">Applicants</a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-white" data-page="add-job">Add Job</a>
                <a href="../login.php" class="list-group-item list-group-item-action bg-dark text-white">Logout</a>
                <a href="jobs_list.php" class="list-group-item list-group-item-action bg-dark text-white">Manage Jobs</a>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper" class="flex-grow-1">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary px-4">
                <button class="btn btn-outline-light me-3" id="menu-toggle">☰</button>
                <h5 class="text-white mb-0">Admin Dashboard</h5>
                <div class="ms-auto text-white">Welcome, Admin</div>
            </nav>

            <div class="container-fluid py-3 px-4" id="main-content">
                <!-- DASHBOARD PAGE -->
                <div id="dashboard-page" class="page-section">
                    <!-- Dashboard Cards -->
                    <div class="row g-2 mb-2">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-lg h-100 card-glass">
                                <div class="card-body text-center text-white p-3">
                                    <h5 class="card-title text-uppercase mb-2">Total Applicants</h5>
                                    <h1 id="applicants-count"><?php echo $totalApplicants; ?></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-lg h-100 card-glass">
                                <div class="card-body text-center text-white p-3">
                                    <h5 class="card-title text-uppercase mb-2">Active Jobs</h5>
                                    <h1 id="jobs-count"><?php echo $activeJobs; ?></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-lg h-100 card-glass">
                                <div class="card-body text-center text-white p-3">
                                    <h5 class="card-title text-uppercase mb-2">Partner Companies</h5>
                                    <h1 id="companies-count"><?php echo $totalCompanies; ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Overview -->
                    <div class="card mb-2 border-0 shadow-sm">
                        <div class="card-header bg-primary text-white py-2">
                            <h5 class="mb-0">Quick Overview</h5>
                        </div>
                        <div class="card-body py-2">
                            <p class="mb-0">
                                Welcome to your <strong>Call Center Jobs Admin Panel</strong>!
                                Monitor applicants, manage job listings and partner companies.
                            </p>
                        </div>
                    </div>

                    <!-- Recent Job Posts and Activity -->
                    <div class="row g-2">
                        <!-- Recent Job Posts -->
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-success text-white py-2 d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Recent Job Posts</h5>
                                    <a href="jobs_list.php" class="btn btn-sm btn-light">Manage Jobs</a>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Job Title</th>
                                                    <th>Company</th>
                                                    <th>Date Posted</th>
                                                    <th>Education</th>
                                                    <th>Skills</th>
                                                    <th>Location</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (count($recentJobs) === 0): ?>
                                                    <tr>
                                                        <td colspan="3" class="text-center">No recent jobs</td>
                                                    </tr>
                                                <?php else: ?>
                                                    <?php foreach ($recentJobs as $j): ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($j['title']); ?></td>
                                                            <td><?php echo htmlspecialchars($j['company']); ?></td>
                                                            <td><?php echo htmlspecialchars($j['created_at']); ?></td>
                                                            <td><?php echo htmlspecialchars($j['education']); ?></td>
                                                            <td><?php echo htmlspecialchars($j['skills']); ?></td>
                                                            <td><?php echo htmlspecialchars($j['location']); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activities -->
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-info text-white py-2">
                                    <h5 class="mb-0">Recent Activities</h5>
                                </div>
                                <div class="card-body py-2">
                                    <ul id="activities-list" class="list-group list-group-flush small list-group-activity">
                                        <?php if (count($recentActivities) === 0): ?>
                                            <li class="list-group-item">No recent activity</li>
                                        <?php else: ?>
                                            <?php foreach ($recentActivities as $act): ?>
                                                <li class="list-group-item">
                                                    <?php
                                                    $icon = '🔵';
                                                    if ($act['type'] === 'new_user') $icon = '🟢';
                                                    if ($act['type'] === 'job_post') $icon = '🟢';
                                                    if ($act['type'] === 'job_update') $icon = '🟠';
                                                    if ($act['type'] === 'job_delete') $icon = '🔴';
                                                    ?>
                                                    <?php echo $icon; ?> <?php echo htmlspecialchars($act['message']); ?>
                                                    <div class="text-muted small"><?php echo htmlspecialchars($act['created_at']); ?></div>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- APPLICANTS PAGE -->


















                <div id="applicants-page" class="page-section d-none">
                    <div class="card shadow-lg border-0 bg-white">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2">
                            <h5 class="mb-0">Applicants</h5>
                            <input type="text" id="searchApplicant" class="form-control w-25" placeholder="Search by name...">
                        </div>




                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Applied Jobs</th>
                                            <th>Email</th>
                                            <th>Joined</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="applicant-table">
                                        <?php if (count($applicants) === 0): ?>
                                            <tr>
                                                <td colspan="4" class="text-center">No applicants yet</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($applicants as $a): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars(trim($a['firstname'] . ' ' . $a['lastname'])); ?></td>
                                                    <td><?php echo htmlspecialchars($a['applied_jobs'] ?: ($a['applications_count'] ? $a['applications_count'] . ' application(s)' : '—')); ?></td>
                                                    <td><?php echo htmlspecialchars($a['email']); ?></td>
                                                    <td><?php echo htmlspecialchars($a['created_at']); ?></td>
                                                
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ADD JOB PAGE -->
                <div id="add-job-page" class="page-section d-none">
                    <div class="card shadow-lg border-0 bg-white">
                        <div class="card-header bg-success text-white py-2">
                            <h5 class="mb-0">Post a New Job</h5>
                        </div>
                        <div class="card-body py-3">
                            <form id="addJobForm" method="POST" action="job_store.php" enctype="multipart/form-data">
                                <div class="mb-2">
                                    <label class="form-label">Company Name</label>
                                    <input type="text" class="form-control" name="company_name" placeholder="e.g. IQOR Pampanga" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Job Title</label>
                                    <input type="text" class="form-control" name="job_title" placeholder="e.g. Customer Service Representative" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Job Description</label>
                                    <textarea class="form-control" rows="3" name="job_description" placeholder="Enter job details..." required></textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Requirements</label>
                                    <textarea class="form-control" rows="3" name="job_requirements" placeholder="List requirements..." required></textarea>
                                </div>
                                 <div class="mb-2">
                                    <label class="form-label">Education</label>
                                    <textarea class="form-control" rows="3" name="job_education" placeholder="List education requirements..." required></textarea>
                                </div>
                                 <div class="mb-2">
                                    <label class="form-label">Skills</label>
                                    <textarea class="form-control" rows="3" name="job_skills" placeholder="List skills requirements..." required></textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Location</label>
                                    <textarea class="form-control" rows="3" name="job_location" placeholder="List location requirements..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm">Post Job</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>




    <script src="../js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar navigation
        document.querySelectorAll('#sidebar-wrapper .list-group-item').forEach(el => {
            el.addEventListener('click', function(e) {
                const page = this.getAttribute('data-page');
                if (!page) return; // allow normal links (Manage Jobs, Logout) to work
                e.preventDefault();
                document.querySelectorAll('.page-section').forEach(s => s.classList.add('d-none'));
                document.querySelectorAll('#sidebar-wrapper .list-group-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                const target = document.getElementById(page + '-page');
                if (target) target.classList.remove('d-none');
            });
        });

        // Toggle sidebar: toggle collapsed class on #wrapper (prevents content overlap)
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('wrapper').classList.toggle('collapsed');
        });

        // Simple applicant search (client-side)
        document.getElementById('searchApplicant').addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#applicant-table tr').forEach(row => {
                const name = row.children[0]?.textContent?.toLowerCase() ?? '';
                row.style.display = name.includes(q) ? '' : 'none';
            });
        });

        // Poll dashboard counts and recent activities every 8s
        function refreshDashboard() {
            // counts
            fetch('../api/dashboard_counts.php')
                .then(r => r.json())
                .then(data => {
                    document.getElementById('applicants-count').textContent = data.total_applicants ?? '0';
                    document.getElementById('jobs-count').textContent = data.active_jobs ?? '0';
                    document.getElementById('companies-count').textContent = data.companies ?? '0';
                }).catch(() => {});

            // new activities
            fetch('../api/recent_activities.php').then(r => {
                if (!r.ok) return;
                return r.json();
            }).then(items => {
                if (!items) return;
                const ul = document.getElementById('activities-list');
                ul.innerHTML = '';
                items.forEach(act => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    let icon = '🔵';
                    if (act.type === 'new_user') icon = '🟢';
                    if (act.type === 'job_post') icon = '🟢';
                    if (act.type === 'job_update') icon = '🟠';
                    if (act.type === 'job_delete') icon = '🔴';
                    li.innerHTML = `${icon} ${act.message} <div class="text-muted small">${act.created_at}</div>`;
                    ul.appendChild(li);
                });
            }).catch(() => {});
        }

        // Initial last user count to avoid false notifications
        let lastUserCount = <?php echo $totalApplicants; ?>;

        // Check new users (used to prepend small notification)
        function checkNewUsers() {
            fetch('../check_new_users.php')
                .then(r => r.json())
                .then(data => {
                    const total = data.total ?? 0;
                    const latest_user = data.latest_user ?? '';
                    if (lastUserCount && total > lastUserCount && latest_user) {
                        const ul = document.getElementById('activities-list');
                        const li = document.createElement('li');
                        li.className = 'list-group-item';
                        li.innerHTML = `🟢 New user registered: <strong>${latest_user}</strong>`;
                        ul.prepend(li);
                        if (ul.children.length > 10) ul.removeChild(ul.lastChild);
                    }
                    lastUserCount = total;
                }).catch(() => {});
        }

        // Initial refresh and polling
        refreshDashboard();
        checkNewUsers();
        setInterval(() => {
            refreshDashboard();
            checkNewUsers();
        }, 8000);
    </script>
</body>

</html>