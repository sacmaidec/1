<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Relocation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f8f9fa;
    }

    .relocation-container {
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

  <div class="relocation-container">
    <h6 class="fw-semibold mb-3">Add relocation</h6>
    
    <form action="save_relocation.php" method="POST">
      <p>Are you willing to relocate?</p>

      <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" id="relocate" name="relocate">
        <label class="form-check-label" for="relocate">
          Yes, I'm willing to relocate
        </label>
      </div>

      <div class="text-end">
        <button type="button" class="btn-cancel me-2">CANCEL</button>
        <button type="submit" class="btn-save">SAVE</button>
      </div>
    </form>
  </div>

</body>
</html>
