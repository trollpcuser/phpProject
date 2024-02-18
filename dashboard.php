<?php
include('authentication.php');
$page_title = "Dashboard";
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <?php
                if (isset($_SESSION['status'])) {
                ?>
                    <div class="alert alert-success">
                        <h5><?= $_SESSION['status']; ?></h5>
                    </div>
                <?php
                    unset($_SESSION['status']);
                }
                ?>
                <div class="card">
                    <div class="card-header">
                        <h2>Only authorized users access here</h2>
                    </div>
                    <div class="card-body">
                        <hr>
                        <h5>Username: <?= $_SESSION['auth_user']['username'] ?></h5>
                        <h5>Email ID: <?= $_SESSION['auth_user']['email'] ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('includes/footer.php'); ?>