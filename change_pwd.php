<?php

@include 'config.php';

session_start();

if(isset($_GET['email']))
{
    $email = mysqli_real_escape_string($conn, $_GET['email']);
}

if(isset($_POST['set_pass']))
{
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    if($pass != $cpass)
       {
          $message[] = 'Confirm password not matched!';
       }
    else
    {
        mysqli_query($conn, "UPDATE `users` SET password ='$pass' WHERE email = '$email'") or die('query failed');
            $message[] = 'Registered successfully!';
            header('location:login.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<section class="form-container">

   <form action="" method="post">
      <h3>Change Password</h3>
      <input type="password" name="password" class="box" placeholder="enter your new password" required>
      <input type="password" name="cpassword" class="box" placeholder="enter confirm password" required>
      <input type="submit" class="btn" name="set_pass" value="Change Password">
   </form>

</section>

</body>
</html>