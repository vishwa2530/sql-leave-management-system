<?php
session_start();
include 'db.php';
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' AND role='$role'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['user'] = mysqli_fetch_assoc($result);
        if ($role == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: student_dashboard.php");
        }
    } else {
        $error = "Invalid Credentials!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Leave Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Reset & Font */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Background */
        body {
            height: 100vh;
            background: linear-gradient(135deg, #cb9611ff, #2575fc);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Container */
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        /* Glass effect card */
        .glass-form {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 30px;
            color: #fff;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .glass-form h2 {
            margin-bottom: 20px;
            font-weight: 600;
        }

        /* Input fields */
        .glass-form input, .glass-form select {
            width: 100%;
            margin-bottom: 15px;
            padding: 12px;
            border: none;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
        }

        /* Button */
        .glass-form button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #2575fc;
            color: white;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .glass-form button:hover {
            background: #6a11cb;
            transform: scale(1.05);
        }

        /* Register link */
        .glass-form a {
            display: inline-block;
            margin-top: 10px;
            color: #fff;
            text-decoration: none;
            transition: 0.3s;
        }

        .glass-form a:hover {
            text-decoration: underline;
        }

        /* Error message */
        .error {
            color: #ff4d4d;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="glass-form">
        <h2>Login</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role">
                <option value="student">Student</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" name="login">Login</button>
        </form>
        <a href="register.php">Register Here</a>
    </div>
</div>
</body>
</html>
