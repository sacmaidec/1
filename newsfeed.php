<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$firstname = $_SESSION['firstname'] ?? '';
$email = $_SESSION['email'] ?? '';
$user_id = $_SESSION['user_id'];   // logged in user


// ===============================
// ✅ FETCH JOBS USER APPLIED FOR
// ===============================
$appliedData = file_get_contents("http://localhost/finals/api/get_applied_jobs.php?user_id=" . $user_id);
$appliedJobs = json_decode($appliedData, true);

// Fix null issue
$appliedIds = [];
if (!empty($appliedJobs) && is_array($appliedJobs)) {
    $appliedIds = array_column($appliedJobs, 'job_id');
}


// ===============================
// ✅ FETCH ALL JOBS
// ===============================
$data = file_get_contents("http://localhost/finals/api/jobs.php");
$jobs = json_decode($data, true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Job Feed | KM Services</title>

  <style>
    body {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      background: #fff;
      color: #000;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 50px;
      border-bottom: 1px solid #ccc;
      background: #fff;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .logo {
      font-weight: bold;
      font-size: 20px;
      color: #000000ff;
    }
    .navbar a {
      text-decoration: none;
      color: #333;
      font-size: 15px;
      padding: 0 15px;
    }
    .navbar a:hover {
      color: #0078d7;
    }

    .feed-container {
      display: flex;
      gap: 30px;
      padding: 40px 50px;
    }

    .sidebar {
      width: 30%;
    }

    .search-bar input {
      width: 100%;
      padding: 12px;
      border-radius: 6px;
      border: 1px solid #ccc;
      margin-bottom: 20px;
    }

    .sort-buttons button {
      background: #e0f2f2;
      border: 1px solid #008080;
      color: #008080;
      padding: 8px 15px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 500;
      transition: 0.2s;
      margin-right: 5px;
    }

    .sort-buttons button.active {
      background: #008080;
      color: white;
    }

    .main-content {
      flex: 1;
      background: #f9fafb;
      border-radius: 10px;
      padding: 30px;
      min-height: 400px;
    }

    .job-card {
      background: #fff;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      margin-bottom: 20px;
      transition: 0.2s;
    }
    .job-card:hover {
      transform: translateY(-4px);
    }

    .apply-btn {
      margin-top: 15px;
      padding: 10px 18px;
      background: #0e9b83;
      border: none;
      color: #fff;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.2s;
    }
    .apply-btn:hover {
      background: #0c8a74;
    }

    .apply-btn.applied {
      background: #bfbfbf !important;
      color: #666 !important;
      pointer-events: none;
      cursor: default;
    }

    .jobs-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 40px;
    }

    .user-menu {
      position: absolute;
      right: 20px;
      top: 18px;
    }
    .user-icon img {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      cursor: pointer;
    }
    .dropdown-menu {
      display: none;
      position: absolute;
      right: 0;
      top: 40px;
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 8px;
      width: 200px;
      padding: 10px 0;
      z-index: 1000;
    }
    .dropdown-menu a {
      display: block;
      padding: 10px 15px;
      text-decoration: none;
      color: #333;
    }
    .dropdown-menu a:hover {
      background: #f3f3f3;
    }
    /* MODAL OVERLAY */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 2000;
}

/* MODAL BOX */
.modal-box {
    background: white;
    width: 450px;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    animation: pop 0.2s ease-out;
}

.close-btn {
    float: right;
    font-size: 26px;
    cursor: pointer;
    margin-top: -10px;
}

@keyframes pop {
    from { transform: scale(0.8); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
.details-btn {
    margin-top: 10px;
    padding: 9px 15px;
    background: #008080;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.2s;
}
.details-btn:hover {
    background: #006d6d;
}


  </style>
</head>
<body>

<header>
    <div class="logo">KM Services</div>

    <nav class="navbar">
        <a href="newsfeed.php">Home</a>
        <a href="about.php">About Us</a>
    </nav>

    <div class="user-menu">
        <div class="user-icon" onclick="toggleMenu()">
            <img src="img/icon.jpg" alt="User Icon" />
        </div>
        <div class="dropdown-menu" id="dropdownMenu">
            <div class="user-email"><?php echo htmlspecialchars($email); ?></div>
            <a href="profile.php">📄 Profile</a>
            <a href="letsconnect.php">❓ Contact Us</a>
            <a href="logout.php">Sign out</a>
        </div>
    </div>
</header>

<div class="feed-container">

    <div class="sidebar">
      <h3>Find Jobs</h3>
      <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search...">
      </div>

      <h3>Sort by</h3>
      <div class="sort-buttons">
        <button class="active">Relevance</button>
        <button>Date</button>
        <button>Salary</button>
      </div>
    </div>

  <div class="main-content">
    <div class="jobs-container">

        <?php if (empty($jobs)): ?>
            <p>No Jobs Posted.</p>
        <?php else: ?>
            <?php foreach ($jobs as $job): ?>

                <?php 
                    $applied = in_array($job['id'], $appliedIds);
                ?>

                <div class="job-card" onclick="openJobDetails(<?= $job['id']; ?>)">

                    <h3><?= htmlspecialchars($job['title']); ?></h3>
                    <p><?= htmlspecialchars($job['description']); ?></p>
                    <p><strong>Status:</strong> <?= htmlspecialchars($job['status']); ?></p>
                    <p><strong>Posted:</strong> <?= htmlspecialchars($job['created_at']); ?></p>

                    <!-- View Details Button -->
                    <button class="details-btn"
                        onclick="event.stopPropagation(); openJobDetails(<?= $job['id']; ?>)">
                        View Details
                    </button>

                    <!-- Apply Button -->
                    <button 
                        onclick="event.stopPropagation(); applyJob(this, <?= $job['id']; ?>)" 
                        class="apply-btn <?= $applied ? 'applied' : '' ?>"
                        <?= $applied ? 'disabled' : '' ?>
                    >
                        <?= $applied ? "Applied" : "Apply" ?>
                    </button>

                </div>

            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>

</div>
<!-- JOB DETAILS MODAL -->
<div id="jobModal" class="modal-overlay" style="display:none;">
    <div class="modal-box">
        <span class="close-btn" onclick="closeModal()">&times;</span>

        <h2 id="modalTitle"></h2>
        <p id="modalDescription"></p>

        <hr>

        <p><strong>Education:</strong> <span id="modalEducation"></span></p>
        <p><strong>Skills:</strong> <span id="modalSkills"></span></p>
        <p><strong>Location:</strong> <span id="modalLocation"></span></p>

        <hr>

        <p><strong>Status:</strong> <span id="modalStatus"></span></p>
        <p><strong>Posted:</strong> <span id="modalDate"></span></p>
    </div>
</div>

<script>
function toggleMenu() {
    const menu = document.getElementById("dropdownMenu");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}

// Apply job function
function applyJob(button, jobId) {

    fetch("http://localhost/finals/api/apply_job.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ job_id: jobId }),
        credentials: "same-origin"
    })
    .then(res => res.json())
    .then(res => {

        if (res.status === "success" || res.status === "already_applied") {
            button.innerText = "Applied";
            button.classList.add("applied");
            button.disabled = true;
        } else {
            alert("Error: " + JSON.stringify(res));
        }
    })
    .catch(err => {
        alert("Network error");
        console.log(err);
    });
}
// OPEN MODAL WITH JOB DETAILS
function openJobDetails(jobId) {
    fetch("http://localhost/finals/admin/job_details.php?id=" + jobId)
    .then(res => res.json())
    .then(job => {

        document.getElementById("modalTitle").innerText = job.title;
        document.getElementById("modalDescription").innerText = job.description;
        document.getElementById("modalEducation").innerText = job.education || "Not specified";
        document.getElementById("modalSkills").innerText = job.skills || "Not specified";
        document.getElementById("modalLocation").innerText = job.location || "Not specified";
        document.getElementById("modalStatus").innerText = job.status;
        document.getElementById("modalDate").innerText = job.created_at;

        document.getElementById("jobModal").style.display = "flex";
    });
}

function closeModal() {
    document.getElementById("jobModal").style.display = "none";
}
</script>



</body>
</html>