<?php
session_start();
include 'db_connect.php'; // Include your database connection file

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get current session ID
    $session_id = session_id();

    // Delete session from the database
    $delete_query = "DELETE FROM sessions WHERE session_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("s", $session_id);
    $stmt->execute();

    // Destroy PHP session
    session_destroy();

    // Redirect to login page or homepage
    header("Location: log_in.php");
    exit();
} else {
    // If not a POST request, redirect to the login page or show an error
    header("Location: log_in.php");
    exit();
}
?>