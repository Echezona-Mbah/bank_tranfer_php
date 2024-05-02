<?php
require ('../action/main_work.php');
if (!isset($_SESSION['user_unique_id'])) {
    header("Location: ../login.php");
    exit;
}
$account = $for->getLoggedInUserDetails();
$accounts = $for->getLoggedInUserDetails();
$accountTypes = $for->accountType();
$currencies = $for->courrency();
$user = $for->getsingledetail(($_SESSION['user_unique_id']));
$fee = $for->feeself();

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
								<h4>Loan Request</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Loan Request</li>
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

				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">Loan Request</h4>
							<!-- <p class="mb-30">All bootstrap element classies</p> -->
						</div>
					</div>
                    <form class="dropzone"action="../action/main_work.php?option=loan" method=post enctype="multipart/form-data" id="my-awesome-dropzone">
                    <span>Loan Amount</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"  style="background:#C0C0C0">$</span>
                        <input type="text" class="form-control"  name="amount" id="amountInput" aria-label="Amount (to the nearest dollar)">
                    </div>

                        <div class="form-group">
                            <label>Settlement Account</label>
                            <select class="form-control" name="account" value="<?php if (isset($_SESSION{'account'})) {echo $_SESSION['account'];}?>">
                                <?php
                                if ($account !== 'No Data was returned') { 
                                    while ($row = mysqli_fetch_assoc($account)) { 
                                        echo "<option value=''>Select Source Account</option>";
                                        echo "<option value='current'>Current Account ({$row['current']}) Current: $" . $user->current_balance . "</option>";
                                        echo "<option value='saving'>Savings Account ({$row['saving']}) Savings: $" . $user->saving_balance . "</option>";
                                    }
                                } else {
                                    echo "<option>No accounts available</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Loan Type</label>
                            <select class="form-control" name="loan_type" value="<?php if (isset($_SESSION{'loan_type'})) {echo $_SESSION['loan_type'];}?>">
                                <option value="">Select Loan Type</option>
                                <option value="Business Loan">Business Loan</option>
                                <option value="Individual Loan">Individual Loan</option>
                                <option value="Student Loan">Student Loan</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Loan Duration</label>
                            <select class="form-control" name="loan_duration" value="<?php if (isset($_SESSION{'loan_duration'})) {echo $_SESSION['loan_type'];}?>">
                                <option value="">Select Loan Duration</option>
                                <option value="1 Week">1 Week</option>
                                <option value="2 Week">2 Week</option>
                                <option value="1 Months">1 Months</option>
                                <option value="3 Months">3 Months</option>
                                <option value="1 Year">1 Year</option>
                            </select>
                        </div>



                        <div class="form-group">
                            <label>Details</label>
                            <textarea class="form-control" name="details" placeholder="Reason For Loan" rows="5"><?php if (isset($_SESSION['details'])) { echo $_SESSION['details']; } ?></textarea>
                        </div>





                        <div class="form-group">
							<label>Account Pincode</label>
							<input class="form-control" value="" name="pincode" type="text">
						</div>





                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Request Loan</button>
                        </div>

					</form>

				</div>

    </div>










<?php require('footer.php') ?>