<?php
@include 'config.php';

session_start();
if (isset($_SESSION['event_name'])) {
  $eventName = $_SESSION['event_name'];
  $_SESSION['event_name'] = $eventName;
  
} else {
  echo "Event name not found in session.";
  exit;
}

if (isset($_SESSION['organizer_name'])) {
  $organizer_name = $_SESSION['organizer_name'];
  $_SESSION['organizer_name'] = $organizer_name;
} else {
  echo "Organizer name not found in session.";
  exit;
}


if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($conn,$_POST['name']);
   $email = mysqli_real_escape_string($conn,$_POST['email']);

   $insert = "INSERT INTO ticket_book(eventName, organizer_name, name, email) 
              VALUES('$eventName', '$organizer_name', '$name', '$email')";
   mysqli_query($conn, $insert);
   header('location: generate_ticket.php?eventName=' . urlencode($eventName));
   exit;
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
    <h2>Enter details to generate tickets</h2>
    <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
    ?>
    <form action="#" method="post" enctype="multipart/form-data">
      <input type="hidden" name="eventName" value="<?php echo $eventName; ?>">
      <label for="name">Name :</label>
      <input type="text" id="name" name="name" required>

      <label for="email">Email :</label>
      <input type="text" id="email" name="email" required>

      <input type="submit" name="submit" value="Download ticket" >
    </form>
  </div>
</body>
</html>