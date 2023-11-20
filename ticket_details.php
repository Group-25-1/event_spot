<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Events List</title>
    <style>
      body {
        font-family: sans-serif;
      }
      .container {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
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
      }
      .event a:hover {
        background-color: #0056b3;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="header">
        <h1>Booking Tickets</h1>
      </div>

      <ul class="events">
        <?php
        session_start();
        @include 'config.php';
        if (isset($_GET['name'])) {
            $organizer_name = $_GET['name'];
            // Store the name value in a session variable
            $_SESSION['name'] = $organizer_name;
        } else if (isset($_SESSION['name'])) {
            // Retrieve the name value from the session variable
            $organizer_name = $_SESSION['name'];
        } else {
            echo 'No name found';
        } 
        // if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['event_name'])) {
        //   $event_name = $_GET['event_name'];
        //   $sql = "DELETE FROM user_form WHERE name = '$event_name'";
        //   if ($conn->query($sql) === TRUE) {
        //     echo "User '$event_name' deleted successfully.";
        //   } else {
        //     echo "Error deleting user: " . $conn->error;
        //   }
        // }
        $sql = "SELECT * FROM ticket_book WHERE organizer_name = '$organizer_name'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $eventName = $row["eventName"];
            $name = $row["name"];
            $email = $row["email"];

            echo '<li class="event">';
            echo '<p>Event Name:' . $eventName . '</p>';
            echo '<p>Name:' . $name . '</p>';
            echo '<p>Email: ' . $email . '</p>';
            // echo '<a href="?action=delete&event_name=' . $name . '">Delete</a>';
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