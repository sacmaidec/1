<?php
session_start();

// Make sure user is logged in
if (!isset($_SESSION['email'])) {
    // Optionally redirect to login page
    header("Location: login.php");
    exit();
}

// Define the variable
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About KM Recruitment</title>
<style>
/* --- Reset --- */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* --- Global --- */
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #fafafa;
  color: #333;
  line-height: 1.6;
}

/* --- Header --- */
header {
  background: #fff;
  border-bottom: 1px solid #ddd;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 15px 50px;
  position: sticky;
  top: 0;
  z-index: 100;
}

.logo {
  font-weight: bold;
  font-size: 20px;
  color: #008080;
}

nav {
  display: flex;
  align-items: center;
  gap: 30px;
}

nav a {
  text-decoration: none;
  color: #333;
  font-weight: 500;
}

nav a:hover {
  color: #008080;
}

/* --- User Menu --- */
.user-menu {
  position: relative;
}

.user-icon img {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  cursor: pointer;
}

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
      color: #000000ff;
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


/* --- Section 1: About Hero --- */
.about-hero {
  background-color: #fefcfb;
  padding: 80px 10%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 60px;
}

.about-hero .text {
  flex: 1;
}

.about-hero h1 {
  font-size: 36px;
  margin-bottom: 10px;
  color: #000;
}

.about-hero p {
  font-size: 16px;
  color: #555;
  max-width: 550px;
}

.about-hero img {
  flex: 1;
  width: 100%;
  max-width: 450px;
  border-radius: 15px;
}

/* --- Section 2: Mission --- */
.mission-section {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 80px 10%;
  background-color: #fff;
  gap: 60px;
}

.mission-section img {
  flex: 1;
  width: 100%;
  max-width: 450px;
  border-radius: 15px;
}

.mission-section .text {
  flex: 1;
}

.mission-section h2 {
  font-size: 28px;
  color: #000;
  margin-bottom: 15px;
}

.mission-section p {
  color: #555;
}


/* --- Responsive --- */
@media (max-width: 900px) {
  .about-hero, .mission-section {
    flex-direction: column;
    text-align: center;
  }

  .about-hero img, .mission-section img {
    max-width: 90%;
  }

  .about-hero .text, .mission-section .text {
    width: 100%;
  }

  header {
    flex-direction: column;
    padding: 20px;
  }

  nav {
    margin-top: 10px;
  }
}
</style>
</head>

<body>

<!-- Header -->
<header>
    <div class="logo">KM Services</div>

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

<!-- About Hero Section -->
<section class="about-hero">
  <div class="text">
    <h1>About Us</h1>
    <p>KM Recruitment’s company and culture are built to connect opportunities with talent. We focus on crafting delightful experiences for both employers and job seekers through innovation and integrity.</p>
  </div>
  <img src="img/huhu.jpg" alt="Team Working Together">
</section>

<!-- Mission Section -->
<section class="mission-section">
  <img src="img/nye.jpg" alt="Office Environment">
  <div class="text">
    <h2>Our Mission: Helping Organizations Grow Better</h2>
    <p>We believe in growing smarter, not just bigger. At KM Recruitment, we align the success of businesses with the ambitions of job seekers, ensuring a win-win for everyone. Through our AI-powered hiring tools, we connect millions of people with the right opportunities daily.</p>
  </div>
</section>

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
function logout(event) {
  event.preventDefault(); // block any link behavior
  const confirmLogout = confirm('Are you sure you want to sign out?');
  if (confirmLogout) {
    window.location.href = 'logout.php';
  }
  // if canceled, do nothing — the page stays as is
}
</script>

</body>
</html>
