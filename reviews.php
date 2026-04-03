<?php
include 'db_connect.php'; 

$average_review_query = "
    SELECT 
        events.EventID, 
        events.Title, 
        IFNULL(AVG(reviews.Rating), 0) AS AverageRating, 
        COUNT(reviews.ReviewID) AS ReviewCount
    FROM events
    LEFT JOIN reviews ON events.EventID = reviews.EventID
    GROUP BY events.EventID, events.Title
    ORDER BY events.Title ASC
";

$average_review_result = $conn->query($average_review_query);

if ($average_review_result->num_rows > 0) {
    echo "<h1>Event Reviews</h1>";
    echo "<table border='1'>
            <tr>
                <th>Event ID</th>
                <th>Title</th>
                <th>Average Rating</th>
                <th>Number of Reviews</th>
            </tr>";

    while ($row = $average_review_result->fetch_assoc()) {
        $eventID = htmlspecialchars($row['EventID']);
        $title = htmlspecialchars($row['Title']);
        $averageRating = number_format($row['AverageRating'], 2);
        $reviewCount = htmlspecialchars($row['ReviewCount']);

        echo "<tr>
                <td>$eventID</td>
                <td>$title</td>
                <td>$averageRating</td>
                <td>$reviewCount</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No events found.</p>";
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <title>Event Reviews</title>
</head>
<body style="background-color: #0099cc;">
    <a class="signup-login" href="./EventMaster.html">Event Master</a>
</body>
</html>
