<?php

@include 'config.php';

session_start();

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
if(isset($_SESSION['status']))
{   
    ?>
    <div class="empty">
    <?php
    echo $_SESSION['status'];
    unset($_SESSION['status']);
}
?>
</div>

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

   <form action="reset_pwd.php" method="post">
      <h3>Reset Password</h3>
      <input type="email" name="email" class="box" placeholder="enter your email" required>
      <input type="submit" class="btn" name="reset_link" value="Send Reset Email">
   </form>

</section>

</body>
</html>