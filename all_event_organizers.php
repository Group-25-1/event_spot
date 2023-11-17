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
        <h1>All Event-organizers</h1>
      </div>

      <ul class="events">
        <?php
        session_start();
        @include 'config.php';

        // Function to delete event from event_form table by event name
        function deleteEventByName($conn, $name) {
          $sql = "DELETE FROM user_form WHERE name = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param('s', $name);
          if ($stmt->execute()) {
            return true;
          } else {
            return false;
          }
        }
          $sql = "SELECT * FROM user_form where user_type = 'Event-organizer'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $name = $row["name"];
            $email = $row["email"];
            


            // Display event details in HTML
            echo '<li class="event">';
            echo '<p>Name:' . $name . '</p>';
            echo '<p>Email: ' . $email . '</p>';
            echo '<a href="?action=delete&event_name=' . $name . '">Delete</a>';
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