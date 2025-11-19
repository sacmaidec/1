<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Job Titles</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }
    .form-container {
      background: white;
      border-radius: 15px;
      padding: 40px;
      max-width: 550px;
      margin: 70px auto;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .form-label {
      font-weight: 500;
      color: #000;
    }
    .form-control {
      border-radius: 10px;
      padding: 10px;
      font-size: 1rem;
    }
    .btn-cancel {
      background-color: white;
      border: 1px solid #ccc;
      color: #000;
      font-weight: 500;
      padding: 8px 18px;
      border-radius: 8px;
    }
    .btn-cancel:hover {
      background-color: #f2f2f2;
    }
    .btn-save {
      background-color: #C7E8C7;
      color: #000;
      font-weight: 500;
      border: none;
      padding: 8px 18px;
      border-radius: 8px;
    }
    .btn-save:hover {
      background-color: #a8d6a8;
    }
  </style>
</head>
<body>

<div class="form-container">
  <h5 class="fw-bold mb-4">Edit job titles</h5>

  <form action="save_job_titles.php" method="POST">
    <!-- Input -->
    <div class="mb-4">
      <label class="form-label">What are your desired job titles?</label>
      <input type="text" class="form-control" name="job_title" placeholder="Enter desired job titles" required>
    </div>

    <!-- Buttons -->
    <div class="d-flex justify-content-end gap-2">
      <button type="button" class="btn btn-cancel">CANCEL</button>
      <button type="submit" class="btn btn-save">SAVE</button>
    </div>
  </form>
</div>

</body>
</html>
