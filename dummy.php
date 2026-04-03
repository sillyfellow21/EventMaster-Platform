<?php
session_start();
include 'db_connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email']; // Assuming you are using email for login
    $password = $_POST['password'];

    // Fetch user from the database
    $query = "SELECT email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password (assuming you are using password_hash for hashing)
        if (password_verify($password, $user['password'])) {
            // Create a unique session ID
            $session_id = session_id();
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour')); // Session expiration time

            // Insert session into the sessions table
            $insert_query = "INSERT INTO sessions (session_id, user_email, expires_at) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("sss", $session_id, $user['email'], $expires_at);
            $insert_stmt->execute();

            // Store user email in session variable
            $_SESSION['user_email'] = $user['email'];

            // Redirect to a protected page
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid credentials.";
        }
    } else {
        echo "User not found.";
    }
}
?>