<?php
session_start();
include 'db_connect.php'; 
$session = "SELECT user_email FROM sessions";
$query1 = mysqli_query($conn, $session);
$data1 = mysqli_fetch_all($query1, MYSQLI_ASSOC);
$org= $data1[0];
$org=$org['user_email'];
echo $org
?>

<?php
session_start();
include 'db_connect.php'; 

// Check if the eventID is set in the URL
if (isset($_GET['eventID'])) {
    // Retrieve the eventID from the URL
    $eventID = $_GET['eventID'];

    // Prepare and execute a query to fetch event details
    $sql = "SELECT * FROM events WHERE EventId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $eventID); // Bind the eventID as an string
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    // Check if an event was found
    if ($result->num_rows > 0) {
        // Fetch the event data
        while ($row = $result->fetch_assoc()) {
            echo "<h1>" . htmlspecialchars($row['Title']) . "</h1>";
            echo "<p>Venue: " . htmlspecialchars($row['VenueID']) . "</p>";
            echo "<p>Date: " . htmlspecialchars($row['Date']) . "</p>";
            echo "<p>Organizer: " . htmlspecialchars($row['OrganizerEmail']) . "</p>";
            // Add more fields as necessary
        }
    } else {
        echo "No event found.";
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    echo "No event ID provided.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>