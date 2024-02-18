<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();


require 'includes/vendor/autoload.php';


function resend_verify_email($name, $email, $verify_token){
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

if(isset($_POST['resend_btn'])){
    if(!empty(trim($_POST['email']))){
        $con = mysqli_connect("localhost","root","root@123","phptutorials");
        $email = mysqli_real_escape_string($con, $_POST['email']);
        
        $check_email_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $check_email_query_run = mysqli_query($con, $check_email_query);

        if(mysqli_num_rows($check_email_query_run)>0){
            $row = mysqli_fetch_array($check_email_query_run);
            if($row['verify_status']=="0"){
                $name = $row['name'];
                $email = $row['email'];
                $verify_token = $row['ver$verify_token'];
                resend_verify_email($name, $email, $verify_token);

                $_SESSION['status']="Resend Verification mail has been sent successfully";
                header("Location: login.php");
                exit(0);
            }
            else{
                $_SESSION['status']="Email Already Verified. Please login!!";
                header("Location: login.php");
                exit(0);
            }
        }
        else{
            $_SESSION['status']="Email is not registered. Please Register now";
            header("Location: register.php");
            exit(0);
        }
    }
    else{
        $_SESSION['status']="Please enter your email address";
        header("Location: resend-email-verification.php");
        exit(0);
    }

}


?>