<?php
require ('../action/main_work.php');
if (!isset($_SESSION['user_unique_id'])) {
    header("Location: ../login.php");
    exit;
}
$userDetail = $for->getLoggedInUser();

?>

<?php require('head.php')?>


<?php require('header.php') ?>

<?php require('sidebar.php') ?>


<div class="mobile-menu-overlay"></div>

<div class="main-container">


<div class="pd-ltr-20 xs-pd-20-10">


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="profile-setting">
<form action="../action/main_work.php?option=report" method="post">
    <ul class="profile-edit-list">
        <li>
            <h4 class="text-blue h5 mb-20">New Ticket</h4>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tickel Type</label>
                            <select class="form-control form-control-lg" name="type">
                                <option value="">Select Loan type</option>
                                <option value="Account">My Account</option>
                                <option value="Transfer">Transfer</option>
                                <option value="Security">Security</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
				<label>More Information</label>
				<textarea class="form-control" name="information"></textarea>
            </div>
            <div class="form-group">
                <label>Account Pincode</label>
                <input class="form-control form-control-lg" name="pincode" maxlength="6" type="text">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create New Ticket</button>
            </div>
        </li>
    </ul>
</form>

            </div>
        </div>
    </div>
</div>





<?php require('footer.php') ?>