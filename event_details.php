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
    $stmt->bind_param("s", $eventID); // Bind the eventID as a string
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();

    // Check if an event was found
    if ($result->num_rows > 0) {
        // Fetch the event data
        while ($row = $result->fetch_assoc()) {
            // Store the data to use it in the HTML structure below
            $eventTitle = htmlspecialchars($row['Title']);
            $venueID = htmlspecialchars($row['VenueID']);
            $sql1 = "SELECT VenueName, Location FROM venue Where ID =?";
            $stmt = $conn->prepare($sql1);
            $stmt->bind_param("s", $venueID); // Bind the eventID as an string
            $stmt->execute();
            $result1 = $stmt->get_result();
            $row1=$result1->fetch_assoc();
            $venuename = htmlspecialchars($row1['VenueName']);
            $location = htmlspecialchars($row1['Location']);
            $eventDate = htmlspecialchars($row['Date']);
            $organizerEmail = htmlspecialchars($row['OrganizerEmail']);
        }
    } else {
        $errorMessage = "No event found.";
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    $errorMessage = "No event ID provided.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #6B7087;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        .event-details {
            margin: 20px 0;
        }
        .event-details p {
            font-size: 16px;
            color: #555;
        }
        .event-details span {
            font-weight: bold;
            color: #000;
        }
        .error-message {
            color: red;
        }
        .hover {
            color: #818090;
            background-color: #030518;
        }
    </style>

    
</head>
<body style="background-color:#030518">
    <nav class="upper-right" style="display:flex; justify-content: flex-end;">
        <a class="naver" href="./EventMaster.html">Event Master</a>
        <form class="no-style" action="log_out.php" method="POST">
            <button class="naver" type="submit" style="background: none; cursor: pointer; border: none;">Log out</button>
        </form>
    </nav>
    
    <h1 class="title">Confirm Your Ticket!</h1>
    <div class="container">
        <?php if (isset($eventTitle)): ?>
            <h1><?php echo $eventTitle; ?></h1>
            <div class="event-details">
                <p><span>Venue Code:</span> <span style="color: #333333"><?php echo $venueID; ?></span></p>
                <p><span>Venue Name:</span> <span style="color: #333333"><?php echo $venuename; ?></span></p>
                <p><span>Location:</span> <span style="color: #333333"><?php echo $location; ?></span></p>
                <p><span>Date:</span> <span style="color: #333333"><?php echo $eventDate; ?></span></p>
                <p><span>Organizer:</span> <span style="color: #333333"><?php echo $organizerEmail; ?></span></p>

                
            </div>
            <div>
                <form class="hover signup-login" action="ticket.php" method="GET">
                    <input type="hidden" name="title" value="<?php echo htmlspecialchars($eventTitle); ?>">
                    <input type="hidden" name="venuename" value="<?php echo htmlspecialchars($venuename); ?>">
                    <input type="hidden" name="EventID" value="<?php echo $eventID; ?>">
                    <input type="hidden" name="OrgEmail" value="<?php echo htmlspecialchars($organizerEmail); ?>">
                    <button class="title" type="submit" style="background:None; border:None; cursor: pointer;">BOOK A SEAT</button>
                </form>
            </div>
        <?php else: ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>

