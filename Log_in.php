<?php
session_start();
include 'db_connect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $password = md5($pass); // Hash the password using md5

    // Fetch user from the database
    $query = "SELECT UserEmail, password FROM participants WHERE UserEmail = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if ($password == $user['password']) {
            // Create a unique session ID
            $session_id = session_id();
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour')); // Session expiration time

            // Insert session into the sessions table
            $insert_query = "INSERT INTO sessions (session_id, user_email, expires_at) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("sss", $session_id, $user['UserEmail'], $expires_at);
            $insert_stmt->execute();

            // Store user email in session variable
            $_SESSION['user_email'] = $user['UserEmail'];

            // Redirect to a protected page
            header("Location: EventMaster.html");
            exit();
        } else {
            echo "Invalid credentials.";
        }
    } else {
        echo "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
</head>
<body style="background-color: #030518;">   
    <nav class="upper-right">
        <a class="naver" href="index.html">Home</a> 
        <a class="naver" href="./About.html">About Us</a>
        <a class="naver" href="./register.php">Sign Up</a>
    </nav>
    <h1 class="title">Log In</h1>
    <div class="login-box">
        <form action="Log_in.php" method="POST">
            <input type="email" name="email" id="email" placeholder="Email" required> <br>
            <input type="password" name="password" id="password" placeholder="Password" required><br>
            <button type="submit" name="Submit" class="signup-login">Log In</button>
        </form>
    </div>
</body>
</html>
