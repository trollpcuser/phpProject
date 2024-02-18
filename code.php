<?php
// include('dboconn.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();
//Load Composer's autoloader
require 'includes/vendor/autoload.php';
// require 'autoload.php';

function sendemail_verify($email , $verify_token, $name ){
    $mail = new PHPMailer(true);
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'srishanth000@gmail.com';                     //SMTP username
    $mail->Password   = 'wdagpxqcxqyzzpoa';                               //SMTP password
    $mail->SMTPSecure = "ssl";            //Enable implicit ssl encryption
    $mail->Port       = 465; 
    //Recipients
    $mail->setFrom('srishanth000@gmail.com');
    $mail->addAddress($email);     //Add a recipient
       //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Verify your email with this link';
    
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $email_template ="
    <h2>Welcome $name,<br></h2>
    <h5>Please click the following link to activate your account</h5>
    <br></br>
    <a href='http://localhost/Signup/Day_2/verify-email.php?token=$verify_token'>clickme</a>
    ";
    $mail->Body    = $email_template;
    $mail->send();
    echo "Message has been sent";

}
if(isset($_POST['register_btn']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $confirm_password = $_POST['confirm_password'];
    $verify_token = md5(rand());

    $con = mysqli_connect("localhost","root","root@123","phptutorials");
    $check_email_query = "SELECT email FROM users WHERE email='$email' LIMIT 1";
    $check_email_query_run =mysqli_query($con,$check_email_query);
    if(mysqli_num_rows($check_email_query_run)>0)
    {
        $_SESSION['status'] = "Email id already exists";
        header("Location: register.php");
    }
    else{
        //Insert user / registerd users data
        //New Records into the database
        sendemail_verify("$email","$verify_token","$name");
        $query = "INSERT INTO users (name, email, password, verify_token) VALUES ('$name', '$email', '$password', '$verify_token')"; 
        $query_run = mysqli_query($con, $query);
        if($query_run){
            // sendemail_verify("$name","$email","$verify_token");
            $_SESSION['status'] = "Registration Successfully Added, please verify your email address";
            header("Location:register.php");
        }
        else{
            $_SESSION['status'] = "Registration Failed";
            header("Location:register.php");
        }
    }
}
?>


<!-- 
wdagpxqcxqyzzpoa -->

<!-- $sql_query = "INSERT INTO entry_details (email,subject,message) VALUES ('$email', '$subject', '$message')"; -->