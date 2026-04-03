<?php
session_start();
include 'db_connect.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    $pass = md5($pass);

    if ($email == 'admin@gmail.com' && $pass == 'admin') {
        $_SESSION['email'] = $email;
        $_SESSION['username'] = 'Admin';
        header('location:dashboard.php');
        exit();
    } else {
        $select = mysqli_query($conn, "SELECT * FROM `participants` WHERE UserEmail = '$email' AND PASSWORD = '$pass' AND NAME = '$username'") or die('Query failed');

        if (mysqli_num_rows($select) > 0) {
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $username;
            header('location:EventMaster.html');
            exit();
        } else {
            echo "<script>alert('Incorrect username, email, or password!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel = "stylesheet" href = "./styles.css">
</head>
<body style="background-color:  #030518;">   
    <nav class = "upper-right">
        <a class = "naver" href="index.html">Home</a> 
        <a class = "naver" href="./About.html">About Us</a>
        <a class = "naver" href="./register.php"> Sign Up</a>
    </nav>
    <h1 class='title'>Log In</h1>
    <div class = login-box>
        <form action = "Log_in.php" method="POST">
            <input type="text" id = "username" name = "username" placeholder = "Username" required> <br>
            <input type="email" name = "email" id = "email" placeholder = "Email" required> <br>
            <input type="password" name = "password" id = "password" placeholder = "Password" required><br>
            <button type="submit" name="Submit" class="signup-login">Log In</button>
        </form>

    </div>

</div>

    
</body>
</html>