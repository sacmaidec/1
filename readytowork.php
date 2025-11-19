<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ready to Work</title>
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
            padding: 20px 50px;
            border-bottom: 1px solid #ccc;
        }

        header .logo {
            font-weight: bold;
            font-size: 18px;
        }

        nav a {
            margin-left: 20px;
            text-decoration: none;
            color: #aaa;
            font-weight: 500;
        }

        nav a:hover {
            color: #000;
        }

        .container {
            padding: 50px 30px;
            max-width: 600px;
            margin: auto;
        }

        .back-arrow {
            font-size: 24px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
            color: #000;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }

        p {
            color: #777;
            margin-bottom: 30px;
        }

        .toggle-container {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 26px;
            margin-right: 10px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #00a000; /* Changed to green */
        }

        input:checked + .slider:before {
            transform: translateX(24px);
        }

        .buttons {
            display: flex;
            gap: 10px;
        }

        .buttons button {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .save-btn {
            background-color: #00a000;
            color: white;
        }

        .cancel-btn {
            background-color: #ccc;
            color: #555;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">KM Services</div>
    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About Us</a>
        <a href="profile.php">Profile</a>
    </nav>
</header>

<div class="container">
    <a href="profile.php" class="back-arrow">&#8592;</a>

    <h1>Ready to work</h1>
    <p>Let employers know that you can begin working right away.</p>

    <form method="post" action="ready_status.php">
        <div class="toggle-container">
            <label class="switch">
                <input type="checkbox" name="available" value="yes">
                <span class="slider"></span>
            </label>
            <span>I'm available to start immediately</span>
        </div>

        <div class="buttons">
            <button type="submit" class="save-btn">Save</button>
            <button type="button" class="cancel-btn" onclick="window.history.back()">Cancel</button>
        </div>
    </form>
</div>

</body>
</html>
