<?php 
@include 'config.php';

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

function send_password_reset($get_name,$get_email)
{
    $mail = new PHPMailer(true);

     $mail->SMTPDebug = 2;
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    //$mail->Host = 'theIPaddress';
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'samsamual055@gmail.com';                     //SMTP username
    $mail->Password   = 'nmpybpkvjokkbdvf';                               //SMTP password

    
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    //$mail->setFrom('cafedelightstechie@gmail.com', $get_name);
    $mail->setFrom('samsamual055@gmail.com');
    // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
    $mail->addAddress($get_email);               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
   //  $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Reset Password Notification';
    $mail->Body    = "<h2>Hello</h2>
        <h3>You are receiving this email because we recieved a password reset request for your account.
        <a href='http://localhost/flower%20store%20website/change_pwd.php?email=$get_email'>Click here to change password</a>";

    $mail->send();
    
}

if(isset($_POST['reset_link']))
{
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    
    $check_email = "SELECT * FROM `users` where email = '$email'";
    $check_email_run = mysqli_query($conn, $check_email);

    if(mysqli_num_rows($check_email_run)>0)
    {
        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['name'];
        $get_email = $row['email'];

        send_password_reset($get_name, $get_email);
        $_SESSION['status'] = "We e-mailed you a password reset link";
        header("location: forgot_pwd.php");
        exit(0);
    }

    else
    {
        $_SESSION['status'] = "No Email Found";
        header("location: forgot_pwd.php");
        exit(0);
    }
    
}

?>

