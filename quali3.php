<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Qualifications - KM Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family:  'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 0;
      margin: 0;
      color: #000;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 50px;
      background-color: white;
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
    .qualifications {
      margin: 60px auto 0;
      max-width: 700px;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 40px;
    }
    .qual-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: white;
      border-radius: 10px;
      padding: 15px 20px;
      margin-bottom: 15px;
      box-shadow: 0 1px 4px rgba(0,0,0,0.08);
      transition: 0.3s;
      width: 100%;
    }
    .qual-item:hover {
      transform: translateY(-3px);
    }
    .qual-text {
      display: flex;
      align-items: center;
      gap: 10px;
      font-weight: 500;
    }
    .qual-icon {
      font-size: 1.3rem;
    }
    .qual-plus {
      font-size: 1.4rem;
      font-weight: bold;
      cursor: pointer;
    }
    .header-text {
      color: #555;
      margin-bottom: 25px;
      text-align: center;
    }
    a.back-arrow {
      text-decoration: none;
      font-size: 1.5rem;
      margin-bottom: 15px;
      display: inline-block;
      color: #000;
      align-self: flex-start;
    }
    h3 {
      text-align: center;
      margin-bottom: 10px;
    }
    .modal-content {
      border-radius: 15px;
      border: none;
    }
    .modal-header {
      border-bottom: none;
      padding: 20px 40px 0;
    }
    .modal-body {
      padding: 20px 40px;
    }
    .modal-footer {
      border-top: none;
      padding: 0 40px 20px;
    }
    .form-label {
      font-weight: 500;
    }
    .form-control {
      border-radius: 10px;
    }
    .form-check-label {
      font-size: 0.95rem;
      color: #555;
    }
    .btn-cancel {
      background-color: white;
      border: 1px solid #ccc;
      color: #000;
    }
    .btn-cancel:hover {
      background-color: #f2f2f2;
    }
    .btn-save-another {
      background-color: white;
      border: 1px solid #ccc;
      color: #000;
    }
    .btn-save-another:hover {
      background-color: #f2f2f2;
    }
    .btn-save {
      background-color: #8AB78A;
      color: white;
      border: none;
    }
    .btn-save:hover {
      background-color: #77a477;
    }
    /* Additional styles for modals */
    .time-row {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }
    .time-row .form-control {
      flex: 1;
    }
  </style>
  <script src="https://kit.fontawesome.com/a2b3c6c0f3.js" crossorigin="anonymous"></script>
</head>
<body>

  <!-- Header -->
  <header>
    <div class="logo">KM Services</div>
    <nav>
      <a href="index.php">Home</a>
      <a href="about.php">About Us</a>
      <a href="profile.php">Profile</a>
    </nav>
  </header>

  <!-- Main Content -->
  <div class="qualifications">
    <a href="profile.php" class="back-arrow">&#8592;</a>
    <h3 class="fw-bold">Qualifications</h3>
    <p class="header-text">We use these details to show you jobs that match your unique skills and experience.</p>

    <!-- Qualification Items -->
    <div class="qual-item">
      <div class="qual-text">
        <i class="fas fa-briefcase qual-icon"></i>
        Add most recent work experience
      </div>
      <!-- ✅ Work Experience overlay trigger -->
      <div class="qual-plus" data-bs-toggle="modal" data-bs-target="#addWorkExperienceModal">+</div>
    </div>

    <div class="qual-item">
      <div class="qual-text">
        <i class="fas fa-graduation-cap qual-icon"></i>
        Add education
      </div>
      <!-- ✅ Education overlay trigger -->
      <div class="qual-plus" data-bs-toggle="modal" data-bs-target="#addEducationModal">+</div>
    </div>

    <div class="qual-item">
      <div class="qual-text">
        <i class="fas fa-lightbulb qual-icon"></i>
        Add skill
      </div>
      <!-- ✅ Skill overlay trigger -->
      <div class="qual-plus" data-bs-toggle="modal" data-bs-target="#addSkillModal">+</div>
    </div>

    <div class="qual-item">
      <div class="qual-text">
        <i class="fas fa-id-card qual-icon"></i>
        Add license
      </div>
      <div class="qual-plus" data-bs-toggle="modal" data-bs-target="#addLicenseModal">+</div>
    </div>

    <div class="qual-item">
      <div class="qual-text">
        <i class="fas fa-certificate qual-icon"></i>
        Add certification
      </div>
      <!-- ✅ Certification overlay trigger -->
      <div class="qual-plus" data-bs-toggle="modal" data-bs-target="#addCertificationModal">+</div>
    </div>
  </div>

<!-- License Modal -->
<div class="modal fade" id="addLicenseModal" tabindex="-1" aria-labelledby="addLicenseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="addLicenseModalLabel">Add License</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="save_license.php" method="POST">
          <div class="mb-3">
            <label class="form-label">License Name</label>
            <input type="text" class="form-control" name="license_name" placeholder="Example: Driver's License" required>
          </div>

          <label class="form-label">Expiration Date</label>
          <div class="row mb-3">
            <div class="col">
              <input type="text" class="form-control" name="month" placeholder="Month">
            </div>
            <div class="col">
              <input type="text" class="form-control" name="year" placeholder="Year">
            </div>
          </div>

          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="no_expire" id="no_expire">
            <label class="form-check-label" for="no_expire">Does not expire</label>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="save_another" class="btn btn-save-another">Save and add another</button>
            <button type="submit" name="save" class="btn btn-save">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Education Modal (Overlay in center) -->
<div class="modal fade" id="addEducationModal" tabindex="-1" aria-labelledby="addEducationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- centers the popup -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="addEducationModalLabel">Add Education</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="save_education.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Level of education *</label>
            <input type="text" class="form-control" name="level" placeholder="e.g. Bachelor's Degree" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Field of study *</label>
            <input type="text" class="form-control" name="field" placeholder="e.g. Computer Science" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Country</label>
            <input type="text" class="form-control" name="country" value="Philippines">
          </div>

          <div class="mb-3">
            <label class="form-label">School location</label>
            <input type="text" class="form-control" name="school" placeholder="e.g. Mabalacat, Pampanga">
          </div>

          <div class="mb-3">
            <label class="form-label">Time period</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="current" id="current" onclick="toggleToDate()">
              <label class="form-check-label" for="current">I currently study here</label>
            </div>

            <div class="time-row">
              <div>
                <label class="form-label">From</label>
                <input type="text" class="form-control" name="from_month" placeholder="Month">
              </div>
              <div>
                <label class="form-label">&nbsp;</label>
                <input type="text" class="form-control" name="from_year" placeholder="Year">
              </div>
            </div>

            <div class="time-row">
              <div>
                <label class="form-label">To</label>
                <input type="text" class="form-control" name="to_month" placeholder="Month" id="to_month">
              </div>
              <div>
                <label class="form-label">&nbsp;</label>
                <input type="text" class="form-control" name="to_year" placeholder="Year" id="to_year">
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="save_another" class="btn btn-save-another">Save and add another</button>
            <button type="submit" name="save" class="btn btn-save">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Skill Modal (Overlay in center) -->
<div class="modal fade" id="addSkillModal" tabindex="-1" aria-labelledby="addSkillModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- centers the popup -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="addSkillModalLabel">Add Skill</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="submit_skill.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Skill *</label>
            <input type="text" class="form-control" name="skill" placeholder="Example: JavaScript" required>
          </div>

          <div class="mb-4">
            <label class="form-label">Years of experience</label>
            <input type="number" class="form-control" name="experience" min="0" placeholder="0">
          </div>

          <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="save_add" class="btn btn-save-another">Save and add another</button>
            <button type="submit" name="save" class="btn btn-save">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Work Experience Modal (Overlay in center) -->
<div class="modal fade" id="addWorkExperienceModal" tabindex="-1" aria-labelledby="addWorkExperienceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- centers the popup -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="addWorkExperienceModalLabel">Add Work Experience</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="save_work_experience.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Job Title *</label>
            <input type="text" class="form-control" name="job_title" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Company *</label>
            <input type="text" class="form-control" name="company" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Country</label>
            <input type="text" class="form-control" name="country" placeholder="e.g. Philippines">
          </div>

          <div class="mb-3">
            <label class="form-label">City, State</label>
            <input type="text" class="form-control" name="city_state" placeholder="e.g. Mabalacat, Pampanga">
          </div>

          <div class="mb-3">
            <label class="form-label">Time Period</label>
            <div class="time-row">
              <div>
                <label class="form-label">From</label>
                <input type="date" class="form-control" name="from">
              </div>
              <div>
                <label class="form-label">To</label>
                <input type="date" class="form-control" name="to">
              </div>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label">Description (Recommended)</label>
            <textarea class="form-control" name="description" placeholder="Describe your work experience..." rows="4"></textarea>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="save_another" class="btn btn-save-another">Save and add another</button>
            <button type="submit" name="save" class="btn btn-save">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ✅ Certification Modal (Overlay in center) -->
<div class="modal fade" id="addCertificationModal" tabindex="-1" aria-labelledby="addCertificationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- centers the popup -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="addCertificationModalLabel">Add Certification</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="save_certification.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Certification Name</label>
            <input type="text" class="form-control" name="cert_name" placeholder="Example: MOS Associate" required>
          </div>

          <label class="form-label">Expiration Date</label>
          <div class="row mb-3">
            <div class="col">
              <input type="text" class="form-control" name="month" placeholder="Month">
            </div>
            <div class="col">
              <input type="text" class="form-control" name="year" placeholder="Year">
            </div>
          </div>

          <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="no_expire" id="cert_no_expire">
            <label class="form-check-label" for="cert_no_expire">Does not expire</label>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" name="save_another" class="btn btn-save-another">Save and add another</button>
             <button type="submit" name="save_another" class="btn btn-save">Save</button>
   </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function toggleToDate() {
    const isChecked = document.getElementById('current').checked;
    document.getElementById('to_month').disabled = isChecked;
    document.getElementById('to_year').disabled = isChecked;
  }
</script>
</body>
</html>
