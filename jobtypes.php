<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Job Types</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f8f9fa;
    }
    .job-form {
      background: #fff;
      padding: 25px 30px;
      border-radius: 10px;
      box-shadow: 0px 3px 10px rgba(0,0,0,0.1);
      width: 380px;
    }
    .btn-cancel {
      border: 1px solid #ccc;
      background: white;
    }
    .btn-save {
      background-color: #c8f2d1;
      border: none;
      color: black;
    }
  </style>
</head>
<body>

<div class="job-form">
  <h6 class="fw-semibold mb-3">Edit job types</h6>
  <form action="save_job_types.php" method="POST">
    <p>What are your desired job types?</p>
    
    <div class="row">
      <div class="col-6">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="job_types[]" value="Full-time" id="fulltime">
          <label class="form-check-label" for="fulltime">Full-time</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="job_types[]" value="Part-time" id="parttime">
          <label class="form-check-label" for="parttime">Part-time</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="job_types[]" value="Permanent" id="permanent">
          <label class="form-check-label" for="permanent">Permanent</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="job_types[]" value="Fixed term" id="fixedterm">
          <label class="form-check-label" for="fixedterm">Fixed term</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="job_types[]" value="Temporary" id="temporary">
          <label class="form-check-label" for="temporary">Temporary</label>
        </div>
      </div>

      <div class="col-6">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="job_types[]" value="OJT" id="ojt">
          <label class="form-check-label" for="ojt">OJT (On the job training)</label>
        </div>
        <div class="form-check mt-2">
          <input class="form-check-input" type="checkbox" name="job_types[]" value="Fresh Graduate" id="freshgrad">
          <label class="form-check-label" for="freshgrad">Fresh graduate</label>
        </div>
      </div>
    </div>

    <div class="text-end mt-4">
      <button type="button" class="btn btn-cancel me-2">CANCEL</button>
      <button type="submit" class="btn btn-save">SAVE</button>
    </div>
  </form>
</div>

</body>
</html>
