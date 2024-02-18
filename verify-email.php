<?php
session_start();

if(isset($_GET['token'])){
    $token = $_GET['token'];
    $verify_query = "SELECT verify_token, verify_status from users WHERE verify_token='$token' limit 1";
    $con = mysqli_connect("localhost","root","root@123","phptutorials");
    $verify_query_run = mysqli_query($con,$verify_query);

    if(mysqli_num_rows($verify_query_run)>0){
        $row = mysqli_fetch_array($verify_query_run);
        // echo $row['verify_token'];
        if($row['verify_status']=="0"){
            $clicked_token =$row['verify_token'];
            $update_query = "UPDATE users SET verify_status='1' WHERE verify_token='$clicked_token' limit 1";
            $update_query_run = mysqli_query($con,$update_query);
            if($update_query_run){
                $_SESSION['status'] ="Your Account has been verified successfully";
                header("Location: login.php");
                exit(0);
            }else{
                $_SESSION['status'] ="Verificatio Failed";
                header("Location: login.php");
                exit(0);
            }
        }
        else{
            $_SESSION['status'] ="Email Already Verified. Please login";
            header("Location: login.php");
            exit(0);
        }
    }else{
        $_SESSION['status'] ="This token does not exist";
        header("Location: login.php");
    }

}

else{
    $_SESSION['status'] ="NOT ALLOWED";
    header("Location: login.php");
}
?>