<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();

//page 2 and 3 for password reset

require 'includes/vendor/autoload.php';

function send_password_reset($name, $email, $verify_token){
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
    <a href='http://localhost/Signup/Day_2/password-change-page.php?token=$verify_token&email=$email'>clickme</a>
    ";
    $mail->Body    = $email_template;
    $mail->send();
    echo "Message has been sent";
}

if(isset($_POST['reset_password'])){
    $email = $_POST['email'];
    $token = md5(rand());

    $con = mysqli_connect("localhost","root","root@123","phptutorials");

    $check_email = "SELECT email FROM users WHERE email='$email' limit 1";
    $check_email_run = mysqli_query($con, $check_email);

    if(mysqli_num_rows($check_email_run)>0){

        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['name'];
        $get_email = $row['email'];

        $update_token = "UPDATE users SET verify_token='$token' WHERE email='$get_email' limit 1";
        $update_token_run = mysqli_query($con, $update_token);

        if($update_token_run){
            send_password_reset($get_name, $get_email, $token);

            $_SESSION['status'] = "Password reset link has been sent";
            header("Location: password-reset.php");
            exit(0);
        }
        else{
            $_SESSION['status'] = "Something Went Wrong";
            header("Location: password-reset.php");
            exit(0);
        }
    }
    else{
        $_SESSION['status'] = "Email ID Not Found";
        header("Location: password-reset.php");
        exit(0);
    }
}

if(isset($_POST['update_password'])){
    $con = mysqli_connect("localhost","root","root@123","phptutorials");
    $email = mysqli_escape_string($con, $_POST['email']);

    $new_password = mysqli_escape_string($con, $_POST['new_password']);
    $confirm_password = mysqli_escape_string($con, $_POST['confirm_password']);

    $token = mysqli_escape_string($con, $_POST['password_token']);

    if(!empty($token)){
        if(!empty($email) && !empty($new_password) && !empty($confirm_password)){
            //checking token is valid or not:
            $check_token = "SELECT verify_token FROM users WHERE verify_token = '$token' LIMIT 1";
            $check_token_run = mysqli_query($con, $check_token);

            if(mysqli_num_rows($check_token_run)>0){

                if($new_password == $confirm_password){
                    $update_password = "UPDATE users SET password='$new_password' WHERE email='$email' limit 1";
                    $update_password_run = mysqli_query($con, $update_password);
    
                    if($update_password_run){
                        $new_token = md5(rand())."Modified";
                        $update_token = "UPDATE users SET verify_token='$new_token' WHERE verify_token='$token' limit 1";
                        $update_token_run = mysqli_query($con, $update_token);
                        $_SESSION['status'] = "New password updated";
                        header("Location: login.php");
                        exit(0);                    
                    }
                    else{
                        $_SESSION['status'] = "Did not update password, Something went wrong";
                        header("Location: password-change-page.php?token=$token&email=$email");
                        exit(0);
                    }
                }
                else{
                    $_SESSION['status'] = "Password and confirm password must be same";
                    header("Location: password-change-page.php?token=$token&email=$email");
                    exit(0);
                }
            }
            else{
                $_SESSION['status'] = "Invalid token";
                header("Location: password-change-page.php?token=$token&email=$email");
                exit(0);
            }
            
           
        }
        else{
            $_SESSION['status'] = "All Fields are Mandatory";
            header("Location: password-change-page.php?token=$token&email=$email");
            exit(0);
        }

    }
    else{
        $_SESSION['status'] = " No token found";
        header("Location: password-change-page.php");
        exit(0);
    }

}
?>