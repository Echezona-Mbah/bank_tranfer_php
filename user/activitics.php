<?php
require('../action/main_work.php');

// Check if the user is logged in
if (!isset($_SESSION['user_unique_id'])) {
    header("Location: ../login.php");
    exit;
}
$user = $for->getsingledetail(($_SESSION['user_unique_id']));

$activities = $for->getLoggedInActivitic($_SESSION['user_unique_id']);

if (is_object($activities)) {
    $no = 1;
?>


<?php require('head.php')?>


<?php require('header.php') ?>

<?php require('sidebar.php') ?>


<div class="mobile-menu-overlay"></div>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">

    <div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Activities</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Activities</li>
								</ol>
							</nav>
						</div>
						<!-- <div class="col-md-6 col-sm-12 text-right">
							<div class="dropdown">
								<a class="btn btn-primary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
									January 2018
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="#">Export List</a>
									<a class="dropdown-item" href="#">Policies</a>
									<a class="dropdown-item" href="#">View Assets</a>
								</div>
							</div>
						</div> -->
					</div>
				</div>

				<!-- Bordered table  start -->
				<div class="pd-20 card-box mb-30">
					<div class="clearfix mb-20">
						<div class="pull-left">
							<h4 class="text-blue h4"> Activities</h4>
						</div>

					</div>
                    <div style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-bordered">
                    <thead style="background-color: red;">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Internet ID</th>
                            <th scope="col">Information</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    while ($userDetails = mysqli_fetch_assoc($activities)) {
                        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $userDetails['user_unique_id']; ?></td>
                            <td><?php echo $userDetails['information']; ?></td>
                            <td><?php echo date('Y-m-d H:i:s', strtotime($userDetails['update_at'])); ?></td>
                        </tr>
                        <?php
                                $no++;
                            }
                        ?>
                    </tbody>
                </table>
            <?php
            } else {
                // Display a message if no data is returned
            ?>
                <p class="text-center alert-warning"><?php echo $eachUserDetails; ?></p>
            <?php
            }
            ?>

	    </div>
    </div>

	</div>



<?php require('footer.php') ?>