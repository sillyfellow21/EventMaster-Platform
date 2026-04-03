<?php
include 'db_connect.php'; 

$session_query = "SELECT user_email FROM sessions ORDER BY created_at DESC LIMIT 1"; 
$session_result = $conn->query($session_query);

if ($session_result->num_rows > 0) {
    $session_data = $session_result->fetch_assoc();
    $userEmail = $session_data['user_email'];

    // Handle review removal before fetching purchases
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['removeReview'])) {
        $reviewID = $_POST['reviewID'];

        $delete_review_query = "DELETE FROM reviews WHERE ReviewID = '$reviewID'";
        if ($conn->query($delete_review_query) === TRUE) {
            echo "Review removed successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $purchase_query = "SELECT * FROM purchase WHERE EmailAtt = '$userEmail'";
    $purchase_result = $conn->query($purchase_query);

    if ($purchase_result->num_rows > 0) {
        echo "<h1>My Purchases</h1>";
        echo "<table border='1'>
                <tr>
                    <th>Ticket ID</th>
                    <th>Event ID</th>
                    <th>Email</th>
                    <th>Purchase Time</th>
                </tr>";

        while ($row = $purchase_result->fetch_assoc()) {
            $ticketID = htmlspecialchars($row['TicketID']); 
            $eventID = htmlspecialchars($row['EventID']);
            $emailAtt = htmlspecialchars($row['EmailAtt']);
            $purchaseTime = htmlspecialchars($row['purchase_time']);

            echo "<tr>
                    <td>$ticketID</td>
                    <td>$eventID</td>
                    <td>$emailAtt</td>
                    <td>$purchaseTime</td>
                  </tr>";

            // Fetch existing review
            $review_query = "SELECT ReviewID, Rating FROM reviews WHERE EventID = '$eventID' AND UserEmail = '$userEmail'";
            $review_result = $conn->query($review_query);

            if ($review_result->num_rows > 0) {
                $review_row = $review_result->fetch_assoc();
                $reviewID = htmlspecialchars($review_row['ReviewID']);
                $rating = htmlspecialchars($review_row['Rating']);

                // Display stars for the review
                echo "<tr><td colspan='4'><strong>Your Review:</strong></td></tr>";
                echo "<tr><td colspan='4'>";
                for ($i = 1; $i <= 5; $i++) {
                    $starClass = $i <= $rating ? 'ri-star-fill' : 'ri-star-line';
                    echo "<i class='$starClass' style='color: gold;'></i> ";
                }
                echo "</td></tr>";

                // Remove button
                echo "<tr><td colspan='4'>
                        <form action='' method='post'>
                            <input type='hidden' name='reviewID' value='$reviewID'>
                            <button type='submit' name='removeReview'>Remove Review</button>
                        </form>
                      </td></tr>";
            } else {
                // Display review form if no review exists
                echo "<tr>
                        <td colspan='4'>
                            <form action='' method='post'>
                                <input type='hidden' name='eventID' value='$eventID'>
                                <label for='rating'>Rate this event (1-5):</label>
                                <input type='number' id='rating' name='rating' min='1' max='5' required>
                                <button type='submit'>Submit Review</button>
                            </form>
                        </td>
                      </tr>";
            }
        }
        echo "</table>";
    } else {
        echo "No purchases found for you.";
    }

    // Handle review submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rating'])) {
        $eventID = $_POST['eventID'];
        $rating = $_POST['rating'];

        $insert_review_query = "INSERT INTO reviews (EventID, UserEmail, Rating) VALUES ('$eventID', '$userEmail', '$rating')";
        if ($conn->query($insert_review_query) === TRUE) {
            echo "Review submitted successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
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
    <link rel="stylesheet" href="./styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <title>My Purchases</title>
</head>
<body style="background-color: #0099cc;">
    <a class="signup-login" href="./EventMaster.html">Event Master</a>
</body>
</html>
