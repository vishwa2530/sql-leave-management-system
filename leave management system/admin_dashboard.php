<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch leave requests with user details
$leaves = mysqli_query($conn, "SELECT l.*, u.name FROM leaves l JOIN users u ON l.user_id=u.id");

// Fetch leave counts
$pending = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM leaves WHERE status='Pending'");
$approved = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM leaves WHERE status='Approved'");
$rejected = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM leaves WHERE status='Rejected'");
#store the counts
$p = mysqli_fetch_assoc($pending)['cnt'];
$a = mysqli_fetch_assoc($approved)['cnt'];
$r = mysqli_fetch_assoc($rejected)['cnt'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #a2a6a6ff, #277b75ff);
            font-family: 'Poppins', sans-serif;
            color: #fff;
        }

        .container {
            margin-top: 30px;
        }

        h2 {
            font-weight: 700;
            color: #fff;
            margin-bottom: 20px;
        }

        h3 {
            font-weight: 600;
            margin: 30px 0 20px;
            color: #fff;
        }

        /* Summary Cards with Glass Effect */
        .summary-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.15);
            border-radius: 16px;
            padding: 25px;
            color: #fff;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            transition: 0.3s ease;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .summary-card:hover {
            transform: scale(1.05);
        }

        .pending-card { border: 3px solid #ffb347; }
        .approved-card { border: 3px solid #4CAF50; }
        .rejected-card { border: 3px solid #E74C3C; }

        
        /* Buttons */
        .btn {
            border-radius: 10px;
            padding: 10px 15px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-success:hover {
            background-color: #388e3c;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        /* Table Styling */
        .table-responsive {
            background: rgba(15, 13, 8, 0.9);
            backdrop-filter: blur(12px);
            border-radius: 10px;
            padding: 15px;
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background: rgba(0, 0, 0, 0.6);
        }

        .table thead th {
            color: #fff;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
        }

        .table tbody tr {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            text-align: center;
            font-size: 15px;
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.18);
            transition: 0.3s;
        }

        .table td {
            padding: 12px;
            vertical-align: middle;
        }

        .table thead {
    background: linear-gradient(135deg, #1e293b, #0f766e); /* dark blue-green gradient */
}

        .table thead th {
             color: #090e0dff; /* bright yellow for contrast */
             text-align: center;
             font-weight: 700;
             font-size: 16px;
             text-transform: uppercase;
             letter-spacing: 1px;
             padding: 12px;
}

.dashboard-card {
    background: rgba(255, 255, 255, 0.15);
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    margin-top: 20px;
    max-width: 600px;  /* ✅ limit chart width */
    margin-left: auto;
    margin-right: auto;
}

#leaveChart {
    max-width: 500px;  /* ✅ make chart smaller */
    max-height: 300px;
    margin: 0 auto;
}

        /* Dashboard Card for Chart */
        .dashboard-card {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            margin-top: 20px;
        }

        hr {
            border: 1px solid rgba(255,255,255,0.3);
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Admin Dashboard</h2>
    <div class="text-end mb-3">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
    
    <hr>

    <!-- Summary Cards -->
    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="summary-card pending-card">
                Pending<br><?php echo $p; ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card approved-card">
                Approved<br><?php echo $a; ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card rejected-card">
                Rejected<br><?php echo $r; ?>
            </div>
        </div>
    </div>

    <!-- Leave Requests Table -->
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Leave Requests</h2>
    <a href="export_excel.php" class="btn btn-success">Export to Excel</a>
</div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>User</th><th>Start</th><th>End</th><th>Reason</th><th>Status</th><th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($leaves)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['reason']); ?></td>
                        <td>
                            <span class="badge bg-<?php echo $row['status']=='Approved'?'success':($row['status']=='Rejected'?'danger':'warning'); ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($row['status'] == 'Pending') { ?>
                                <a href="approve_leave.php?id=<?php echo $row['id']; ?>&status=Approved" class="btn btn-success btn-sm">Approve</a>
                                <a href="approve_leave.php?id=<?php echo $row['id']; ?>&status=Rejected" class="btn btn-danger btn-sm">Reject</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <hr>

    
   <!-- Chart Section -->
<h3 class="text-center">Leave Status Summary</h3>
<div class="dashboard-card text-center" style="width:100%; max-width:600px; margin:auto;">
    <div style="position:relative; height:300px; width:100%;">
        <canvas id="leaveChart"></canvas>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('leaveChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Pending', 'Approved', 'Rejected'],
            datasets: [{
                data: [<?php echo $p; ?>, <?php echo $a; ?>, <?php echo $r; ?>],
                backgroundColor: ['#FFB347', '#4CAF50', '#E74C3C'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: '#fff',
                        font: {
                            size: 14,
                            weight: 'bold'
                        },
                        padding: 20
                    }
                },
                tooltip: {
                    enabled: true
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutBounce'
            }
        }
    });
});
</script>

</body>
</html>
