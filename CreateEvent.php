<?php
include 'db_connect.php';
session_start();

function validateDateTime($dateTime) {
    // Define the regex pattern for yyyy-mm-dd hh:mm:ss
    $pattern = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';

    // Check if the format matches
    if (!preg_match($pattern, $dateTime)) {
        return false; // Invalid format
    }

    // Create a DateTime object to validate the date and time
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
    
    // Check if the date is valid
    return $date && $date->format('Y-m-d H:i:s') === $dateTime;
}

if (isset($_POST['Submit'])){

    $category = $_POST['category'];
    $datetime = $_POST['time'];
    $title = $_POST['title'];
    $venuename = $_POST['VenueName'];
    $location = $_POST['Location'];
    $venuespace = $_POST['VenueSpace'];
    $capacity = $_POST['Capacity'];

    if (!validateDateTime($datetime)) {
        echo '<script>alert("Invalid datetime format!");</script>';
    } 
    
    else {
        $sql = "INSERT INTO venue (Capacity, Location, VenueName, VenueSpace) VALUES('$capacity', '$location', '$venuename', '$venuespace')";
        if ($conn->query($sql)==True){
            $venueid = "SELECT id FROM venue";
            $query = mysqli_query($conn, $venueid);
            $data = mysqli_fetch_all($query, MYSQLI_ASSOC);
            $ind = count($data);
            $vid= $data[$ind-1];
            $v_id=$vid['id'];
            $session = "SELECT user_email FROM sessions";
            $query1 = mysqli_query($conn, $session);
            $data1 = mysqli_fetch_all($query1, MYSQLI_ASSOC);
            $org= $data1[0];
            $org=$org['user_email'];
            
        }
        $sql1 = "INSERT INTO events (Date, VenueID, OrganizerEmail, Title) VALUES('$datetime', '$v_id', '$org', '$title')";
        if ($conn->query($sql1)==TRUE){
            header('location:showevent.php');
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel = "stylesheet" href = "./styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        form:not(.no-style) {
            background-color: #6b7087;
            width: 460px;

            margin: 50px auto;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-bottom: 0px;
            font-weight:100;
        }

        select, input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ffffff;
            border-radius: 20px;
        }

        input[type="submit"] {
            background-color: #ffffff;
            color: rgb(3, 3, 3);
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            
        }

        input[type="submit"]:hover {
            background-color: #1e81ba;
        }
    </style>
</head>
<body>
    <nav class = "upper-right" style="display:flex; justify-content: flex-end;">
    <a class = "naver" href="./EventMaster.html">Event Master</a>
    <form class="no-style" action="log_out.php" method="POST">
        <button class="naver" type="submit" style="background: none; cursor: pointer; border: none;">Log out</button> <!--style="margin: 0; height:20px; padding-left: 15px; padding-right: 15px; font-size: 10px; display: inline-block;"-->
    </form>
    </nav>
    
    <h1 style = "text-align: center;"> Choose Venue and Space to create Event</h1>
 <!-- HTML Form -->
<!-- HTML Form -->
<form action ="CreateEvent.php" method="post">
    <!-- Venue Name Dropdown -->
    <label for="Category">Category:</label>
    <select id = "category" name="Category" required>
        <option value="" disabled selected>Select a category</option>
        <option value="Concert">Concert</option>
        <option value="Office Program">Office Program</option>
        <option value="Meet & Greet">Meet & Greet</option>
        <option value="Other">Other</option>
    </select><br><br>
    <label for="title">Event Title</label>
    <input type="text" name="title" placeholder="Event title" maxlength="255" required><br><br>
    <label for="DateTime">Date & Time:</label>
    <input type="text" name="time" placeholder="YYYY-MM-DD HH:MM:SS" maxlength="20" required pattern="\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}"><br><br>

    <label for="VenueName">Venue Name:</label>
    <select id="VenueName" name="VenueName" required onchange="updateDetails()">
        <option value="" disabled selected>Select Venue</option>
        <option value="International Convention City Bashundhara">International Convention City Bashundhara</option>
        <option value="City Hall Convention Center">City Hall Convention Center</option>
        <option value="Dhaka Convention Center">Dhaka Convention Center</option>
        <option value="Bangladesh China Friendship Conference Center">Bangladesh China Friendship Conference Center</option>
        <option value="Tokyo Square Convention Center">Tokyo Square Convention Center</option>
    </select>
    <br><br>

    <!-- Location Input Field (Read-only) -->
    <label for="Location">Location:</label>
    <input type="text" id="Location" name="Location" placeholder="Auto-filled Location" readonly required>
    <br><br>

    <!-- Venue Space Dropdown -->
    <label for="VenueSpace">Venue Space:</label>
    <select id="VenueSpace" name="VenueSpace" required onchange="updateDetails()">
        <option value="" disabled selected>Select Venue Space</option>
        <option value="Auditorium">Auditorium</option>
        <option value="Theatre Hall">Theatre Hall</option>
        <option value="Concert Hall">Concert Hall</option>
        <option value="Art Galleries">Art Galleries</option>
        <option value="Community Centre">Community Centre</option>
    </select>
    <br><br>

    <!-- Capacity Input Field (Read-only) -->
    <label for="Capacity">Capacity:</label>
    <input type="number" id="Capacity" name="Capacity" placeholder="Auto-filled Capacity" readonly required>
    <br><br>

    <!-- Submit Button -->
    <button type="submit" name="Submit" class="signup-login" style="margin: 2px; padding: 10px 25px">Submit</button>
</form>

<script>
// JavaScript data for Venue Name and Venue Space
// JavaScript data for Venue Name, Venue Space, and their respective capacities
const venueData = {
    'International Convention City Bashundhara': 'Purbachal',
    'City Hall Convention Center': 'Chittagong',
    'Dhaka Convention Center': 'Azimpur',
    'Bangladesh China Friendship Conference Center': 'Agargaon',
    'Tokyo Square Convention Center': 'Shyamoli'
};

const spaceCapacities = {
    'International Convention City Bashundhara': {
        'Auditorium': 20000,
        'Theatre Hall': 1500,
        'Concert Hall': 1000,
        'Art Galleries': 3000,
        'Community Centre': 700
    },
    'City Hall Convention Center': {
        'Auditorium': 18000,
        'Theatre Hall': 1200,
        'Concert Hall': 800,
        'Art Galleries': 2500,
        'Community Centre': 600
    },
    'Dhaka Convention Center': {
        'Auditorium': 15000,
        'Theatre Hall': 1000,
        'Concert Hall': 500,
        'Art Galleries': 2000,
        'Community Centre': 500
    },
    'Bangladesh China Friendship Conference Center': {
        'Auditorium': 12000,
        'Theatre Hall': 900,
        'Concert Hall': 400,
        'Art Galleries': 1500,
        'Community Centre': 300
    },
    'Tokyo Square Convention Center': {
        'Auditorium': 10000,
        'Theatre Hall': 800,
        'Concert Hall': 300,
        'Art Galleries': 1200,
        'Community Centre': 250
    }
};

// Function to update Location and Capacity based on selections
function updateDetails() {
    const venueName = document.getElementById('VenueName').value;
    const venueSpace = document.getElementById('VenueSpace').value;
    
    // Update Location based on Venue Name
    if (venueName in venueData) {
        document.getElementById('Location').value = venueData[venueName];
        
        // Update Capacity based on Venue Space and Venue Name
        if (venueSpace in spaceCapacities[venueName]) {
            document.getElementById('Capacity').value = spaceCapacities[venueName][venueSpace];
        } else {
            document.getElementById('Capacity').value = "";
        }
    } else {
        document.getElementById('Location').value = "";
        document.getElementById('Capacity').value = "";
    }
}
</script>


</body>
</html>

