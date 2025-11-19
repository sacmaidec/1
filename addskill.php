<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "user");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $skill_name = trim($_POST["skill_name"]);
    $years_experience = trim($_POST["years_experience"]);

    if (!empty($skill_name)) {
        $sql = "INSERT INTO skills (skill_name, years_experience) VALUES ('$skill_name', '$years_experience')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Skill added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding skill.');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Skill - KM Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
    }
    .container {
      max-width: 600px;
      background: white;
      padding: 40px;
      margin-top: 60px;
      border-radius: 15px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h3 {
      font-weight: 700;
      margin-bottom: 20px;
    }
    label {
      font-weight: 600;
      margin-top: 15px;
    }
    .btn-save {
      background-color: #89a88e;
      color: white;
      font-weight: 600;
      border: none;
      padding: 8px 25px;
      border-radius: 5px;
      margin-top: 25px;
    }
    .btn-save:hover {
      background-color: #6f8a73;
    }
  </style>
</head>
<body>
  <nav class="navbar bg-white border-bottom">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold">KM Services</a>
      <ul class="nav">
        <li class="nav-item"><a href="#" class="nav-link text-dark">Home</a></li>
        <li class="nav-item"><a href="#" class="nav-link text-dark">About Us</a></li>
        <li class="nav-item"><a href="#" class="nav-link text-dark">Profile</a></li>
      </ul>
    </div>
  </nav>

  <div class="container">
    <a href="#" class="text-decoration-none text-dark mb-3 d-inline-block">&larr;</a>
    <h3>Add Skill</h3>
    <p class="text-muted">Please fill out the form below. <span class="text-danger">*</span> required</p>

    <form method="POST">
      <div class="mb-3">
        <label for="skill_name" class="form-label">Skill name <span class="text-danger">*</span></label>
        <input type="text" name="skill_name" id="skill_name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="years_experience" class="form-label">Years of experience</label>
        <select name="years_experience" id="years_experience" class="form-select">
          <option value="">Select...</option>
          <?php
          for ($i = 1; $i <= 50; $i++) {
              echo "<option value='$i'>$i</option>";
          }
          ?>
        </select>
      </div>

      <button type="submit" class="btn-save">SAVE</button>
    </form>
  </div>
</body>
</html>
