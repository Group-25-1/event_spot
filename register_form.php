<?php
@include 'config.php';

$error = []; // Array to store error messages

if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn,$_POST['password']);
   $cpass = mysqli_real_escape_string($conn,$_POST['cpassword']);
   $user_type = $_POST['user_type'];
   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";
   $result = mysqli_query($conn, $select);
   if(mysqli_num_rows($result) > 0){
      $error[] = 'User already exists!';
   }else{
      if($pass != $cpass){
         $error[] = 'Passwords do not match!';
      }else{
         $insert = "INSERT INTO user_form(name, email, password, user_type) VALUES('$name','$email','$pass','$user_type')";
         mysqli_query($conn, $insert);
         header('location:login_form.php');
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>

   <!-- custom css file link  -->
   <!-- <link rel="stylesheet" href="css/style.css"> -->
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
}
.form-container {
  /* min-height: 100vh; */
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
  padding: 10px 15px;
  font-size: 17px;
  margin: 8px 0;
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
.form-container form label {
      display: flex;
      align-items: center;
      margin-bottom: 10px;
   }

   .form-container form input[type="checkbox"] {
      margin-right: 5px;
   }
   </style>

</head>
<body>
     <div class="nav">
   </div> 
<div class="form-container">
   <form action="" method="post">
      <h3>register now</h3>
      <?php
      if(!empty($error)){ // Check if there are any error messages
         foreach($error as $errorMsg){
            echo '<span class="error-msg">'.$errorMsg.'</span>';
         }
      }
      ?>
      <input type="text" name="name" required placeholder="enter your name">
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="password" name="cpassword" required placeholder="confirm your password">
      <select name="user_type">
         <option value="Event-organizer">Event-organizer</option>
         <option value="admin">admin</option>
      </select>
      <label>
         <input type="checkbox" name="agree" required>
         Agree with terms and conditions
      </label>
      <input type="submit" name="submit" value="Sign Up" class="form-btn">
      <p>already have an account? <a href="login_form.php">login now</a></p>
   </form>
</div>
</body>
</html>