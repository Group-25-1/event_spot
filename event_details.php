<?php
session_start();

@include 'config.php';

if (isset($_POST['submit'])) {
  // Get the comment and star rating from the form
  $comment = $_POST['comment'];
  $rating = $_POST['rating'];

  // Insert the comment and rating into the database
  $insert = "INSERT INTO event_comments (event_name, comment, rating) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($insert);
  $stmt->bind_param("sss", $_GET['event_name'], $comment, $rating);
  $stmt->execute();
  $stmt->close();
}

// Get the event name from the URL parameter
if (isset($_GET['event_name'])) {
  $eventName = $_GET['event_name'];

  // Fetch event details from the database based on the event name
  $sql = "SELECT * FROM new_event WHERE eventName = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $eventName);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $date = $row["date"];
    $location = $row["location"];
    $time = $row["time"];
    $organizer_name = $row["organizer_name"];
    $_SESSION['organizer_name'] = $organizer_name;
    $_SESSION['event_name'] = $eventName;
  } else {
    echo "Event not found.";
    exit;
  }
} else {
  echo "Invalid event name.";
  exit;
}

// Fetch comments for the event from the database
$sql_comments = "SELECT * FROM event_comments WHERE event_name = ?";
$stmt_comments = $conn->prepare($sql_comments);
$stmt_comments->bind_param("s", $eventName);
$stmt_comments->execute();
$result_comments = $stmt_comments->get_result();
$stmt_comments->close();

$comments = [];
if ($result_comments->num_rows > 0) {
  while ($row = $result_comments->fetch_assoc()) {
    $comment = $row['comment'];
    $rating = $row['rating'];
    $comments[] = ['comment' => $comment, 'rating' => $rating];
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Event Details</title>
    <style>
      * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    .event-details {
      margin-bottom: 20px;
    }

    .event-details h2 {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .event-details p {
      margin: 5px 0;
    }

    .comments {
      margin-bottom: 20px;
    }

    .comments h3 {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    .comment {
      border: 1px solid #ddd;
      padding: 10px;
      margin-bottom: 10px;
      background-color: #f9f9f9;
    }

    .comment p {
      margin: 5px 0;
    }

    .comment .rating {
      color: gold;
      margin-bottom: 5px;
    }

    .comment .rating::before {
      content: "★";
    }

    .comment .rating::after {
      content: attr(data-rating);
      margin-left: 5px;
    }

    .comment-form {
      margin-bottom: 20px;
    }

    .comment-form textarea {
      width: 100%;
      height: 100px;
      margin-bottom: 10px;
      resize: vertical;
    }

    .comment-form input[type="submit"] {
      padding: 8px 16px;
      background-color: #4caf50;
      color: white;
      border: none;
      cursor: pointer;
    }

    .comment-form input[type="submit"]:hover {
      background-color: #45a049;
    }

    .comment-form input[type="submit"]:focus {
      outline: none;
    }
    </style>

  </head>
  <body>
    <div class="container">
      <div class="event-details">
        <h2><?php echo $eventName; ?></h2>
        <p>Date: <?php echo $date; ?></p>
        <p>Location: <?php echo $location; ?></p>
        <p>Time: <?php echo $time; ?></p>
        <p>organizer_name: <?php echo $organizer_name; ?></p>

      </div>

      <div class="comments">
        <h3>Comments</h3>
        <?php
        if (!empty($comments)) {
          foreach ($comments as $comment) {
            echo '<div class="comment">';
            echo '<p>' . $comment['comment'] . '</p>';
            echo '<div class="rating" data-rating="' . $comment['rating'] .'"></div>';
            echo '</div>';
          }
        } else {
          echo 'No comments available.';
        }
        ?>
      </div>

      <div class="comment-form">
        <h3>Add a Comment</h3>
        <form action="" method="post">
          <textarea name="comment" placeholder="Enter your comment" required></textarea>
          <select name="rating" required>
            <option value="">Select Rating</option>
            <option value="1">1 star</option>
            <option value="2">2 stars</option>
            <option value="3">3 stars</option>
            <option value="4">4 stars</option>
            <option value="5">5 stars</option>
          </select>
          <button type="submit" name="submit" class="form-btn">Submit</button>
        </form>
      </div>

      <div class="generate-ticket">
        <form action="ticket_store.php" method="post" target="_self">
          <input type="hidden" name="event_name" value="<?php echo $eventName; ?>">
          <input type="hidden" name="date" value="<?php echo $date; ?>">
          <input type="hidden" name="location" value="<?php echo $location; ?>">
          <input type="hidden" name="time" value="<?php echo $time; ?>">
          <button type="submit" name="generate_ticket">Book event</button>
        </form>
      </div>
    </div>
  </body>
</html>