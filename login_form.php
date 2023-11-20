<?php
@include 'config.php';
session_start();

$error = []; // Array to store error messages

if(isset($_POST['submit'])){
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn,$_POST['password']);
   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";
   $result = mysqli_query($conn, $select);
   if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_array($result);
      if($row['user_type'] == 'admin'){
         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['logged_in'] = true; 
         header('location:admin_home.php?name=' . urlencode($row['name'])); // Pass the user's name to admin_home.php as a query parameter
         exit();
      }elseif($row['user_type'] == 'Event-organizer'){
         $_SESSION['user_name'] = $row['name'];
         $_SESSION['logged_in'] = true;
         header('location:user_home.php?name=' . urlencode($row['name'])); // Pass the user's name to user_home.php as a query parameter
         exit();
      }
   }else{
      $error[] = 'Incorrect email or password!'; // Add error message to the array
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>
   <style>
   * {
     font-family: "Poppins", sans-serif;
     margin: 0;
     padding: 0;
     box-sizing: border-box;
     outline: none;
     border: none;
     text-decoration: none;
   }
   body{
      min-height: 100vh;
        background: #eee;
   }
   .nav{
      background: #7c4bf8;
      padding: 5px;
      padding-left: 10px;
   }
   .form-container {
     display: flex;
     align-items: center;
     justify-content: center;
     margin: 25px;
     padding: 50px;
     padding-bottom: 60px;
     background: #eee;
   }
   .form-container form {
     padding: 20px;
     border-radius: 5px;
     box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
     background: #fff;
     text-align: center;
     width: 500px;
   }
   .form-container form h3 {
     font-size: 30px;
     text-transform: uppercase;
     margin-bottom: 10px;
     color: #333;
   }
   .form-container form input,
   .form-container form select {
     width: 100%;
     padding: 10px 20px;
     font-size: 17px;
     margin: 15px 5px;
     background: #eee;
     border-radius: 5px;
   }
   .form-container form select option {
     background: #fff;
   }
   .form-container form .form-btn {
     background: #7c4bf8;
     color: #fff;
     text-transform: capitalize;
     font-size: 20px;
     cursor: pointer;
   }
   .form-container form .form-btn:hover {
     background: #fff;
     color: #7c4bf8;
     border: 1px solid #7c4bf8;
   }
   .form-container form p {
     margin-top: 10px;
     font-size: 20px;
     color: #333;
   }
   .form-container form p a {
     color: #7c4bf8;
   }
   .form-container form .error-msg {
     margin: 10px 0;
     display: block;
     background: crimson;
     color: #fff;
     border-radius: 5px;
     font-size: 20px;
     padding: 10px;
   }
   </style>
</head>
<body>
   <!-- Your HTML code here -->
   <div class="nav">
   </div> 
   <div class="form-container">
      <form action="" method="post">
         <h3>Login Now</h3>
         <?php
         if(!empty($error)){ // Check if there are any error messages
            foreach($error as $errorMsg){
               echo '<span class="error-msg">'.$errorMsg.'</span><br>';
            }
         }
         ?>
         <input type="email" name="email" required placeholder="Enter your email">
         <input type="password" name="password" required placeholder="Enter your password">
         <input type="submit" name="submit" value="Login Now" class="form-btn">
         <p>Don't have an account? <a href="register_form.php">Register Now</a></p>
      </form>
   </div>
</body>
</html>