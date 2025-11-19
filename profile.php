
<?php
session_start();
include('db/db_connect.php');

// Make sure login saved these
$firstname = $_SESSION['firstname'] ?? 'Guest';
$lastname = $_SESSION['lastname'] ?? '';
$email = $_SESSION['email'] ?? 'Not set';
$phone = $_SESSION['phone'] ?? '(+63) ————';
$citizenship = $_SESSION['citizenship'] ?? 'Not set';

// Avatar initial
$avatarLetter = strtoupper(substr($firstname, 0, 1));

// Ensure user_id exists
if (isset($_SESSION['user_id'])) {

    $user_id = intval($_SESSION['user_id']);  // ✅ FIXED: use user_id

    // Fetch work experience
    $work_query = $conn->query("SELECT * FROM work_experience WHERE user_id = $user_id");

    // === PROFILE STRENGTH SYSTEM ===
    $has_work = ($conn->query("SELECT id FROM work_experience WHERE user_id = $user_id LIMIT 1")->num_rows > 0);
    $has_skills = ($conn->query("SELECT id FROM skills WHERE user_id = $user_id LIMIT 1")->num_rows > 0);
    $has_edu = ($conn->query("SELECT id FROM education WHERE user_id = $user_id LIMIT 1")->num_rows > 0);
    $has_cert = ($conn->query("SELECT id FROM certificates WHERE user_id = $user_id LIMIT 1")->num_rows > 0);

    $total_sections = 4;
    $completed = $has_work + $has_skills + $has_edu + $has_cert;
    $profile_strength = ($completed / $total_sections) * 100;

} else {
    echo "<p style='color:red;'>Error: user_id not found in session. Please log in again.</p>";
    exit;
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KM Services | Profile</title>
<style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

/* === Base Styling === */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
body {
  background: #f3f9f8;
  color: #333;
}

/* === Header === */
header {
  background: #fff;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 50px;
  border-bottom: 1px solid #ddd;
}
.logo1  {
  color: #000;   /* ✅ changed to black */
  font-weight: 700;
  font-size: 20px;
}
nav a {
  color: #333;
  margin: 0 15px;
  text-decoration: none;
  font-weight: 500;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* ✅ added */
}
nav a:hover {
  color: #008080;
}

/* === Layout === */
.main-container {
  display: grid;
  grid-template-columns: 300px 1fr;
  gap: 25px;
  padding: 30px 60px;
}

/* === Left Sidebar === */
.sidebar {
  display: flex;
  flex-direction: column;
  gap: 20px;
}
.card {
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 1px 4px rgba(0,0,0,0.05);
  border: 1px solid #e0e0e0;
}

/* Profile Card */
.profile-avatar {
  width: 70px;
  height: 70px;
  border-radius: 8px;
  background: #008080;
  color: #fff;
  font-weight: bold;
  font-size: 28px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.profile-info {
  text-align: left;
  margin-top: 10px;
}
.profile-info h2 {
  font-size: 20px;
  margin-bottom: 4px;
}
.profile-info p {
  font-size: 14px;
  color: #666;
  margin: 3px 0;
}

/* Buttons */
button, .upload-btn {
  background: #008080;
  border: none;
  color: #fff;
  font-weight: 500;
  padding: 8px 15px;
  border-radius: 6px;
  cursor: pointer;
}
button:hover, .upload-btn:hover {
  background: #006666;
}

/* === Profile Strength === */
.progress-container {
  margin-top: 8px;
}
.progress-bar {
  background: #e0e0e0;
  border-radius: 10px;
  height: 8px;
  width: 100%;
  overflow: hidden;
}
.progress-fill {
  background: #008080;
  height: 8px;
  border-radius: 10px;
  width: 42%;
}

/* === Right Main Section === */
.right-section {
  display: flex;
  flex-direction: column;
  gap: 25px;
}

/* Improve Matches Card */
.update-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.update-card p {
  font-size: 14px;
  color: #666;
}

/* === Grid of Info Cards === */
.grid-container {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 25px;
}
.info-card {
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 1px 4px rgba(0,0,0,0.05);
  border: 1px solid #e0e0e0;
  min-height: 250px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.info-card h3 {
  margin-bottom: 8px;
}
.info-card p {
  font-size: 14px;
  color: #666;
}
.info-card .add-btn {
  background: #008080;
  color: #fff;
  border: none;
  padding: 8px 15px;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 500;
}
.info-card .add-btn:hover {
  background: #006666;
}
.no-data {
  text-align: center;
  color: #999;
  margin-top: 20px;
}

/* === Modals / Overlay === */
.overlay {
  display: none;
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  justify-content: center;
  align-items: center;
  z-index: 200;
}
.modal {
  background: #fff;
  padding: 25px;
  border-radius: 10px;
  width: 400px;
  max-width: 90%;
  position: relative;
}
.close-btn {
  position: absolute;
  right: 15px;
  top: 10px;
  font-size: 20px;
  cursor: pointer;
  color: #555;
}
.modal label {
  display: block;
  margin-top: 10px;
  font-weight: 500;
}
.modal input {
  width: 100%;
  padding: 10px;
  margin-top: 6px;
  border: 1.5px solid #008080;
  border-radius: 6px;
}
.btn-group {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
  gap: 10px;
}
.edit-btn, .save-btn, .delete-btn {
  flex: 1;
  padding: 10px 0;
  border: none;
  border-radius: 6px;
  color: #fff;
  font-weight: 500;
  cursor: pointer;
}
.card .add-btn {
  margin-top: 20px;
}
/* Fix for add buttons - consistent size & centered */
.add-btn,
.upload-btn {
  display: block;
  width: 200px;                /* ✅ fixed width */
  margin: 15px auto 0 auto;    /* ✅ centers the button */
  background-color: #00796b;   /* teal */
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 10px 15px;
  font-weight: 600;
  cursor: pointer;
  text-align: center;
  transition: background-color 0.3s ease;
}
/* Softer, cleaner card design */

/* Add a little more balance for spacing between cards */
.right-panel .card {
  margin-bottom: 20px;
}


.add-btn:hover,
.upload-btn:hover {
  background-color: #00695c;
}
/* Container that holds all cards */
.profile-sections {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); /* makes cards responsive */
  gap: 20px; /* spacing between cards */
  max-width: 1200px; /* limit the overall width of the section */
  margin: 0 auto; /* center the content */
  padding: 20px;
}

/* Card styling */
.card {
  background: #fff;
  border: 1px solid #e0e0e0;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  transition: box-shadow 0.3s ease, transform 0.2s ease;
}

.card:hover {
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
  transform: translateY(-2px);
}

.grid-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center; /* centers all cards */
  gap: 20px;
  max-width: 1000px; /* limit total width */
  margin: 0 auto; /* center horizontally */
}

.info-card {
  flex: 1 1 420px; /* each card ~420px wide */
  max-width: 440px; /* prevent being too wide */
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 1px 4px rgba(0,0,0,0.05);
  border: 1px solid #e0e0e0;
  min-height: 220px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.edit-btn { background: #555; }
.save-btn { background: #008080; }
.delete-btn { background: #b30000; }
.edit-btn:hover { background: #333; }
.save-btn:hover { background: #006666; }
.delete-btn:hover { background: #800000; }

 /* === BASIC PAGE RESET === */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      background: #f3f9f8;
      min-height: 100vh;
    }

    /* === HEADER === */
    header {
      background: #fff;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 50px;
      border-bottom: 1px solid #ddd;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .logo {
      color: #008080;
      font-weight: 700;
      font-size: 20px;
    }

    /* Group nav links + user icon on right */
    .nav-right {
      display: flex;
      align-items: center;
      gap: 25px;
    }

    /* Nav links */
    .nav-right nav a {
      text-decoration: none;
      color: #000000ff;
      font-size: 15px;
      margin: 0 10px;
      font-weight: 500;
      transition: color 0.2s;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* ✅ added */
    }

    .nav-right nav a:hover {
      color: #3d4145ff;
    }

    /* === USER MENU === */
    .user-menu {
      position: relative;
    }

    .user-icon img {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      cursor: pointer;
      border: 2px solid #fff;
      box-shadow: 0 0 3px rgba(0,0,0,0.2);
    }

    /* Dropdown menu */
    .dropdown-menu {
      display: none;
      position: absolute;
      right: 0;
      top: 50px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.15);
      width: 230px;
      overflow: hidden;
      z-index: 200;
    }

    .dropdown-menu.show {
  display: block;
}

    .dropdown-email {
      font-weight: bold;
      padding: 12px 16px;
      border-bottom: 1px solid #eee;
      font-size: 13px;
      color: #333;
      word-break: break-all;
    }

    .dropdown-menu a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 16px;
      color: #333;
      text-decoration: none;
      font-size: 14px;
    
    }

    .dropdown-menu a:hover {
      background-color: #f3f3f3;
    }

    .dropdown-menu .signout {
      color: #0078d7;
      font-weight: bold;
      border-top: 1px solid #eee;
      margin-top: 5px;
    }
.upload-btn {
  background-color: #008080;
  color: white;
  padding: 10px 20px;
  border-radius: 6px;
  display: inline-block;
  transition: background 0.2s;
}

.upload-btn:hover {
  background-color: #006666;
}

.upload-btn a {
  text-decoration: none;
  color: inherit;
}

/* FORCE CENTER ALL MODALS */
.overlay {
  position: fixed !important;
  top: 0 !important;
  left: 0 !important;
  width: 100vw !important;
  height: 100vh !important;
  display: none;
  justify-content: center !important;
  align-items: center !important;
  background: rgba(0,0,0,0.55) !important;
  z-index: 99999 !important;
}

.overlay .modal {
  background: #fff;
  padding: 25px;
  border-radius: 12px;
  width: 400px;
  max-width: 90%;
  box-shadow: 0px 4px 18px rgba(0,0,0,0.30);
}

</style>
</head>
<script>
function saveWork() {
  const id = document.getElementById('work_id').value;
  const jobTitle = document.getElementById('jobTitle').value.trim();
  const jobCompany = document.getElementById('jobCompany').value.trim();
  const jobDuration = document.getElementById('jobDuration').value.trim();

  if (!jobTitle || !jobCompany) {
    alert('Please fill in all required fields.');
    return;
  }

  const formData = new FormData();
  formData.append('id', id);
  formData.append('job_title', jobTitle);
  formData.append('company', jobCompany);
  formData.append('duration', jobDuration);

  fetch('save_work.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if (data.status === 'success') {
      closeModal('workModal');
      loadWorkExperience();
    }
  });
}

function deleteWork(id) {
  if (!confirm("Are you sure you want to delete this record?")) return;

  const formData = new FormData();
  formData.append('id', id);

  fetch('delete_work.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if (data.status === 'success') loadWorkExperience();
  });
}

function loadWorkExperience() {
  fetch('load_work.php')
  .then(res => res.text())
  .then(html => {
    document.querySelector('.no-data').innerHTML = html;
  });
}

document.addEventListener('DOMContentLoaded', loadWorkExperience);


function editWork(id, title, company, duration) {
  openModal('workModal');
  document.getElementById('work_id').value = id;
  document.getElementById('jobTitle').value = title;
  document.getElementById('jobCompany').value = company;
  document.getElementById('jobDuration').value = duration;
}


</script>

<body>

<header>
    <div class="logo1">KM Services</div>

    <div class="nav-right">
      <nav>
        <a href="newsfeed.php">Home</a>
        <a href="about.php">About Us</a>
      </nav>

      <div class="user-menu">
        <div class="user-icon" id="userIcon">
          <img src="img/icon.jpg" alt="User Icon">
        </div>

        <div class="dropdown-menu" id="dropdownMenu">
          <div class="dropdown-email">
            <?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'user@example.com'; ?>
          </div>
          <a href="profile.php">📄 Profile</a>
          <a href="letsconnect.php">❓ Contact Us</a>
           <a href="javascript:void(0)" class="signout" onclick="logout(event)">Sign out</a>
        </div>
      </div>
    </div>
  </header>




<div class="main-container">
  <!-- Left Sidebar -->
  <div class="sidebar">
 <!-- <div class="card profile-card"> -->
  <div class="profile-avatar"><?php echo htmlspecialchars($avatarLetter); ?></div>
  <div class="profile-info">
    <h2><?php echo htmlspecialchars($firstname . " " . $lastname); ?></h2>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
  </div>
  <div class="upload-btn">
  <a href="resume.php">Edit Resume</a>
  </div>
  <div class="upload-btn" onclick="openModal('resumeModal')">
  Upload Resume
</div>

<!-- === Resume Upload Modal === -->
<div id="resumeModal" class="overlay">
  <div class="modal">
    <span class="close-btn" onclick="closeModal('resumeModal')">&times;</span>

    <h3>Upload Resume</h3>
    
    <form action="upload_resume.php" method="POST" enctype="multipart/form-data">

      <label>Select Resume (.pdf / .docx)</label>
      <input type="file" name="resume_file" accept=".pdf,.doc,.docx" required>

      <div class="btn-group">
        <button type="submit" class="save-btn">Upload</button>
      </div>

    </form>
  </div>
</div>
<?php if (isset($_SESSION['resume_doc'])): ?> 
    <a href="<?php echo $_SESSION['resume_doc']; ?>" 
       download 
       class="upload-btn">
       Download Resume (.docx)
    </a>
<?php endif; ?>
<div class="right-section">
    <div class="card update-card">
      <div>
        <h4>Improve your job matches</h4>
        <p>Complete the sections below to get better job recommendations.</p>
      </div>
    </div>
</div>

    <div class="card">
      <h4>Profile Strength</h4>
      <p style="font-size:13px;color:#666;margin-top:6px;">
        Complete work, skills, and education to improve matches.
      </p>
    </div>
  </div>

  <!-- Right Section -->
  

    <div class="grid-container">
      <div class="info-card">
        <div>
          <h3>Work experience</h3>
          <p>Add jobs you've done — employers care about recent experience.</p>
          <div class="no-data">
            <p>👜 No work experience yet</p>
          </div>
        </div>
        <button class="add-btn" onclick="openModal('workModal')">Add work experience</button>
      </div>

      <div class="info-card">
        <div>
          <h3>Skills</h3>
          <p>Highlight the skills recruiters look for.</p>
          <div class="no-data">
            <p>🛠️ No skills yet</p>
          </div>
        </div>
        <button class="add-btn" onclick="openModal('skillModal')">Add a skill</button>
      </div>

      <div class="info-card">
        <div>
          <h3>Education</h3>
          <p>Schools, degrees, training</p>
          <div class="no-data">
            <p>🎓 No education added</p>
          </div>
        </div>
        <button class="add-btn" onclick="openModal('eduModal')">Add education</button>
      </div>

      <div class="info-card">
        <div>
          <h3>Certificates & Licenses</h3>
          <p>Share important certifications</p>
          <div class="no-data"  id="certificateList">
            <p>📜 No certificates added</p>
          </div>
        </div>
        <button class="add-btn" onclick="openModal('certModal')">Add certificate</button>
      </div>
    </div>
  </div>
</div>

<!-- === Modals === -->
<div id="workModal" class="overlay">
  <div class="modal">
    <span class="close-btn" onclick="closeModal('workModal')">&times;</span>
    <h3>Add / Edit Work Experience</h3>
    <input type="hidden" id="work_id">
    <label>Job Title</label>
    <input type="text" id="jobTitle">
    <label>Company</label>
    <input type="text" id="jobCompany">
    <label>Duration</label>
    <input type="text" id="jobDuration">
    <div class="btn-group">
     
     <button class="save-btn" onclick="saveWork()">Save</button>
    
    </div>
  </div>
</div>

<div id="skillModal" class="overlay">
  <div class="modal">
    <span class="close-btn" onclick="closeModal('skillModal')">&times;</span>
    <h3>Add / Edit Skill</h3>
    <input type="hidden" id="skill_id">
    <label>Skill Name</label>
    <input type="text" id="skillName">
    <div class="btn-group">
      
     <button class="save-btn" onclick="saveSkill()">Save</button>
      
    </div>
  </div>
</div>

<div id="eduModal" class="overlay">
  <div class="modal">
    <span class="close-btn" onclick="closeModal('eduModal')">&times;</span>
    <h3>Add / Edit Education</h3>
    <input type="hidden" id="edu_id">
    <label>School</label>
    <input type="text" id="eduSchool">
    <label>Degree</label>
    <input type="text" id="eduDegree">
    <label>Year</label>
    <input type="text" id="eduYear">
    <div class="btn-group">
     <button class="save-btn" onclick="saveEducation()">Save</button>
    
    </div>
  </div>
</div>

<div id="certModal" class="overlay">
  <div class="modal">
    <span class="close-btn" onclick="closeModal('certModal')">&times;</span>
    <h3>Add / Edit Certificate</h3>
    <input type="hidden" id="cert_id">
    <label>Certificate Name</label>
    <input type="text" id="certName">
    <label>Issuer</label>
    <input type="text" id="certIssuer">
    <div class="btn-group">
      
      <button class="save-btn" onclick="saveCertificate()">Save</button>
    
    </div>
  </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
  const userIcon = document.getElementById('userIcon');
  const dropdownMenu = document.getElementById('dropdownMenu');

  if (!userIcon || !dropdownMenu) {
    console.error("⚠️ Elements not found. Check your IDs!");
    return;
  }

  userIcon.addEventListener('click', function(event) {
    event.stopPropagation();
    dropdownMenu.classList.toggle('show');
  });

  window.addEventListener('click', function(event) {
    if (!event.target.closest('.user-menu')) {
      dropdownMenu.classList.remove('show');
    }
  });
});

function openModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.style.display = "flex"; // shows overlay as flex (so it centers modal)
  }
}

function closeModal(id) {
  const modal = document.getElementById(id);
  if (modal) {
    modal.style.display = "none";
  }
}

// Optional: close modal when clicking outside the modal box
window.addEventListener("click", function(e) {
  document.querySelectorAll(".overlay").forEach(overlay => {
    if (e.target === overlay) {
      overlay.style.display = "none";
    }
  });
});

function loadSkills() {
  fetch('load_skills.php')
    .then(res => res.text())
    .then(html => {
      document.querySelector('.info-card:nth-child(2) .no-data').innerHTML = html;
    });
}

function saveSkill() {
  const id = document.getElementById('skill_id').value;
  const name = document.getElementById('skillName').value.trim();

  if (!name) {
    alert('Please enter a skill name.');
    return;
  }

  const formData = new FormData();
  formData.append('id', id);
  formData.append('skill_name', name);

  fetch('save_skill.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if (data.status === 'success') {
      closeModal('skillModal');
      loadSkills();
    }
  });
}

function deleteSkill(id) {
  if (!confirm('Are you sure you want to delete this skill?')) return;

  const formData = new FormData();
  formData.append('id', id);

  fetch('delete_skill.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if (data.status === 'success') loadSkills();
  });
}

function editSkill(id, name) {
  openModal('skillModal');
  document.getElementById('skill_id').value = id;
  document.getElementById('skillName').value = name;
}

document.addEventListener('DOMContentLoaded', loadSkills);

function loadEducation() {
  fetch('load_education.php')
    .then(res => res.text())
    .then(html => {
      document.querySelector('.info-card:nth-child(3) .no-data').innerHTML = html;
    });
}

function saveEducation() {
  const id = document.getElementById('edu_id').value;
  const school = document.getElementById('eduSchool').value.trim();
  const degree = document.getElementById('eduDegree').value.trim();
  const year = document.getElementById('eduYear').value.trim();

  if (!school || !degree) {
    alert('Please enter both school and degree.');
    return;
  }

  const formData = new FormData();
  formData.append('id', id);
  formData.append('school', school);
  formData.append('degree', degree);
  formData.append('year', year);

  fetch('save_education.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if (data.status === 'success') {
      closeModal('eduModal');
      loadEducation();
    }
  });
}

function editEducation(id, school, degree, year) {
  openModal('eduModal');
  document.getElementById('edu_id').value = id;
  document.getElementById('eduSchool').value = school;
  document.getElementById('eduDegree').value = degree;
  document.getElementById('eduYear').value = year;
}

function deleteEducation(id) {
  if (!confirm('Are you sure you want to delete this record?')) return;

  const formData = new FormData();
  formData.append('id', id);

  fetch('delete_education.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if (data.status === 'success') loadEducation();
  });
}

document.addEventListener('DOMContentLoaded', loadEducation);


function logout(event) {
  event.preventDefault(); // block any link behavior
  const confirmLogout = confirm('Are you sure you want to sign out?');
  if (confirmLogout) {
    window.location.href = 'logout.php';
  }
  // if canceled, do nothing — the page stays as is
}

function loadCertificates() {
  fetch('load_certificate.php')
    .then(res => res.text())
    .then(html => {
      document.querySelector('.info-card:nth-child(4) .no-data').innerHTML = html;
    });
}

function saveCertificate() {
  const id = document.getElementById('cert_id').value;
  const name = document.getElementById('certName').value.trim();
  const issuer = document.getElementById('certIssuer').value.trim();

  if (!name || !issuer) {
    alert('Please fill in all fields.');
    return;
  }

  const formData = new FormData();
  formData.append('id', id);
  formData.append('certificate_name', name);
  formData.append('issued_by', issuer);

  fetch('save_certificate.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if (data.status === 'success') {
      closeModal('certModal');
      loadCertificates();
    }
  });
}

function editCertificate(id, name, issuer) {
  openModal('certModal');
  document.getElementById('cert_id').value = id;
  document.getElementById('certName').value = name;
  document.getElementById('certIssuer').value = issuer;
}

function deleteCertificate(id) {
  if (!confirm('Are you sure you want to delete this certificate?')) return;

  const formData = new FormData();
  formData.append('id', id);

  fetch('delete_certificate.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    if (data.status === 'success') loadCertificates();
  });
}


document.addEventListener('DOMContentLoaded', loadCertificates);
$("#saveEducationBtn").on("click", function () {
    $.ajax({
        url: "save_education.php",
        type: "POST",
        data: $("#educationForm").serialize(),  // <-- your form must have this ID
        success: function(response) {
            if (response.status === "success") {
                alert("Saved!");
                location.reload();
            } else {
                alert(response.message || "Unknown error");
            }
        },
        error: function(xhr) {
            alert("AJAX error: " + xhr.responseText);
        }
    });
});


function loadCertificates() {
  fetch('load_certificate.php')
    .then(res => res.text())
    .then(html => {
      document.getElementById('certificateList').innerHTML = html;
    });
}

document.getElementById('certificateList').innerHTML = html;



</script>

</body>
</html>
