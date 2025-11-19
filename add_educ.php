

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Education - KM Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
    }
    .container {
      max-width: 650px;
      background: white;
      padding: 40px;
      margin-top: 60px;
      border-radius: 15px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h3 {
      font-weight: 700;
      margin-bottom: 10px;
    }
    label {
      font-weight: 600;
      margin-top: 15px;
    }
    .btn-save {
      background-color: #0025ff;
      color: white;
      font-weight: 600;
      border: none;
      padding: 8px 25px;
      border-radius: 5px;
      margin-top: 25px;
    }
    .btn-save:hover {
      background-color: #001bcc;
    }
    .btn-cancel {
      background: transparent;
      border: 1px solid #ccc;
      padding: 8px 20px;
      border-radius: 5px;
      margin-right: 10px;
    }
    .btn-cancel:hover {
      background: #f0f0f0;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
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
    <h3>Add education</h3>
    <p class="text-muted">Please fill out the form below <span class="text-danger">*</span>required</p>

    <form method="POST">
      <div class="mb-3">
        <label for="level" class="form-label">Level of education</label>
        <input type="text" name="level" id="level" class="form-control" placeholder="">
      </div>

      <div class="mb-3">
        <label for="field" class="form-label">Field of study <span class="text-danger">*</span></label>
        <input type="text" name="field" id="field" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="country" class="form-label">Country</label>
        <div class="d-flex justify-content-between align-items-center">
          <span>Philippines</span>
          <a href="#" class="text-primary">Change</a>
        </div>
        <input type="hidden" name="country" value="Philippines">
      </div>

      <div class="mb-3">
        <label for="school_location" class="form-label">School location</label>
        <input type="text" name="school_location" id="school_location" class="form-control">
      </div>

      <div class="mb-3">
        <label class="form-label">Time period</label><br>
        <input type="checkbox" name="currently_here" id="currently_here">
        <label for="currently_here">I currently work here</label>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label for="from_month" class="form-label">From</label>
          <div class="d-flex gap-2">
            <input type="text" name="from_month" placeholder="Month" class="form-control">
            <input type="text" name="from_year" placeholder="Year" class="form-control">
          </div>
        </div>
        <div class="col-md-6">
          <label for="to_month" class="form-label">To</label>
          <div class="d-flex gap-2">
            <input type="text" name="to_month" placeholder="Month" class="form-control">
            <input type="text" name="to_year" placeholder="Year" class="form-control">
          </div>
        </div>
      </div>

      <div class="text-end">
        <button type="button" class="btn-cancel" onclick="window.history.back()">CANCEL</button>
        <button type="submit" class="btn-save">SAVE</button>
      </div>
    </form>
  </div>
</body>
</html>
