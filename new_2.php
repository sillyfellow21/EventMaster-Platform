<?php
include 'db_connect.php'; // Include your database connection

// Fetch all events from the database
$sql = "SELECT * FROM events";
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    echo "<h1>Upcoming Events</h1>";
    echo "<table border='1'>
            <tr>
                <th>Event ID</th>
                <th>Event Title</th>
                <th>Venue Code</th>
                <th>Venue Name</th>
                <th>location</th>
                <th>Organizer Email</th>
                <th>Date</th>
            </tr>";
    
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $eventID = htmlspecialchars($row['EventID']); // Escape output for safety
        $venueID = htmlspecialchars($row['VenueID']);
        $sql1 = "SELECT VenueName, Location FROM venue Where ID =?";
        $stmt = $conn->prepare($sql1);
        $stmt->bind_param("s", $venueID); // Bind the eventID as an string
        $stmt->execute();
        $result1 = $stmt->get_result();
        $row1=$result1->fetch_assoc();
        $venuename = htmlspecialchars($row1['VenueName']);
        $location = htmlspecialchars($row1['Location']);
        $title = htmlspecialchars($row['Title']);
        $organizerEmail = htmlspecialchars($row['OrganizerEmail']);
        $date = htmlspecialchars($row['Date']);

        echo "<tr onclick=\"location.href='event_details.php?eventID=$eventID';\" style='cursor:pointer;'>
                <td>$eventID</td>                
                <td>$title</td>
                <td>$venueID</td>
                <td>$venuename</td>
                <td>$location</td>
                <td>$organizerEmail</td>
                <td>$date</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No events found.";
}

// Close the database connection
$conn->close();
?>
