<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['admin_name'])) {
  header('Location: login_form.php');
  exit();
}
$adminName = $_SESSION['admin_name'];
// Logout functionality
if (isset($_POST['logout'])) {
  session_destroy();
  header('Location: home_page.php');
  exit();
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
        min-height: 100%;
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
      .nav .right-btn{
        display: flex;
      }
      .nav .right-btn button,
      .nav .right-btn a,
      .nav .right-btn p {
        font-size: 1.5rem;
        font-family: inherit;
        padding: 5px;
        margin: 0 10px;
      }
      .nav .right-btn button,
      .nav .right-btn a{
        background: #eee;
        border: 1px solid #000;
        border-radius: 5px;
      }
      .categories {
        margin: 0 auto;
        min-height: 82vh;
        background: #eee;
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
        align-items: center;
      }

      .category {
        width: 220px;
        height: 200px;
        background-color: #fff;
        padding: 20px;
        margin: 20px;
        margin-right: 100px;
        margin-left: 100px;
        text-align: center;
        border: 1px solid #000;
        border-radius: 10px;
      }
      .category h3 {
        font-size: 24px;
        margin-bottom: 10px;
      }

      .category p {
        font-size: 16px;
      }

      .category img {
        width: 75%;
        height: 75%;
      }
      .footer {
        min-height: 8vh;
        background: #7c4bf8;
        padding: 5px;
        padding-left: 10px;
      }
    </style>
  </head>
  <body>
    <div class="nav">
      <div class="logo">admin page</div>
      <div class="right-btn">
        <p>Welcome, <?php echo $adminName; ?></p>
        <!-- <a href="manage_events.php">manage events</a> -->
        <a href="logout.php">logout</a>
      </div>
    </div>
    <div class="categories">
      <a href="manage_events.php">
        <div class="category">
          <h3>Manage Events</h3>
        </div>
      </a>
      <a href="all_events.php">
        <div class="category">
          <h3>all Events</h3>
        </div>
      </a>
      <a href="all_event_organizers.php">
        <div class="category">
          <h3>Manage users</h3>
        </div>
      </a>
    </div>
    <div class="footer"></div>
  </body>
</html>