<?php
session_start();

//page 2 for password reset

$page_title ="Password Reset";
include('includes/header.php'); 
include('includes/navbar.php');

?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php
                        if(isset($_SESSION['status'])){
                            ?>
                            <div class="alert alert-danger">
                                <h5><?= $_SESSION['status']; ?></h5>
                            </div>
                            <?php
                            unset($_SESSION['status']);
                        }
                ?>
                <div class="card shadow">
                    <div class="card-header">
                        <h3>Change Password</h3>
                    </div>
                    <div class="card-body">
                        
                        <form action="passwordchange.php" method="POST">
                            <input type="hidden" name="password_token" value="<?php if(isset($_GET['token'])){echo $_GET['token'];}?>">
                            <div class="form-group mb-3">
                                <label for="" >Email id</label>
                                <input type="email" name="email" value="<?php if(isset($_GET['email'])) {echo $_GET['email'];}?>" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="" >New Password</label>
                                <input type="password" name="new_password" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="" >Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="update_password" class="btn btn-success w-100">Update Password</button>
                            </div>
                        </form>
                                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>