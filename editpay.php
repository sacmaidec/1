<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pay</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #f8f9fa;
    }
    .edit-pay-box {
      background: #fff;
      padding: 25px 30px;
      border-radius: 10px;
      box-shadow: 0px 3px 10px rgba(0,0,0,0.1);
      width: 400px;
    }
    .form-control {
      border-radius: 8px;
    }
    .btn-delete {
      color: red;
      background: none;
      border: none;
      font-weight: 500;
    }
    .btn-cancel {
      border: none;
      background: none;
    }
    .btn-save {
      background-color: #c8f2d1;
      border: none;
      color: black;
    }
    .muted-text {
      color: #6c757d;
      font-size: 0.9em;
    }
  </style>
</head>
<body>

<div class="edit-pay-box">
  <h6 class="fw-semibold mb-3">Edit Pay</h6>

  <form action="save_pay.php" method="POST">
    <p>What is the minimum pay you'll consider in your search?</p>

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" id="hideFromEmployers" name="hide_from_employers" checked>
      <label class="form-check-label muted-text" for="hideFromEmployers">
        Not shown to employers.
      </label>
    </div>

    <div class="row mb-4">
      <div class="col-6">
        <label for="basePay" class="form-label">Minimum base pay</label>
        <input type="text" class="form-control" id="basePay" name="base_pay" placeholder="e.g. ₱15000">
      </div>
      <div class="col-6">
        <label for="payPeriod" class="form-label">Pay period</label>
        <input type="text" class="form-control" id="payPeriod" name="pay_period" placeholder="e.g. Monthly">
      </div>
    </div>

    <div class="text-end">
      <button type="button" class="btn-delete me-3">Delete</button>
      <button type="button" class="btn-cancel me-2">Cancel</button>
      <button type="submit" class="btn btn-save px-3">Save</button>
    </div>
  </form>
</div>

</body>
</html>
