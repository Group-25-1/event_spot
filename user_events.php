<?php
            @include 'config.php';

      session_start();
if (isset($_GET['name'])) {
    $name = $_GET['name'];
    // Store the name value in a session variable
    $_SESSION['name'] = $name;
} else if (isset($_SESSION['name'])) {
    // Retrieve the name value from the session variable
    $name = $_SESSION['name'];
} else {
    echo 'No name found';
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Events List</title>
  <style>
    * {
        font-family: "Poppins", sans-serif,"Brush Script MT";
        margin: 0;
        padding: 0;
        outline: none;
        border: none;
        text-decoration: none;
      }
    body {
      font-family: sans-serif;
    }

    .container {
      width: 80%;
      margin: 0 auto;
      padding: 20px;
    }
.nav {
        min-height: 7vh;
        background: #7c4bf8;
        padding: 5px;
        padding-left: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }
      .nav .logo{
        font-size: 2rem;
        text-transform: uppercase;
        font-weight: 600;
        color: #eee;
        font-family: "Stardos Stencil";
      }
      .nav .right-btn button,
      .nav .right-btn a {
        font-size: 1.5rem;
        font-family: inherit;
        background: #eee;
        padding: 5px;
        margin: 0 10px;
        border: 1px solid #000;
        border-radius: 5px;
      }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .header h1 {
      font-size: 24px;
      font-weight: bold;
    }

    .events {
      list-style-type: none;
      margin: 0;
      padding: 0;
    }

    .event {
      border: 1px solid #ccc;
      margin-bottom: 20px;
      padding: 20px;
    }

    .event h2 {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .event p {
      margin-bottom: 0;
    }

    .event a {
      display: block;
      text-align: center;
      padding: 10px;
      background-color: #007bff;
      color: white;
      text-decoration: none;
      margin-bottom: 5px;
    }

    .event a:hover {
      background-color: #0056b3;
      margin-bottom: 5px;
    }

form {
    margin-top: 20px;
  }

  form label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
  }

  form input[type="text"],
  form input[type="time"],
  form input[type="date"],
  form textarea {
    width: 100%;
    padding: 5px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }

  form input[type="submit"] {
    display: block;
    width: 100px;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  form input[type="submit"]:hover {
    background-color: #0056b3;
  }
  </style>
</head>
<body>
  <div class="container">
        <div class="nav">
      <div class="logo">Event Spot</div>
      <div class="right-btn">
        
        <?php

      echo '<span>Welcome, ' . $name . '!</span>';
    
    ?>
    <a href="event_form.php?name=<?php echo urlencode($name); ?>">add event</a>
        <a href="logout.php">Log out</a>
      </div>
    </div>




    <div class="header">
      <h1>Events you created</h1>
    </div>

    <ul class="events">
      <?php



            
    // Function to update event details in a specified table
function updateEvent($conn, $tableName, $eventName, $ticketPrice, $date, $time, $location, $eventCategory, $eventDescription, $eventImage) {
    $sql = "UPDATE " . $tableName . " SET ticketPrices = ?, date = ?, time = ?, eventImage = ?, location = ?, eventCategory = ?, eventDescription = ? WHERE eventName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssss', $ticketPrice, $date, $time, $eventImage, $location, $eventCategory, $eventDescription, $eventName);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['event_name']) && isset($_GET['table_name'])) {
    $eventName = $_GET['event_name'];
    $tableName = $_GET['table_name']; // Retrieve the table name from query parameters

    // Fetch event details from the specified table
    $sql = "SELECT * FROM " . $tableName . " WHERE eventName = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $eventName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ticketPrice = $row["ticketPrices"];
        $date = $row["date"];
        $time = $row["time"];
        $eventImage = $row["eventImage"];
        $location = $row["location"];
        $eventCategory = $row["eventCategory"];
        $eventDescription = $row["eventDescription"];

        // Display the update form with pre-filled values
        echo '<form method="POST" action="' . $_SERVER['PHP_SELF'] . '?action=update&event_name=' . $eventName . '&table_name=' . $tableName . '" enctype="multipart/form-data">';
        echo '<input type="hidden" name="action" value="update">';
        echo '<input type="hidden" name="event_name" value="' . $eventName . '">';
        echo '<input type="hidden" name="table_name" value="' . $tableName . '">'; // Add the table name as a hidden field
        echo '<label for="ticket_price">Ticket Price:</label>';
        echo '<input type="text" name="ticket_price" id="ticket_price" value="' . $ticketPrice . '" required><br>';
        echo '<label for="date">Date:</label>';
        echo '<input type="date" name="date" id="date" value="' . $date . '" required><br>';
        echo '<label for="time">Time:</label>';
        echo '<input type="time" name="time" id="time" value="' . $time . '" required><br>';
        echo '<label for="event_image">Event Image:</label>';
        echo '<input type="file" id="event_image" name="event_image" required><br>'; // Added file input field
        echo '<label for="location">Location:</label>';
        echo '<input type="text" name="location" id="location" value="' . $location . '" required><br>';
        echo '<label for="event_category">Event Category:</label>';
        echo '<input type="text" name="event_category" id="event_category" value="' . $eventCategory . '" required><br>';
        echo '<label for="event_description">Event Description:</label>';
        echo '<textarea name="event_description" id="event_description" required>' . $eventDescription . '</textarea><br>';
        echo '<input type="submit" value="Update">';
        echo '</form>';
    } else {
        echo "Event not found.";
    }
}

              if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $eventName = $_POST['event_name'];
    $ticketPrice = $_POST['ticket_price'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $eventCategory = $_POST['event_category'];
    $eventDescription = $_POST['event_description'];

    // Handle image upload
    $eventImage = $_FILES['event_image']['tmp_name'];
    $eventImageContents = file_get_contents($eventImage);

    // Retrieve the table name from the form submission
    $tableName = $_POST['table_name'];

    // Update event details in the specified table
    if (updateEvent($conn, $tableName, $eventName, $ticketPrice, $date, $time, $location, $eventCategory, $eventDescription, $eventImageContents)) {
        echo "Event updated successfully.";
    } else {
        echo "Error updating event.";
    }
}

      // Fetch events from event_form table
$sql = "SELECT *, 'event_form' as table_name FROM event_form WHERE organizer_name = '$name' 
        UNION 
        SELECT *, 'new_event' as table_name FROM new_event WHERE organizer_name = '$name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $eventName = $row["eventName"];
        $ticketPrice = $row["ticketPrices"];
        $date = $row["date"];
        $time = $row["time"];
        $eventImage = $row["eventImage"];
        $location = $row["location"];
        $eventCategory = $row["eventCategory"];
        $eventDescription = $row["eventDescription"];
        $tableName = $row["table_name"];

        echo '<li class="event">';
        echo '<h2>' . $eventName . '</h2>';
        echo '<p><strong>Ticket Price:</strong> ' . $ticketPrice . '</p>';
        echo '<p><strong>Date:</strong> ' . $date . '</p>';
        echo '<p><strong>Time:</strong> ' . $time . '</p>';
        echo '<img src="data:image/jpeg;base64,' . base64_encode($eventImage) . '" alt="Event Image" height="150px" width="150px">';
        echo '<p><strong>Location:</strong> ' . $location . '</p>';
        echo '<p><strong>Category:</strong> ' . $eventCategory . '</p>';
        echo '<p><strong>Description:</strong> ' . $eventDescription . '</p>';
        echo '<a href="?action=edit&event_name=' . $eventName . '&table_name=' . $tableName . '">Edit</a>';
        echo '</li>';
    }
} else {
    echo "No events found.";
}
      
      $conn->close();
      ?>
    </ul>
  </div>
</body>
</html>