<?php
session_start();
include "../includes/db.inc.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    
    

        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];
            header('Location: dashboard.php');
        } else {
            $error = "Invalid credentials!";
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="../css/login.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2>Login</h2>
            <img src="../img/police.jpeg" alt="Logo"> <!-- Replace with your logo -->
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            <form action="login.php" method="post">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required><br>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required><br>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
