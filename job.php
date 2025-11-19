<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Preferences - KM Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a2b3c6c0f3.js" crossorigin="anonymous"></script>
  <style>
    body {
      background-color: #fff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      color: #000;
    }
    .container-main {
      max-width: 700px;
      margin: 60px auto;
      padding: 0 20px;
    }
    .page-title {
      font-weight: 700;
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
    a.back-arrow {
      text-decoration: none;
      font-size: 1.5rem;
      margin-bottom: 15px;
      display: inline-block;
      color: #000;
    }

    /* Overlay Styles */
    .overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }
    .overlay-content {
      background: white;
      padding: 30px;
      border-radius: 10px;
      width: 90%;
      max-width: 600px;
      position: relative;
      box-shadow: 0 2px 12px rgba(0,0,0,0.2);
    }
    .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 22px;
      cursor: pointer;
    }

    /* Work Schedule Overlay Design */
    .schedule-section {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      margin-bottom: 15px;
    }
    .schedule-section > div {
      flex: 1 1 200px;
    }
    .schedule-section h6 {
      font-weight: 600;
      font-size: 16px;
      margin-bottom: 10px;
    }
    .schedule-section label {
      display: block;
      margin-bottom: 6px;
      font-size: 15px;
      cursor: pointer;
    }
    .schedule-section input[type="checkbox"] {
      margin-right: 8px;
      transform: scale(1.1);
      cursor: pointer;
    }
    /* Close button for overlays */
.close-btn {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    font-weight: bold;
    cursor: pointer;
    color: #333;
}

  </style>
</head>
<body>

  <div class="container container-main">
    <a href="profile.php" class="back-arrow">&#8592;</a>
    <h3 class="page-title mb-4">Job preferences</h3>

    <!-- Job preference items -->
    <div class="qual-item">
      <div class="qual-text">
        <i class="fas fa-user-tie qual-icon"></i>
        Add job titles
      </div>
      <div class="qual-plus" onclick="openOverlay('titleOverlay')">+</div>
    </div>

    <div class="qual-item">
      <div class="qual-text">
        <i class="fas fa-pencil-alt qual-icon"></i>
        Add job types
      </div>
      <div class="qual-plus" onclick="openOverlay('typeOverlay')">+</div>
    </div>

    <div class="qual-item">
      <div class="qual-text">
        <i class="fas fa-calendar-check qual-icon"></i>
        Add work schedule
      </div>
      <div class="qual-plus" onclick="openOverlay('scheduleOverlay')">+</div>
    </div>

    <div class="qual-item">
  <div class="qual-text">
    <i class="fas fa-coins qual-icon"></i>
    Add pay
  </div>
  <div class="qual-plus" onclick="openPayOverlay()">+</div>
</div>

   <div class="qual-item">
  <div class="qual-text">
    <i class="fas fa-truck-moving qual-icon"></i>
    Add relocation
  </div>
  <div class="qual-plus" onclick="openOverlay('relocationOverlay')">+</div>
</div>

   <div class="qual-item">
  <div class="qual-text">
    <i class="fas fa-laptop-house qual-icon"></i>
    Add remote
  </div>
  <div class="qual-plus" onclick="openOverlay('remoteOverlay')">+</div>
</div>

  <!-- Overlay for Job Titles -->
  <div id="titleOverlay" class="overlay">
    <div class="overlay-content">
      <span class="close-btn" onclick="closeOverlay('titleOverlay')">&times;</span>
      <h5 class="fw-bold mb-4">Edit job titles</h5>
      <form action="save_job_titles.php" method="POST">
        <div class="mb-4">
          <label class="form-label">What are your desired job titles?</label>
          <input type="text" class="form-control" name="job_title" placeholder="Enter desired job titles" required>
        </div>
        <div class="d-flex justify-content-end gap-2">
          <button type="button" class="btn btn-outline-secondary" onclick="closeOverlay('titleOverlay')">CANCEL</button>
          <button type="submit" class="btn btn-success">SAVE</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Overlay for Job Types -->
  <div id="typeOverlay" class="overlay">
    <div class="overlay-content">
      <span class="close-btn" onclick="closeOverlay('typeOverlay')">&times;</span>
      <h6 class="fw-semibold mb-3">Edit job types</h6>
      <form action="save_job_types.php" method="POST">
        <p>What is your desired job type?</p>
        <div class="row">
          <div class="col-6">
            <div class="form-check"><input class="form-check-input" type="radio" name="job_type" value="Full-time" id="type-fulltime"><label class="form-check-label" for="type-fulltime">Full-time</label></div>
            <div class="form-check"><input class="form-check-input" type="radio" name="job_type" value="Part-time" id="type-parttime"><label class="form-check-label" for="type-parttime">Part-time</label></div>
            <div class="form-check"><input class="form-check-input" type="radio" name="job_type" value="Permanent" id="type-permanent"><label class="form-check-label" for="type-permanent">Permanent</label></div>
            <div class="form-check"><input class="form-check-input" type="radio" name="job_type" value="Fixed term" id="type-fixedterm"><label class="form-check-label" for="type-fixedterm">Fixed term</label></div>
            <div class="form-check"><input class="form-check-input" type="radio" name="job_type" value="Temporary" id="type-temporary"><label class="form-check-label" for="type-temporary">Temporary</label></div>
          </div>
          <div class="col-6">
            <div class="form-check"><input class="form-check-input" type="radio" name="job_type" value="OJT" id="type-ojt"><label class="form-check-label" for="type-ojt">OJT (On the job training)</label></div>
            <div class="form-check mt-2"><input class="form-check-input" type="radio" name="job_type" value="Fresh Graduate" id="type-freshgrad"><label class="form-check-label" for="type-freshgrad">Fresh graduate</label></div>
          </div>
        </div>
        <div class="text-end mt-4">
          <button type="button" class="btn btn-outline-secondary me-2" onclick="closeOverlay('typeOverlay')">CANCEL</button>
          <button type="submit" class="btn btn-success">SAVE</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ✅ Overlay for Work Schedule (with Radio Buttons) -->
<div id="scheduleOverlay" class="overlay">
  <div class="overlay-content">
    <span class="close-btn" onclick="closeOverlay('scheduleOverlay')">&times;</span>
    <h5 class="fw-bold mb-3">Edit work schedule</h5>

    <form action="save_work_schedule.php" method="POST">
      <div class="schedule-section">
        <div>
          <h6>Days</a></h6>
          <label><input type="radio" name="days" value="Monday to Friday"> Monday to Friday</label>
          <label><input type="radio" name="days" value="Holidays"> Holidays</label>
          <label><input type="radio" name="days" value="Weekends"> Weekends</label>
        </div>

        <div>
          <h6>Schedules</h6>
          <label><input type="radio" name="schedule" value="Flextime"> Flextime</label>
          <label><input type="radio" name="schedule" value="Overtime"> Overtime</label>
          <label><input type="radio" name="schedule" value="On call"> On call</label>
        </div>
      </div>

      <h6 class="mt-3">Shifts</h6>
      <div class="schedule-section">
        <div>
          <label><input type="radio" name="shift" value="8 hour shift"> 8 hour shift</label>
          <label><input type="radio" name="shift" value="10 hour shift"> 10 hour shift</label>
          <label><input type="radio" name="shift" value="12 hour shift"> 12 hour shift</label>
          <label><input type="radio" name="shift" value="Shift system"> Shift system</label>
          <label><input type="radio" name="shift" value="Early shift"> Early shift</label>
          <label><input type="radio" name="shift" value="Day shift"> Day shift</label>
        </div>

        <div>
          <label><input type="radio" name="shift" value="Afternoon shift"> Afternoon shift</label>
          <label><input type="radio" name="shift" value="Evening shift"> Evening shift</label>
          <label><input type="radio" name="shift" value="Late shift"> Late shift</label>
          <label><input type="radio" name="shift" value="Night shift"> Night shift</label>
          <label><input type="radio" name="shift" value="Rotational shift"> Rotational shift</label>
          <label><input type="radio" name="shift" value="Fixed shift"> Fixed shift</label>
        </div>
      </div>

      <div class="text-end mt-3">
        <button type="button" class="btn btn-outline-secondary me-2" onclick="closeOverlay('scheduleOverlay')">CANCEL</button>
        <button type="submit" class="btn btn-success">SAVE</button>
      </div>
    </form>
  </div>
</div>
<!-- Edit Pay Overlay -->
<div id="payOverlay" class="overlay">
    <div class="overlay-content">
        <!-- ✅ Close button on top-right -->
        <span class="close-btn" onclick="closePayOverlay()">&times;</span>

        <h2>Edit Pay</h2>
        <p><strong>What is the minimum pay you'll consider in your search?</strong></p>
        <p><span style="font-style: italic;">&#128065; Not shown to employers.</span></p>

        <form action="save_pay.php" method="POST" style="margin-top:20px;">
            <div style="display:flex; gap:15px; margin-bottom:20px;">
                <div style="flex:1; display:flex; flex-direction:column;">
                    <label for="minPay">Minimum base pay</label>
                    <input type="number" name="minPay" id="minPay" placeholder="Enter amount" style="padding:8px 12px; border-radius:6px; border:1px solid #ccc;">
                </div>
                <div style="flex:1; display:flex; flex-direction:column;">
                    <label for="payPeriod">Pay period</label>
                    <select name="payPeriod" id="payPeriod" style="padding:8px 12px; border-radius:6px; border:1px solid #ccc;">
                        <option value="">Select period</option>
                        <option value="Hourly">Hourly</option>
                        <option value="Daily">Daily</option>
                        <option value="Weekly">Weekly</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Yearly">Yearly</option>
                    </select>
                </div>
            </div>

            <div style="text-align:right; display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" onclick="deletePay()" style="background:none; border:none; color:#888; font-weight:bold; cursor:pointer;">Delete</button>
                <button type="button" onclick="closePayOverlay()" style="background:none; border:none; color:#888; font-weight:bold; cursor:pointer;">Cancel</button>
                <button type="submit" style="background-color:#91ad89; color:#fff; border:none; border-radius:6px; padding:8px 25px; font-weight:bold; cursor:pointer;">Save</button>
            </div>
        </form>
    </div>
</div>
<!-- ✅ Overlay for Relocation -->
<div id="relocationOverlay" class="overlay">
  <div class="overlay-content">
    <span class="close-btn" onclick="closeOverlay('relocationOverlay')">&times;</span>
    <h5 class="fw-bold mb-3">Add relocation</h5>
    <form action="save_relocation.php" method="POST">
      <p>Are you willing to relocate?</p>
      <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" id="relocate" name="relocate" value="Yes">
        <label class="form-check-label" for="relocate">
          Yes, I'm willing to relocate
        </label>
      </div>
      <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-outline-secondary" onclick="closeOverlay('relocationOverlay')">CANCEL</button>
        <button type="submit" class="btn btn-success">SAVE</button>
      </div>
    </form>
  </div>
</div>
<!-- ✅ Overlay for Remote Work -->
<div id="remoteOverlay" class="overlay">
  <div class="overlay-content">
    <span class="close-btn" onclick="closeOverlay('remoteOverlay')">&times;</span>
    <h5 class="fw-bold mb-3">Add remote</h5>

    <form action="save_remote.php" method="POST">
      <p>Desired work setting</p>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="remote" name="work_setting[]" value="Remote">
        <label class="form-check-label" for="remote">Remote</label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="hybrid" name="work_setting[]" value="Hybrid work">
        <label class="form-check-label" for="hybrid">Hybrid work</label>
      </div>

      <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" id="inperson" name="work_setting[]" value="In-person">
        <label class="form-check-label" for="inperson">In-person</label>
      </div>

      <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-outline-secondary" onclick="closeOverlay('remoteOverlay')">CANCEL</button>
        <button type="submit" class="btn btn-success">SAVE</button>
      </div>
    </form>
  </div>
</div>

  <script>
    function openOverlay(id) {
      document.getElementById(id).style.display = 'flex';
    }
    function closeOverlay(id) {
      document.getElementById(id).style.display = 'none';
    }
     function openPayOverlay() {
        document.getElementById('payOverlay').style.display = 'flex';
    }
    function closePayOverlay() {
        document.getElementById('payOverlay').style.display = 'none';
    }

    function deletePay() {
        if(confirm("Are you sure you want to delete your pay info?")) {
            alert("Pay info deleted (demo).");
            closePayOverlay();
        }
    }
    window.addEventListener('click', function(e) {
      document.querySelectorAll('.overlay').forEach(overlay => {
        if (e.target === overlay) overlay.style.display = 'none';
      });
    });
  </script>

</body>
</html>
