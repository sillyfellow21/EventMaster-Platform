<?php
include 'db_connect.php'; // Include your database connection

// Fetch the organizer's email from the sessions table
$session_query = "SELECT user_email FROM sessions ORDER BY created_at DESC LIMIT 1"; // Assuming the latest session is the current user
$session_result = $conn->query($session_query);

if ($session_result->num_rows > 0) {
    $session_data = $session_result->fetch_assoc();
    $organizerEmail = $session_data['user_email'];

    // Fetch events created by the organizer
    $sql = "SELECT * FROM events WHERE OrganizerEmail = '$organizerEmail'";
    $result = $conn->query($sql);

    // Check if there are any events created by the organizer
    if ($result->num_rows > 0) {
        echo "<h1>My Events</h1>";
        echo "<table border='1'>
                <tr>
                    <th>Event ID</th>
                    <th>Venue ID</th>
                    <th>Organizer Email</th>
                    <th>Date</th>
                </tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            $eventID = htmlspecialchars($row['EventID']); // Escape output for safety
            $venueID = htmlspecialchars($row['VenueID']);
            $date = htmlspecialchars($row['Date']);

            echo "<tr>
                    <td>$eventID</td>
                    <td>$venueID</td>
                    <td>$organizerEmail</td>
                    <td>$date</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No events created by you.";
    }
} else {
    echo "No active session found.";
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "./styles.css">
    <title>My Events</title>
</head>
<body style="background-color: #0099cc;">
    
    <a class="signup-login" href="./EventMaster.html">Event Master</a>

</body>
</html>
