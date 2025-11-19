<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Personal Information - KM Services</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #fafafa;
      margin: 0;
      padding: 0;
      color: #333;
    }

    /* Header */
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 50px;
      background-color: #fff;
      border-bottom: 1px solid #ddd;
    }

    header h1 {
      font-size: 14px;
      margin: 0;
    }

    nav a {
      text-decoration: none;
      color: #999;
      margin-left: 25px;
      font-size: 14px;
    }

    nav a:hover {
      color: #000;
    }

    /* Main container */
    .container {
      max-width: 700px;
      margin: 60px auto;
      padding: 0 20px;
    }

    .back-arrow {
      display: inline-block;
      font-size: 18px;
      color: #000;
      text-decoration: none;
      margin-bottom: 20px;
    }

    h2 {
      font-size: 20px;
      margin-bottom: 30px;
    }

    /* Form field */
    .input-group {
      background-color: #e5e5e5;
      border-radius: 30px;
      padding: 15px 25px;
      margin-bottom: 25px;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 8px;
      font-size: 14px;
    }

    input[type="text"] {
      width: 100%;
      border: none;
      background: none;
      font-size: 15px;
      outline: none;
      color: #333;
    }

    /* Save button */
    .save-btn {
      display: inline-block;
      background-color: #91ad89;
      color: white;
      border: none;
      border-radius: 6px;
      padding: 8px 25px;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      float: right;
    }

    .save-btn:hover {
      opacity: 0.9;
    }

  </style>
</head>
<body>

<header>
  <h1>KM Services</h1>
  <nav>
    <a href="#">Home</a>
    <a href="#">About Us</a>
    <a href="#" style="color:#000;">Profile</a>
  </nav>
</header>

<div class="container">
  <a href="profile.php" class="back-arrow">&#8592;</a>
  <h2>Personal Information</h2>

  <form action="save_personal_info.php" method="POST">
    <div class="input-group">
      <label for="citizenship">Citizenship:</label>
      <input type="text" id="citizenship" name="citizenship" placeholder="Enter your citizenship">
    </div>

    <button type="submit" class="save-btn">SAVE</button>
  </form>
</div>

</body>
</html>
