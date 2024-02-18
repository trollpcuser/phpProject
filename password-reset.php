<?php 
//page 1 for password reset
session_start();

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
                            <div class="alert alert-success">
                                <h5><?= $_SESSION['status']; ?></h5>
                            </div>
                            <?php
                            unset($_SESSION['status']);
                        }
                ?>
                <div class="card shadow">
                    <div class="card-header">
                        <h3>Reset your password</h3>
                    </div>
                    <div class="card-body">
                        <form action="passwordchange.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="" >Email id</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="reset_password" class="btn btn-primary">Send Reset Link</button>
                            </div>
                        </form>
                                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>