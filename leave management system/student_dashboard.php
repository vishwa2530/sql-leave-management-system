<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'student') {
    header("Location: index.php");
    exit();
}

$user = $_SESSION['user'];
$result = mysqli_query($conn, "SELECT * FROM leaves WHERE user_id=" . $user['id']);
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
            position: relative;
            overflow-x: hidden;
        }

        /* Optional star overlay */
        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: url('https://www.transparenttextures.com/patterns/stardust.png');
            opacity: 0.1;
            z-index: -1;
        }
        body {
    background: linear-gradient(135deg, #459da1ff, #282a2eff);
    height: 100vh;
    margin: 0;
    font-family: Arial, sans-serif;
    position: relative;
    overflow-x: hidden;
}

        .container {
            margin-top: 50px;
            background: rgba(255, 255, 255, 0.15);
            padding: 25px;
            border-radius: 20px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            color: #fff;
        }

        h2, h3 {
            text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
        }

        .btn-custom {
            padding: 10px 22px;
            border-radius: 30px;
            font-weight: bold;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .btn-custom:hover {
            transform: translateY(-2px);
        }

        .btn-apply {
            margin-bottom: 20px;
            background: #00b4d8;
            color: white;
        }

        .btn-danger {
            background-color: #ef476f !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead th {
            background-color: rgba(0, 0, 0, 0.3);
            color: white;
            text-align: center;
        }

        .table td {
            text-align: center;
            padding: 12px;
            background: linear-gradient(145deg, #f1f1f1, #d7d7d7);
            color: #222;
            transition: background 0.3s;
        }

        .table tbody tr:hover td {
            background-color: #fff4dcff !important;
        }

        .status-approved {
            background-color: #38b000;
            color: white;
            border-radius: 10px;
            padding: 4px 10px;
            font-weight: bold;
        }

        .status-pending {
            background-color: #f9c74f;
            color: #000;
            border-radius: 10px;
            padding: 4px 10px;
            font-weight: bold;
        }

        .status-rejected {
            background-color: #d00000;
            color: white;
            border-radius: 10px;
            padding: 4px 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome, <?php echo $user['name']; ?> (Student)</h2>
   <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="apply_leave.php" class="btn btn-custom btn-apply me-2">Apply for Leave</a>
    <a href="logout.php" class="btn btn-custom btn-danger">Logout</a>
</div>

    
    <h3>Your Leave Requests</h3>
    <table class="table table-striped">
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
                    $statusClass = '';
                    switch (strtolower($row['status'])) {
                        case 'approved':
                            $statusClass = 'status-approved';
                            break;
                        case 'pending':
                            $statusClass = 'status-pending';
                            break;
                        case 'rejected':
                            $statusClass = 'status-rejected';
                            break;
                        default:
                            $statusClass = '';
                    }

                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['start_date']}</td>
                        <td>{$row['end_date']}</td>
                        <td>{$row['reason']}</td>
                        <td><span class='$statusClass'>{$row['status']}</span></td>
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
