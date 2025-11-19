<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Remote</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f8f9fa;
    }

    .remote-container {
      background: #fff;
      padding: 25px 30px;
      border-radius: 10px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
      width: 400px;
    }

    .form-check-label {
      font-size: 15px;
    }

    .btn-cancel {
      background-color: #cfcfcf;
      color: black;
      border: none;
      padding: 6px 18px;
      border-radius: 6px;
      font-weight: 500;
    }

    .btn-save {
      background-color: #8fbf8f;
      border: none;
      color: black;
      padding: 6px 18px;
      border-radius: 6px;
      font-weight: 500;
    }

    .btn-cancel:hover, .btn-save:hover {
      opacity: 0.9;
    }
  </style>
</head>
<body>

  <div class="remote-container">
    <h6 class="fw-semibold mb-3">Add remote</h6>
    
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

      <div class="text-end">
        <button type="button" class="btn-cancel me-2">CANCEL</button>
        <button type="submit" class="btn-save">SAVE</button>
      </div>
    </form>
  </div>

</body>
</html>
