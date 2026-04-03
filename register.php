<?php
include 'db_connect.php';
session_start();
if (isset($_POST['Submit'])){

    $email = $_POST['email'];
    $username = $_POST['username'];
    $phone = $_POST['phonenumber'];
    $password = $_POST['password'];
    $retype_password = $_POST['retype_password'];
    $md5_pass=md5($password);

    if ($password===$retype_password){
        $sql = "INSERT INTO participants (UserEmail, NAME, PhoneNumber, PASSWORD) VALUES('$email', '$username', '$phone','$md5_pass')";
        if ($conn->query($sql)==TRUE){
            header('location:Log_in.php');
        }
    }
    else{echo "Password dose not match.";}
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">

    <title>Sign Up</title>
    <link rel = "stylesheet" href = "./styles.css">
</head>
<body style="background-color:  #030518;">   
    <nav class = "upper-right">
    <a class = "naver" href="index.html">Home</a> 
    <a class = "naver" href="./About.html">About Us</a>
    <a class = "naver" href="./Log_in.php"> Log in</a>
    </nav>
    <h1 class="title"> Sign UP</h1>
    <div class = 'login-box'>
        <form action ="register.php" method="post">
            <h4 class="box-title">Email:</h4>
            <br style="display: None;">
            <input type="email" name = "email" id = "email" placeholder = "Email" required maxlength="30" style="margin: 0px; margin-bottom: 15px;"> 
            <br style="display: None;">
            <h4 class="box-title">Full Name:</h4>
            <br style="display: None;">
            <input type="text" id = "username" name = "username" placeholder = "Username" required maxlength="30" style="margin: 0px; margin-bottom: 15px;"> 
            <br style="display: None;">
            <h4 class="box-title">Phone Number:</h4>
            <br style="display: None;">
            <input type="text" id = "username" name = "phonenumber" placeholder = "Phone" maxlength="11" style="margin: 0px; margin-bottom: 15px;"> 
            <br style="display: None;">
            <h4 class="box-title">Password:</h4>
            <br style="display: None;">
            <input type="password" name = "password" id = "password" placeholder = "Password" required maxlength="16" minlength="8" style="margin: 0px; margin-bottom: 15px;">
            <br style="display: None;">
            <h4 class="box-title">Retype Password:</h4>
            <br style="display: None;">
            <input type="password" name = "retype_password" id = "password" placeholder = "Password" required maxlength="16" minlength="8" style="margin: 0px;">
            <br>
            <button type="submit" name="Submit" class="signup-login" style="margin: 16px;">Sign Up</button>
        </form>
    </div>
    <!--<h5 class="account"> 
        <?php //if (isset($_POST['Submit'])) {echo $empmsg_email;} ?>
    </h5> -->
    <div class="account">
    <h4>Already Have an Account? <a href="./Log_in.php">Login Here</a></h4>
    </div>
    
</body>
</html>