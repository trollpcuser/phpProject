<?php
session_start();

if(isset($_POST['login_now_btn'])){
    if(!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))){
        $con = mysqli_connect("localhost","root","root@123","phptutorials");
        $email = mysqli_real_escape_string($con,$_POST['email']);
        $password = mysqli_real_escape_string($con,$_POST['password']);

        $login_query = "SELECT * FROM users WHERE email='$email' AND password='$password' limit 1";
        $login_query_run = mysqli_query($con,$login_query);

        if(mysqli_num_rows($login_query_run)>0){
            $row = mysqli_fetch_array($login_query_run);
            if($row['verify_status']==1){
                $_SESSION['authenticated'] = true;
                $_SESSION['auth_user'] = [
                    'username' => $row['name'],
                    'email' => $row['email'],
                ];
                $_SESSION['status']="You are logged in successfully";
                header("Location: dashboard.php");
                exit(0);
            } 
            else{
                $_SESSION['status']="Please verify your email address to login";
                header("Location: login.php");
                exit(0);
            }
        }else{
            $_SESSION['status']="Invalid Email or Password";
            header("Location: login.php");
            exit(0);
        }
    }else{
        $_SESSION['status']="All fields are mandatory";
        header("Location: login.php");
        exit(0);
    }

}
?>