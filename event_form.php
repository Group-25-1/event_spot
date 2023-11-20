<?php
@include 'config.php';

session_start();
if (isset($_GET['name'])) {
            $username = $_GET['name'];
            echo '<p>Welcome, ' . $username . '!</p>';
          }
          else{
            // echo'user name cannot get';
          }
if(isset($_POST['submit'])){
   $eventName = mysqli_real_escape_string($conn, $_POST['eventName']);
   $ticketPrices = mysqli_real_escape_string($conn, $_POST['ticketPrices']);
   $date = mysqli_real_escape_string($conn,$_POST['date']);
   $time = mysqli_real_escape_string($conn,$_POST['time']);
   $location = mysqli_real_escape_string($conn,$_POST['location']);
   $eventCategory = $_POST['eventCategory'];
   $eventDescription = mysqli_real_escape_string($conn,$_POST['eventDescription']);

   // Handle file upload
   $eventImage = $_FILES['eventImage']['tmp_name'];
   $eventImageContent = file_get_contents($eventImage);
   $eventImageContent = mysqli_real_escape_string($conn, $eventImageContent);

   $insert = "INSERT INTO event_form(eventName, ticketPrices, date, time, eventImage, location, eventCategory, eventDescription,organizer_name) 
              VALUES('$eventName', '$ticketPrices', '$date', '$time', '$eventImageContent', '$location', '$eventCategory', '$eventDescription','$username')";
   mysqli_query($conn, $insert);
   header('location:event_form.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Event Page</title>
  <style>
    /* Styling for the container */
    .container {
      width: 80%;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
    }

    /* Styling for headings */
    h1, h2 {
      text-align: center;
      font-size: 24px;
      margin-bottom: 20px;
    }

    h2 {
      font-size: 20px;
    }

    /* Styling for labels */
    label {
      display: block;
      margin-bottom: 5px;
    }

    /* Styling for inputs and textarea */
    input, textarea {
      width: 100%;
      padding: 5px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    /* Styling for submit button */
    input[type="submit"] {
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      margin-top: 20px;
    }

    input[type="submit"]:hover {
      background-color: #0069d9;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Post Your Event</h2>
    <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
    ?>
    <form action="#" method="post" enctype="multipart/form-data">
      <label for="eventName">Event Name:</label>
      <input type="text" id="eventName" name="eventName" required>

      <label for="ticketPrices">Ticket Prices:</label>
      <input type="text" id="ticketPrices" name="ticketPrices" required>

      <label for="date">Date:</label>
      <input type="date" id="date" name="date" required>

      <label for="time">Time:</label>
      <input type="time" id="time" name="time" required>

      <label for="eventImage">Upload Event Image:</label>
      <input type="file" id="eventImage" name="eventImage" required>

      <label for="location">Location:</label>
      <input type="text" id="location" name="location" required>

      <label for="eventCategory">Select Event Category:</label>
      <select id="eventCategory" name="eventCategory" required>
        <option value="">Select Category</option>
        <option value="music">Music</option>
        <option value="cultural">Cultural</option>
        <option value="political">Political</option>
        <option value="education">Education</option>
        <option value="party">Party</option>
        <option value="sport">Sports</option>

      </select>

      <label for="eventDescription">Detailed Description of the Event:</label>
      <textarea id="eventDescription" name="eventDescription" rows="5" cols="30" required></textarea>

      <input type="submit" name="submit" value="Create Event" >
    </form>
  </div>
</body>
</html>