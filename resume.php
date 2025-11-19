    <?php 
    include "db/db.php"; 
    $user_id = 1;

    // ---------------------
    // SAVE RESUME FORM
    // ---------------------
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['upload_photo'])) {

        $first = $_POST['first_name'];
        $last = $_POST['last_name'];
        $email = $_POST['@email'];
        $address = $_POST['contact'];
        $code = $_POST['country_code'];
        $contact = $_POST['contact_number'];
        $month = $_POST['from_month'];
        $date = $_POST['from_date'];
        $year = $_POST['from_year'];
        $nationality = $_POST['nationality'];
        $education = $_POST['education'];
        $summary = $_POST['description'];

        $stmt = $conn->prepare("
            INSERT INTO user_resume (
                user_id, first_name, last_name, email, address, country_code,
                contact_number, birth_month, birth_date, birth_year,
                nationality, education, summary
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "issssssssssss",
            $user_id, $first, $last, $email, $address, $code,
            $contact, $month, $date, $year, $nationality, $education, $summary
        );

    if ($stmt->execute()) {

        require_once 'vendor/autoload.php';
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();

        // Make document content
        $section->addTitle("Resume", 1);
        $section->addText("Name: $first $last");
        $section->addText("Email: $email");
        $section->addText("Address: $address");
        $section->addText("Contact: $code $contact");
        $section->addText("Birthdate: $month $date, $year");
        $section->addText("Nationality: $nationality");
        $section->addText("Education: $education");
        $section->addText("Summary:");
        $section->addText($summary);

        // Save document
        $fileName = "resume_user_" . $user_id . ".docx";
        $savePath = "user_resumes/" . $fileName;

        if (!file_exists("user_resumes")) {
            mkdir("user_resumes", 0777, true);
        }

        $phpWord->save($savePath, 'Word2007');

        // Save file path in session (to display in profile)
        $_SESSION['resume_doc'] = $savePath;

        $message = "<p style='color:green;'>Resume generated successfully.</p>";

    } else {
        $message = "<p style='color:red;'>Error saving data.</p>";
    }

    }

    // ---------------------
    // PHOTO UPLOAD
    // ---------------------
    $uploadedPhoto = null;

    if (isset($_POST['upload_photo'])) {

        $targetDir = "uploads/";

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES["photo"]["name"]);
        $targetFile = $targetDir . $fileName;

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (!in_array($fileType, $allowedTypes)) {
            $message = "<p style='color:red;'>Invalid file type! Only JPG, PNG, GIF allowed.</p>";
        } else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {

                $stmt = $conn->prepare("INSERT INTO user_photos (user_id, photo) VALUES (?, ?)");
                $stmt->bind_param("is", $user_id, $fileName);
                $stmt->execute();

                $uploadedPhoto = $fileName;
                $message = "<p style='color:green;'>Photo uploaded successfully!</p>";
            } else {
                $message = "<p style='color:red;'>Error uploading photo.</p>";
            }
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>KM Services - Add Work Experience</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f5f5f5;
                margin: 0;
                padding: 0;
                color: #333;
            }

            header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 15px 50px;
                background-color: #fff;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }

            header .logo {
                font-size: 16px;
                font-weight: bold;
                color: #000;
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

            .container {
                max-width: 800px;
                margin: 50px auto;
                background-color: #fff;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            }

            .back-btn {
                text-decoration: none;
                font-size: 20px;
                color: #000;
                margin-bottom: 10px;
                display: inline-block;
            }

            form label {
                display: block;
                margin-top: 15px;
                font-weight: bold;
                font-size: 14px;
            }

            input[type="text"],
            input[type="email"],
            select,
            textarea {
                width: 100%;
                padding: 10px;
                margin-top: 5px;
                border-radius: 6px;
                border: 1px solid #ccc;
                font-size: 14px;
            }

            .row {
                display: flex;
                gap: 10px;
            }

            .row select {
                flex: 1;
            }

            textarea {
                height: 100px;
                resize: vertical;
            }

            .button-container {
                text-align: right;
                margin-top: 25px;
            }

            .save-btn {
                background-color: #008080;
                color: #fff;
                border: none;
                border-radius: 6px;
                padding: 10px 25px;
                font-size: 14px;
                font-weight: bold;
                cursor: pointer;
            }

            .save-btn:hover {
                opacity: 0.9;
            }

            /* Resume Header */
            .resume-header {
                background-color: #008080;
                color: white;
                padding: 20px;
                border-radius: 10px;
                margin-bottom: 25px;
            }

            .resume-title h2 {
                margin: 0;
                font-size: 26px;
                font-weight: bold;
            }

            .resume-title p {
                margin: 5px 0 0 0;
                color: #e0f7f7;
            }
            /* SQUARE PHOTO BOX */
        .photo-box {
            width: 150px;
            height: 150px;
            border: 2px dashed #999;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 14px;
            cursor: pointer;
            margin-bottom: 15px;
        }

        .photo-box:hover {
            background-color: #f0f0f0;
        }

        .photo-box input {
            display: none;
        }

        /* FULLSCREEN OVERLAY */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;   /* center horizontally */
        align-items: center;       /* center vertically */
        z-index: 9999;
    }

    /* MODAL BOX */
    .modal {
        background: #fff;
        padding: 25px;  
        width: 350px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        position: relative;
    }

    /* CLOSE BUTTON */
    .close-btn {
        position: absolute;
        top: 8px;
        right: 12px;
        font-size: 22px;
        cursor: pointer;
    }


        </style>
    </head>
    
    <body>

    <div class="container">
        <a href="profile.php" class="back-btn">&#8592;</a>

        <h2>Resume</h2>

        <!-- SQUARE PHOTO UPLOAD -->
        <form action="" method="POST" enctype="multipart/form-data">

            <?php if (!$uploadedPhoto): ?>
            <label class="photo-box">
                <span>Add Photo</span>
                <input type="file" name="photo" accept="image/*" onchange="this.form.submit()">
                <input type="hidden" name="upload_photo" value="1">
            </label>
            <?php else: ?>
                <div class="photo-box" style="border:none;">
                    <img src="uploads/<?php echo $uploadedPhoto; ?>" 
                        style="width:150px; height:150px; border-radius:10px; object-fit:cover;">
                </div>
            <?php endif; ?>
        </form>

    <?php

    if (!empty($message)) {
        echo $message;
    }
    ?>
        <form method="POST" action="">

        <!-- FIRST NAME -->
        <label>First name*</label>
        <div style="display:flex; gap:10px; align-items:center;">
            <input type="text" name="first_name" required style="flex:1;">
            <button type="button" class="save-btn" style="background:#4a90e2; padding:7px 15px;">Edit</button>
        </div>

        <!-- LAST NAME -->
        <label>Last name*</label>
        <div style="display:flex; gap:10px; align-items:center;">
            <input type="text" name="last_name" required style="flex:1;">
            <button type="button" class="save-btn" style="background:#4a90e2; padding:7px 15px;">Edit</button>
        </div>

        <!-- EMAIL -->
        <label>Email</label>
        <div style="display:flex; gap:10px; align-items:center;">
            <input type="email" name="@email"  style="flex:1;">
            <button type="button" class="save-btn" style="background:#4a90e2; padding:7px 15px;">Edit</button>
        </div>

        <!-- ADDRESS -->
        <label>Address</label>
        <div style="display:flex; gap:10px; align-items:center;">
            <input type="text" name="contact" style="flex:1;">
            <button type="button" class="save-btn" style="background:#4a90e2; padding:7px 15px;">Edit</button>
        </div>

        <!-- CONTACT NUMBER -->
        <label>Contact no.</label>
        <div style="display:flex; gap:10px; align-items:center;">

            <div class="row" style="flex:1;">
                <select id="countryCode" name="country_code" style="max-width: 120px;">
                    <option value="+63" data-max="10">🇵🇭 +63 PH</option>
                    <option value="+1" data-max="10">🇺🇸 +1 US</option>
                    <option value="+44" data-max="10">🇬🇧 +44 UK</option>
                    <option value="+61" data-max="9">🇦🇺 +61 AU</option>
                    <option value="+81" data-max="10">🇯🇵 +81 JP</option>
                    <option value="+82" data-max="9">🇰🇷 +82 KR</option>
                    <option value="+971" data-max="9">🇦🇪 +971 UAE</option>
                    <option value="+91" data-max="10">🇮🇳 +91 IN</option>
                </select>

                <input type="text" id="contactNumber" name="contact_number" placeholder="Contact number">
            </div>

            <button type="button" class="save-btn" style="background:#4a90e2; padding:7px 15px;">Edit</button>
        </div>

        <!-- BIRTHDATE -->
        <label>Birth date</label>
        <div class="row">
            <select name="from_month">
                <option value="">Month</option>
                <option>January</option><option>February</option><option>March</option>
                <option>April</option><option>May</option><option>June</option>
                <option>July</option><option>August</option><option>September</option>
                <option>October</option><option>November</option><option>December</option>
            </select>
            <select name="from_date">
                <option value="">Date</option>
                <?php for ($d = 1; $d <= 31; $d++) echo "<option>$d</option>"; ?>
            </select>
            <select name="from_year">
                <option value="">Year</option>
                <?php for ($y = date('Y'); $y >= 1970; $y--) echo "<option>$y</option>"; ?>
            </select>
        </div>

        <!-- NATIONALITY -->
        <label>Nationality</label>
        <div class="row">
            <select name="nationality" required>
                <option value="" disabled selected>Select Nationality</option>
                <option value="Filipino">Filipino</option>
                <option value="Non-Filipino">Non-Filipino</option>
            </select>
        </div>

        <!-- EDUCATION -->
        <label>Educational</label>
        <div class="row">
            <select name="education" required>
                <option value="" disabled selected>Select Education level</option>
                <option>College</option>
                <option>College Undergraduate</option>
                <option>Associate Graduate</option>
                <option>College Graduate</option>
                <option>Vocational/ TESDA</option>
                <option>Senior High School Level</option>
                <option>Elementary Level</option>
                <option>Postgraduate</option>
            </select>
        </div>

        <!-- SUMMARY -->
        <label>Summary</label>
        <textarea name="description"></textarea>

        <!-- BUTTONS -->
        <div class="button-container" style="display:flex; justify-content:flex-end; gap:10px; margin-top:25px;">

            <!-- DELETE BUTTON (BEFORE SAVE) -->
            <button type="button" class="save-btn" style="background:#c0392b;">DELETE</button>

            <!-- SAVE BUTTON -->
            <button type="submit" class="save-btn">SAVE</button>

        </div>


    </form>


    <script>
        const firstNameInput = document.querySelector('input[name="first_name"]');
        const lastNameInput = document.querySelector('input[name="last_name"]');
        const resumeName = document.getElementById("resumeName");
        const code = document.getElementById("countryCode");
        const input = document.getElementById("contactNumber");

        function updateResumeName() {
            const first = firstNameInput.value.trim();
            const last = lastNameInput.value.trim();
            if (first === "" && last === "") {
                resumeName.innerText = "Your Resume";
            } else {
                resumeName.innerText = first + " " + last + " – Resume";
            }
        }

        firstNameInput.addEventListener("input", updateResumeName);
        lastNameInput.addEventListener("input", updateResumeName);

        function updateInput() {
            input.value = code.value + " ";
        }

        updateInput();

        code.addEventListener("change", updateInput);

        input.addEventListener("input", () => {
            const country = code.options[code.selectedIndex];
            const maxLen = parseInt(country.dataset.max, 10);
            if (!input.value.startsWith(code.value)) {
                input.value = code.value + " ";
            }
            let number = input.value.replace(code.value, "").trim();
            number = number.replace(/[^0-9]/g, "");
            if (number.length > maxLen) {
                number = number.slice(0, maxLen);
            }
            input.value = code.value + " " + number;
        });
    </script>

    <script>
document.addEventListener("DOMContentLoaded", function () {

    // get all edit buttons
    const editButtons = document.querySelectorAll(".save-btn[style*='background:#4a90e2']");

    editButtons.forEach((btn) => {
        btn.addEventListener("click", function () {

            // get the input/select/textarea inside same row
            const input = this.parentElement.querySelector("input, select, textarea");
            if (!input) return;

            // unlock permanently
            input.removeAttribute("readonly");
            input.removeAttribute("disabled");

            // style to show active edit
            input.style.background = "#fff";
            input.focus();

            // keep button name as EDIT
            this.innerText = "Edit";
        });
    });

});
</script>


    </body>
    </html>
