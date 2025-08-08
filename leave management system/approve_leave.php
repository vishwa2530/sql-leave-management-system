<?php
include 'db.php';
$id = intval($_GET['id']);
$status = $_GET['status'];

mysqli_query($conn, "UPDATE leaves SET status='$status' WHERE id=$id LIMIT 1");
header("Location: admin_dashboard.php");
exit();
?>
