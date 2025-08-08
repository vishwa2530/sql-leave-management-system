<?php
include 'db.php';
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $role = 'student';

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email already exists!";
    } else {
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Registration failed!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - Leave Management</title>
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

        /* Background with overlay */
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('https://source.unsplash.com/1920x1080/?education,classroom') no-repeat center center/cover;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        /* Glass Form */
        .glass-form {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            color: #fff;
            width: 380px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .glass-form h2 {
            margin-bottom: 20px;
            font-weight: 600;
        }

        /* Inputs */
        .glass-form input {
            width: 100%;
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 8px;
            border: none;
            font-size: 14px;
            outline: none;
        }

        /* Button */
        .glass-form button {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            background: #007bff;
            color: white;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s ease;
            cursor: pointer;
        }

        .glass-form button:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

        /* Link */
        .glass-form a {
            display: inline-block;
            margin-top: 12px;
            color: #fff;
            text-decoration: none;
            transition: 0.3s;
        }

        .glass-form a:hover {
            text-decoration: underline;
        }

        /* Error */
        .error {
            color: #ff4d4d;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="glass-form">
    <h2>Student Registration</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="register">Register</button>
    </form>
    <a href="index.php">Already registered? Login</a>
</div>
</body>
</html>

