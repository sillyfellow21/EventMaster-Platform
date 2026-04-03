<?php
session_start();
include 'db_connect.php'; // Include your database connection file



// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the ticket type from the POST request
    $ticketType = $_POST['ticketType'];
    $price = $_POST['price']; // Get the price from the hidden input
    $eventID = $_POST['EventID'];
    $venuename = $_POST['venuename'];
    $orgemail = $_POST['OrgEmail'];
    

    // Check if the price is "N/A"
    if ($price == 'N/A') {
        echo "<script>alert('Error: Could not purchase.');</script>";
    } else {
    
    // Prepare SQL statement to insert data into the database
    $stmt = $conn->prepare("INSERT INTO ticket (EventID, TicketType, Price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $eventID, $ticketType, $price);
    $stmt->execute();

    // Set variables for the prepared statement
    

    //$tid = "SELECT TicketID FROM ticket";
    //$query = mysqli_query($conn, $tid);
    //$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
    //$ind = count($data);
    //$tid= $data[$ind-1];
    //$tid=$tid['TicketID'];
    $query = "SELECT TicketID FROM ticket ORDER BY Time DESC LIMIT 1";
    $result = $conn->query($query);

    // Check if any results were returned
    if ($result && $result->num_rows > 0) {
        // Fetch the row
        $row = $result->fetch_assoc();
        // Store the ticketID in a variable
        $tid = $row['TicketID'];
    }
    $session = "SELECT user_email FROM sessions";
    $query1 = mysqli_query($conn, $session);
    $data1 = mysqli_fetch_all($query1, MYSQLI_ASSOC);
    $org= $data1[0];
    $emailat=$org['user_email'];

    $stmt1 = $conn->prepare("INSERT INTO purchase (TicketID, EventID, EmailAtt) VALUES (?, ?, ?)");
    $stmt1->bind_param("sss", $tid, $eventID, $emailat);
    $stmt1->execute();
    $stmt2 = $conn->prepare("INSERT INTO attendees (EmailAtt, EventID, TicketID) VALUES (?, ?, ?)");
    $stmt2->bind_param("sss", $emailat, $eventID, $tid);

    // Execute the statement and check for success
    if ($stmt2->execute()) {
        echo "<script>alert('Ticket purchase confirmed!');</script>";
        header('location:Guest_dashboard.html');
        
    } else {
        echo "<script>alert('Error: Could not confirm purchase.');</script>";
    }

    // Close the statement
    $stmt->close();
}}

if (isset($_GET['venuename'])) {
    $venuename = $_GET['venuename'];
    $title = $_GET['title'];
    $eventID = $_GET['EventID'];
    $orgemail = $_GET['OrgEmail'];


} 
else {
    header("Guest_dashboard.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet">
    <title>Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #030518;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background-color: #6B7087;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .price-display {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
            color: #333;
        }
        .hover {
            color: #818090;
            background-color: #030518;
        }
    </style>
    <script>
        // Define ticket prices based on the venue
        const ticketPrices = {
            "International Convention City Bashundhara": {
                "Ticket Type": "N/A",
                "VIP": 10000,
                "Premium": 7000,
                "Regular": 5000
            },
            "City Hall Convention Center": {
                "Ticket Type": "N/A",
                "VIP": 7000,
                "Premium": 5000,
                "Regular": 3000
            },
            "Dhaka Convention Center": {
                "Ticket Type": "N/A",
                "VIP": 3000,
                "Premium": 2000,
                "Regular": 1000
            },
            "Bangladesh China Friendship Conference Center": {
                "Ticket Type": "N/A",
                "VIP": 5000,
                "Premium": 3000,
                "Regular": 2000
            },
            "Tokyo Square Convention Center": {
                "Ticket Type": "N/A",
                "VIP": 2000,
                "Premium": 1500,
                "Regular": 850
            }
        };

        function updateTicketPrices(venue) {
            const ticketTypeSelect = document.getElementById('ticketType');
            ticketTypeSelect.innerHTML = ''; // Clear existing options

            const prices = ticketPrices[venue];
            for (const type in prices) {
                const option = document.createElement('option');
                option.value = type;
                option.textContent = type; // Only display the ticket type
                ticketTypeSelect.appendChild(option);
            }
        }

        function displayPrice() {
            const venueName = "<?php echo htmlspecialchars($venuename); ?>"; // PHP variable in JS
            const ticketTypeSelect = document.getElementById('ticketType');
            const priceDisplay = document.getElementById('priceDisplay');
            const selectedType = ticketTypeSelect.value;

            if (selectedType) {
                const price = ticketPrices[venueName][selectedType];
                if (price=='N/A'){
                    priceDisplay.textContent = `Price: N/A`;
                    document.getElementById('hiddenPrice').value = 'N/A';
                }
                else {
                    priceDisplay.textContent = `Price: BDT ${price}/-`;
                    document.getElementById('hiddenPrice').value = price;
                }
            } else {
                priceDisplay.textContent = '';
            }
        }
        
        window.onload = function() {
            const venueName = "<?php echo htmlspecialchars($venuename); ?>"; // PHP variable in JS
            updateTicketPrices(venueName); // Update the dropdown with ticket types
            displayPrice(); // Display the initial price (if any)
        };
    </script>
</head>
<body>
    <div class="container">
        <h1><?php echo $title ?></h1>
        <h4>Event ID: <?php echo $eventID ?></h4>
        <h4>Venue: <?php echo $venuename ?></h4>

        <form class="" action="ticket.php" method="POST">
        <label for="ticketType">Choose a ticket type:</label>
        <select name="ticketType" id="ticketType" required onchange="displayPrice()">
            <!-- Options will be populated by JavaScript -->
        </select>
        
        <div id="priceDisplay" class="price-display">
            Price: BDT 0  <!-- Default price display -->
        </div>
        <br>
        <div class="">            
            <input type="hidden" name="price" id="hiddenPrice">
            <input type="hidden" name="EventID" value="<?php echo $eventID; ?>">
            <input type="hidden" name="venuename" value="<?php echo $venuename; ?>">
            <input type="hidden" name="OrgEmail" value="<?php echo $OrgEmail; ?>">
            <button class="title" type="submit" style="border:None; cursor: pointer;">Confirm Your Purchase</button>                
            
        </div>
        </form>
    
    </div>
</body>
</html>
