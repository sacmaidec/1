<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "users");

// If user not logged in, redirect
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// When form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['email']; // who added the experience
    $job_title = mysqli_real_escape_string($conn, $_POST['job_title']);
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $city_state = mysqli_real_escape_string($conn, $_POST['city_state']);
    $current_work = isset($_POST['current_work']) ? 1 : 0;
    $from_month = mysqli_real_escape_string($conn, $_POST['from_month']);
    $from_year = mysqli_real_escape_string($conn, $_POST['from_year']);
    $to_month = mysqli_real_escape_string($conn, $_POST['to_month']);
    $to_year = mysqli_real_escape_string($conn, $_POST['to_year']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Insert into database
    $sql = "INSERT INTO work_experience (email, job_title, company, country, city_state, current_work, from_month, from_year, to_month, to_year, description)
            VALUES ('$email', '$job_title', '$company', '$country', '$city_state', '$current_work', '$from_month', '$from_year', '$to_month', '$to_year', '$description')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Work experience added successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Work Experience - KM Services</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #fff;
      margin: 0;
      padding: 0;
      color: #000;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 50px;
      background-color: #fff;
      border-bottom: 1px solid #ddd;
    }
    header .logo { font-weight: bold; }
    nav a {
      text-decoration: none;
      color: #aaa;
      margin-left: 20px;
      font-weight: 500;
    }
    nav a:hover { color: #000; }

    .container {
      max-width: 700px;
      margin: 40px auto;
    }
    h2 { font-size: 22px; }
    p { color: #555; font-size: 14px; }
    form { margin-top: 20px; }

    label {
      display: block;
      margin-top: 15px;
      font-weight: 600;
      font-size: 14px;
    }
    input[type="text"],
    select,
    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-top: 5px;
      font-size: 14px;
    }
    textarea {
      height: 80px;
      resize: none;
    }

    .row {
      display: flex;
      gap: 10px;
    }
    .row select {
      flex: 1;
    }

    .checkbox {
      margin-top: 10px;
    }

    .button-container {
      text-align: center;
      margin-top: 30px;
    }

    .save-btn {
      background-color: #0044ff;
      color: #fff;
      border: none;
      padding: 10px 40px;
      border-radius: 6px;
      font-weight: bold;
      font-size: 15px;
      cursor: pointer;
      letter-spacing: 1px;
    }
    .save-btn:hover { background-color: #0035cc; }

    a.back-btn {
      text-decoration: none;
      font-size: 24px;
      color: #000;
    }
  </style>
</head>
<body>

<header>
  <div class="logo">KM Services</div>
  <nav>
    <a href="index.php">Home</a>
    <a href="about.php">About Us</a>
    <a href="profile.php" style="color:#000;">Profile</a>
  </nav>
</header>

<div class="container">
  <a href="profile.php" class="back-btn">&#8592;</a>
  <h2>Add Work Experience</h2>
  <p>Please fill out the form below. <span style="color:red">*</span> required</p>

  <form method="POST" action="">
    <label>Job title*</label>
    <input type="text" name="job_title" required>

    <label>Company*</label>
    <input type="text" name="company" required>

    <label>Country</label>
    <input type="text" name="country" value="Philippines">

    <label>City, State</label>
    <input type="text" name="city_state">

    <label class="checkbox">
      <input type="checkbox" name="current_work"> I currently work here
    </label>

    <label>From</label>
    <div class="row">
      <select name="from_month">
        <option value="">Month</option>
        <option>January</option><option>February</option><option>March</option>
        <option>April</option><option>May</option><option>June</option>
        <option>July</option><option>August</option><option>September</option>
        <option>October</option><option>November</option><option>December</option>
      </select>
      <select name="from_year">
        <option value="">Year</option>
        <?php for ($y = date('Y'); $y >= 1970; $y--) echo "<option>$y</option>"; ?>
      </select>
    </div>

    <label>To</label>
    <div class="row">
      <select name="to_month">
        <option value="">Month</option>
        <option>January</option><option>February</option><option>March</option>
        <option>April</option><option>May</option><option>June</option>
        <option>July</option><option>August</option><option>September</option>
        <option>October</option><option>November</option><option>December</option>
      </select>
      <select name="to_year">
        <option value="">Year</option>
        <?php for ($y = date('Y'); $y >= 1970; $y--) echo "<option>$y</option>"; ?>
      </select>
    </div>

    <label>Description (Recommended)</label>
    <textarea name="description"></textarea>

    <div class="button-container">
      <button type="submit" class="save-btn">SAVE</button>
    </div>
  </form>
</div>

</body>
</html>
