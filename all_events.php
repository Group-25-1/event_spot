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
        <h1>All Events</h1>
      </div>

      <ul class="events">
        <?php
        session_start();
        @include 'config.php';

        // Function to delete event from event_form table by event name
        function deleteEventByName($conn, $eventName) {
          $sql = "DELETE FROM new_event WHERE eventName = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param('s', $eventName);
          if ($stmt->execute()) {
            return true;
          } else {
            return false;
          }
        }
         // Check if the "Delete" button is clicked and delete the event
         if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['event_name'])) {
          $eventName = $_GET['event_name'];
          if (deleteEventByName($conn, $eventName)) {
            echo "Event deleted successfully.";
          } else {
            echo "Error deleting event.";
          }
        }
          $sql = "SELECT * FROM new_event";
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
            $eventOrganizer = $row["organizer_name"];


            // Display event details in HTML
            echo '<li class="event">';
            echo '<img src="data:image/jpeg;base64,' . base64_encode($eventImage) . '" alt="Event Image" height="150px" width="150px">';
            echo '<p>Event Name:' . $eventName . '</p>';
            echo '<p>Ticket Price: ' . $ticketPrice . '</p>';
            echo '<p>Date: ' . $date . '</p>';
            echo '<p>Time: ' . $time . '</p>';
            echo '<p>Location: ' .$location . '</p>';
            echo '<p>Event Organizer: ' .$eventOrganizer . '</p>';
            echo '<a href="?action=delete&event_name=' . $eventName . '">Delete</a>';
            echo '</li>';
          }
        } else {
          echo "No events found.";
        }

          // Close database connection
          $conn->close();
        ?>
      </ul>
    </div>

  </body>
</html>