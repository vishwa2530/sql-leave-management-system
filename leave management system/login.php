<?php
session_start();
include 'db.php';

// Check if user is logged in and role is student
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'student') {
    header("Location: index.php");
    exit();
}

$user = $_SESSION['user'];

// Fetch student's leave requests
$user_id = $user['id'];
$sql = "SELECT * FROM leaves WHERE user_id = $user_id ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard - Leave Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('https://source.unsplash.com/1920x1080/?school,classroom') no-repeat center center/cover;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
            background: rgba(255,255,255,0.9);
            padding: 20px;
            border-radius: 15px;
        }
        table {
            width: 100%;
        }
        table th, table td {
            text-align: center;
            padding: 10px;
        }
        .btn-apply {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome, <?php echo $user['name']; ?> (Student)</h2>
    <a href="apply_leave.php" class="btn btn-primary btn-apply">Apply for Leave</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
    
    <h3>Your Leave Requests</h3>
    <table border="1" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Reason</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['start_date']}</td>
                        <td>{$row['end_date']}</td>
                        <td>{$row['reason']}</td>
                        <td>{$row['status']}</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No leave requests found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
