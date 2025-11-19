<!DOCTYPE html>
<html>
<head>
    <title>Edit Work Schedule</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .form-container {
            width: 400px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .form-section {
            margin-bottom: 15px;
        }

        .form-section h4 {
            margin-bottom: 8px;
        }

        .form-section label {
            display: block;
            margin: 4px 0;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
        }

        button {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .cancel-btn {
            background-color: #ccc;
        }

        .save-btn {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>

<div class="form-container">
    <form method="post" action="save_schedule.php">
        <!-- Days -->
        <div class="form-section">
            <h4>Days</h4>
            <label><input type="checkbox" name="days[]" value="Monday to Friday"> Monday to Friday</label>
            <label><input type="checkbox" name="days[]" value="Holidays"> Holidays</label>
            <label><input type="checkbox" name="days[]" value="Weekends"> Weekends</label>
        </div>

        <!-- Shifts -->
        <div class="form-section">
            <h4>Shifts</h4>
            <label><input type="checkbox" name="shifts[]" value="8 hour shift"> 8 hour shift</label>
            <label><input type="checkbox" name="shifts[]" value="10 hour shift"> 10 hour shift</label>
            <label><input type="checkbox" name="shifts[]" value="12 hour shift"> 12 hour shift</label>
            <label><input type="checkbox" name="shifts[]" value="Shift system"> Shift system</label>
            <label><input type="checkbox" name="shifts[]" value="Early shift"> Early shift</label>
            <label><input type="checkbox" name="shifts[]" value="Day shift"> Day shift</label>
            <label><input type="checkbox" name="shifts[]" value="Afternoon shift"> Afternoon shift</label>
            <label><input type="checkbox" name="shifts[]" value="Evening shift"> Evening shift</label>
            <label><input type="checkbox" name="shifts[]" value="Late shift"> Late shift</label>
            <label><input type="checkbox" name="shifts[]" value="Night shift"> Night shift</label>
            <label><input type="checkbox" name="shifts[]" value="Rotational shift"> Rotational shift</label>
            <label><input type="checkbox" name="shifts[]" value="Fixed shift"> Fixed shift</label>
        </div>

        <!-- Schedules -->
        <div class="form-section">
            <h4>Schedules</h4>
            <label><input type="checkbox" name="schedules[]" value="Flextime"> Flextime</label>
            <label><input type="checkbox" name="schedules[]" value="Overtime"> Overtime</label>
            <label><input type="checkbox" name="schedules[]" value="On call"> On call</label>
        </div>

        <!-- Buttons -->
        <div class="buttons">
            <button type="button" class="cancel-btn" onclick="window.location.href='index.php'">CANCEL</button>
            <button type="submit" class="save-btn">SAVE</button>
        </div>
    </form>
</div>

</body>
</html>
