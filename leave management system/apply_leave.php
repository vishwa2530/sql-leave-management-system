<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'student') {
    header("Location: index.php");
    exit();
}

if (isset($_POST['apply'])) {
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $reason = $_POST['reason'];
    $user_id = $_SESSION['user']['id'];

    $sql = "INSERT INTO leaves (user_id, start_date, end_date, reason) VALUES ('$user_id','$start','$end','$reason')";
    mysqli_query($conn, $sql);

    header("Location: student_dashboard.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Apply Leave</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Apply for Leave</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Reason</label>
            <textarea name="reason" class="form-control" required></textarea>
        </div>
        <button class="btn btn-primary" name="apply">Submit</button>
    </form>
</div>
</body>
</html>
