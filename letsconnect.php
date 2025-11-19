<?php
session_start();

// Example session handling
if (!isset($_SESSION['email'])) {
    $_SESSION['email'] = "user@example.com"; // demo email
}
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - KM Services</title>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    /* General Reset */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background: #f7f9fc;
      color: #000;
    }

    /* Header */
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 50px;
      border-bottom: 1px solid #ccc;
      background: #fff;
      position: relative;
      z-index: 1000;
    }

    .logo {
      font-weight: bold;
      font-size: 20px;
      color: #008080;
    }

    nav {
      display: flex;
      align-items: center;
      gap: 25px;
    }

    nav a {
      color: #333;
      text-decoration: none;
      font-weight: 500;
    }

    nav a:hover {
      color: #008080;
    }

    /* Dropdown menu */
    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown img {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      cursor: pointer;
      border: 2px solid #008080;
      padding: 2px;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: #fff;
      min-width: 160px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      border-radius: 8px;
      overflow: hidden;
      z-index: 1;
    }

    .dropdown-content a {
      color: #333;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      font-size: 0.95rem;
    }

    .dropdown-content a:hover {
      background-color: #f0f0f0;
      color: #008080;
    }

    .dropdown.active .dropdown-content {
      display: block;
    }

    /* Hero Section */
    .hero {
      text-align: center;
      background: linear-gradient(to right, #e6f4f4, #f8ffff);
      padding: 60px 20px 40px;
    }

    .hero h1 {
      font-size: 2.5rem;
      color: #004d4d;
      margin-bottom: 10px;
    }

    .hero p {
      font-size: 1.1rem;
      color: #555;
    }

    /* Contact Section */
    .contact-section {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      flex-wrap: wrap;
      gap: 40px;
      padding: 60px 20px;
      max-width: 1100px;
      margin: auto;
    }

    .contact-form {
      flex: 1 1 500px;
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    }

    .contact-form h2 {
      color: #004d4d;
      margin-bottom: 10px;
      font-size: 1.8rem;
    }

    .contact-form p {
      color: #555;
      font-size: 0.95rem;
      margin-bottom: 30px;
    }

    .form-row {
      display: flex;
      gap: 20px;
    }

    .form-group {
      flex: 1;
      display: flex;
      flex-direction: column;
      margin-bottom: 20px;
    }

    .form-group label {
      font-weight: 600;
      margin-bottom: 6px;
      font-size: 0.9rem;
      color: #333;
    }

    .form-group input,
    .form-group textarea {
      padding: 10px;
      border: none;
      border-bottom: 2px solid #ccc;
      background: none;
      font-size: 0.95rem;
      outline: none;
      transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
      border-color: #008080;
    }

    textarea {
      resize: none;
      height: 100px;
    }

    .contact-form button {
      width: 100%;
      background: #008080;
      color: white;
      padding: 14px;
      border: none;
      border-radius: 25px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .contact-form button:hover {
      background: #006666;
    }

    /* Contact Info Section */
    .contact-info {
      flex: 1 1 300px;
      padding: 20px;
    }

    .contact-info h2 {
      color: #004d4d;
      font-size: 1.8rem;
      margin-bottom: 10px;
    }

    .contact-info p {
      color: #555;
      margin-bottom: 30px;
      font-size: 0.95rem;
    }

    .info-item {
      display: flex;
      align-items: flex-start;
      margin-bottom: 20px;
    }

    .info-item i {
      font-size: 1.3rem;
      color: #008080;
      margin-right: 15px;
    }

    .info-item div p {
      margin: 0;
      color: #555;
    }

    .social-icons {
      margin-top: 20px;
    }

    .social-icons a {
      display: inline-block;
      margin-right: 10px;
      font-size: 1.2rem;
      color: white;
      background: #008080;
      width: 35px;
      height: 35px;
      line-height: 35px;
      text-align: center;
      border-radius: 6px;
      transition: background 0.3s ease;
    }

    .social-icons a:hover {
      background: #006666;
    }

    @media (max-width: 900px) {
      .contact-section {
        flex-direction: column;
        align-items: center;
      }
    }
      body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      background-color: #fff;
      color: #000;
    }

    /* HEADER */
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 50px;
      border-bottom: 1px solid #ccc;
      position: sticky;
      top: 0;
      background: #fff;
      z-index: 1000;
    }

    .logo {
      font-weight: bold;
      font-size: 20px;
      color: #000;
    }

    /* NAVBAR LINKS */
    .navbar {
      display: flex;
      align-items: center;
      gap: 25px;
    }

    .navbar a {
      text-decoration: none;
      color: #000;
      font-weight: 500;
      transition: color 0.2s ease;
    }

    .navbar a:hover {
      color: gray;
    }

    /* USER MENU */
    .user-menu {
      position: relative;
      display: inline-block;
    }

    .user-icon img {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      cursor: pointer;
      transition: opacity 0.2s;
    }

    .user-icon img:hover {
      opacity: 0.7;
    }

    /* DROPDOWN MENU */
    .dropdown-menu {
      display: none;
      position: absolute;
      right: 0;
      top: 45px;
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      width: 220px;
      z-index: 1000;
      padding: 10px 0;
      font-size: 14px;
    }

    .dropdown-menu::before {
      content: "";
      position: absolute;
      top: -8px;
      right: 15px;
      border-width: 8px;
      border-style: solid;
      border-color: transparent transparent #fff transparent;
    }

   .dropdown-email {
  padding: 10px 15px;
  font-weight: bold;
  border-bottom: 1px solid #eee;
  color: #333;
  font-size: 13px;
  word-break: break-all;
}


    .dropdown-menu a {
      display: block;
      padding: 10px 15px;
      color: #333;
      text-decoration: none;
      transition: background 0.2s;
    }

    .dropdown-menu a:hover {
      background: #f3f3f3;
    }

    .dropdown-menu .signout {
      color: #0073e6;
      font-weight: bold;
      border-top: 1px solid #eee;
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
    /* ✅ Show dropdown when JS adds the 'show' class */
.dropdown-menu.show {
  display: block;
}


  </style>
</head>

<body>
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



  <section class="hero">
    <h1>Contact Us</h1>
    <p>We would love to hear from you. Let's connect and make something great together.</p>
  </section>

  <section class="contact-section">
    <div class="contact-form">
      <h2>Send us a message</h2>
      <p>Looking for the right talent or your next career move? Our recruitment team is here to connect top-tier professionals with the companies that need them.</p>

      <form method="post" action="contact_submission.php">
        <div class="form-row">
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" placeholder="Your Name" required>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Your Email" required>
          </div>
        </div>
        <div class="form-group">
          <label>Subject</label>
          <input type="text" name="subject" placeholder="Subject" required>
        </div>
        <div class="form-group">
          <label>Message</label>
          <textarea name="message" placeholder="Your Message" required></textarea>
        </div>
        <button type="submit"><i class="fas fa-paper-plane"></i> Send Message</button>
      </form>
    </div>

    <div class="contact-info">
      <h2>Get in touch</h2>
      <p>Reach us directly — one of our recruitment specialists will get back to you promptly.</p>

      <div class="info-item">
        <i class="fas fa-map-marker-alt"></i>
        <div>
          <h4>Headquarters</h4>
          <p>Jenra, Angeles City, Philippines</p>
        </div>
      </div>

      <div class="info-item">
        <i class="fas fa-phone"></i>
        <div>
          <h4>Call us</h4>
          <p>+63 912 345 6789</p>
        </div>
      </div>

      <div class="info-item">
        <i class="fas fa-envelope"></i>
        <div>
          <h4>Email</h4>
          <p>support@kmservices.com</p>
        </div>
      </div>

      
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
