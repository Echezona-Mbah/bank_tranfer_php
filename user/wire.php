<?php
require ('../action/main_work.php');
if (!isset($_SESSION['user_unique_id'])) {
    header("Location: ../login.php");
    exit;
}
$account = $for->getLoggedInUserDetails();
$accountTypes = $for->accountType();
$currencies = $for->courrency();
$user = $for->getsingledetail(($_SESSION['user_unique_id']));
$fee = $for->feewire();
$totalAmount = $user->saving_balance + $user->current_balance;

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
								<h4>International Transfer</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">International Transfer</li>
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
							<h4 class="text-blue h4">International Transfer</h4>
							<!-- <p class="mb-30">All bootstrap element classies</p> -->
						</div>
					</div>
                    <form class="dropzone"action="../action/main_work.php?option=wire" method=post enctype="multipart/form-data" id="my-awesome-dropzone">
                    <span>Amount  (Total Balance: $<?php echo number_format($totalAmount, 2); ?>)</span>
                    <div class="input-group mb-3">
                        <span class="input-group-text"  style="background:#C0C0C0">$</span>
                        <input type="text" class="form-control"  name="amount" id="amountInput" aria-label="Amount (to the nearest dollar)">
                        <span class="input-group-text" style="background:#C0C0C0">Fee:<?php echo $fee ?></span>
                    </div>

                        <div class="form-group">
                            <label>Payment Account</label>
                            <select class="form-control" name="account" value="<?php if (isset($_SESSION{'account'})) {echo $_SESSION['account'];}?>">
                                <?php
                                if ($account !== 'No Data was returned') { 
                                    while ($row = mysqli_fetch_assoc($account)) { 
                                        echo "<option value=''>Select Source Account</option>";
                                        echo "<option value='Current Account ({$row['current']}) '>Current Account ({$row['current']}) Current: $" . $user->current_balance . "</option>";
                                        echo "<option value=' Savings Account ({$row['saving']})'>Savings Account ({$row['saving']}) Savings: $" . $user->saving_balance . "</option>";
                                    }
                                } else {
                                    echo "<option>No accounts available</option>";
                                }
                                ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Account Type</label>
                            <select class="form-control" name="account_type">
                                <?php
                                if ($accountTypes !== 'No Data was returned') {
                                    echo "<option value=''>Select Account Type</option>";
                                    foreach ($accountTypes as $type) {
                                        echo "<option value='{$type->name}'>{$type->name}</option>";
                                    }
                                } else {
                                    echo "<option value=''>No Account Types Available</option>";
                                }
                                ?>
                            </select>
                        </div>



                        <div class="form-group">
                            <label>Bank Name</label>
                            <input class="form-control" id="bank_name" name="bank_name" type="text">
                        </div>


                        <div class="form-group">
                            <label>Account Number</label>
                            <input class="form-control" id="account_number" name="account_number" type="text">
                        </div>

                        <div class="form-group">
                            <label>Account Name</label>
                            <input class="form-control" id="account_name" name="account_name" type="text">
                        </div>

                        
                        <div class="form-group">
                            <label>Bank Country</label>
                            <select class="form-control" name="bank_country" id="currencySelector">
                                <?php
                                if ($currencies !== 'No Data was returned') {
                                    foreach ($currencies as $currency) {
                                        echo "<option value='{$currency->id}' data-rate='{$currency->currency}'>{$currency->name}</option>";
                                    }
                                } else {
                                    echo "<option value=''>No Account Types Available</option>";
                                }
                                ?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Routine Number/ Bank Code</label>
                            <input class="form-control" id="bank_code" name="bank_code" type="text">
                        </div>




                        <div class="form-group">
                            <label>Details</label>
                            <textarea class="form-control" name="details" placeholder="Reason For Tranfer" rows="5"></textarea>
                        </div>



                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Make Tranfer</button>
                        </div>

					</form>

				</div>

    </div>





    <script>
        const currencySelector = document.getElementById('currencySelector');
    const amountInput = document.getElementById('amountInput');
    currencySelector.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const exchangeRate = selectedOption.dataset.rate;
        const amount = parseFloat(amountInput.value);
        const convertedAmount = amount * exchangeRate;
        amountInput.value = convertedAmount.toFixed(2);
    });
</script>







<?php require('footer.php') ?>