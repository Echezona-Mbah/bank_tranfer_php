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
                <form action="../action/main_work.php?option=settingpin" method="post">
                    <ul class="profile-edit-list">
                        <li>
                            <h4 class="text-blue h5 mb-20">Manage Pin</h4>
                            <div class="form-group">
                                <label>Old Password</label>
                                <input class="form-control form-control-lg" name="oldpin" maxlength="6" type="text">
                            </div>
                            <div class="form-group">
                                <label>New Pin</label>
                                <input class="form-control form-control-lg" name="newpin" maxlength="6" type="text">
                            </div>
                            <div class="form-group">
                                <label>Confirm New Pin</label>
                                <input class="form-control form-control-lg" name="confirmpin" maxlength="6" type="text">
                            </div>
                            <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Change Pin</button>
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>





<?php require('footer.php') ?>