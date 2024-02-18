<?php 

session_start();

$page_title ="resend Email Verification";
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
                        <h3>Resend Email Verification</h3>
                    </div>
                    <div class="card-body">
                        <form action="resend.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="" >Email id</label>
                                <input type="email" name="email" class="form-control" field="required">
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="resend_btn" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>