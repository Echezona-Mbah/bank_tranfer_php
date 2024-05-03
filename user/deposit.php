<?php
require ('../action/main_work.php');
if (!isset($_SESSION['user_unique_id'])) {
    header("Location: ../login.php");
    exit;
}
$user = $for->getsingledetail(($_SESSION['user_unique_id']));
$account = $for->getLoggedInUserDetails();
$wallets = $for->allwellect();
if ($wallets === 'No Data was returned' || $wallets === 'Error fetching data') {
    $errorMessage = $wallets;
}
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
								<h4>Cryptocurrency Deposit</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Image Dropzone</li>
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
							<h4 class="text-blue h4">Cryptocurrency Deposit</h4>
							<!-- <p class="mb-30">All bootstrap element classies</p> -->
						</div>
					</div>
                    <form class="dropzone"action="../action/main_work.php?option=deposit" method=post enctype="multipart/form-data" id="my-awesome-dropzone">						<div class="form-group">
							<label>Amount</label>
							<input class="form-control" type="text" name="amount" placeholder="Amount" value="<?php if (isset($_SESSION{'amount'})) {echo $_SESSION['amount'];}?>">
						</div>
                        <div class="form-group">
                            <label>Select Account</label>
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
                            <label>Select Wallet</label>
                            <select class="form-control" id="walletSelect" name="cypto_type" value="<?php if (isset($_SESSION{'cypto_type'})) {echo $_SESSION['cypto_type'];}?>">
                                <option value="">Select Wallet</option>
                                <?php
                                if (is_array($wallets)) {
                                    foreach ($wallets as $k => $wallet) {
                                        echo "<option value='{$wallet->bitcoin}' data-address='{$wallet->bitcoin}'>Bitcoin</option>";
                                        echo "<option value='{$wallet->etheurem}' data-address='{$wallet->etheurem}'>Etheurem</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group" id="walletAddressGroup" style="display: none;">
                            <label>Wallet Address</label>
                            <input class="form-control" id="walletAddress" name="wallet" type="text" readonly>
                        </div>



						<div class="form-group">
							
                            <div class="fallback">
                                <input type="file" name="image" id="fileInput" accept="image/*" onchange="previewImage(event)" />
                            </div>
                            <div id="imagePreview" style="display: none; display: flex; justify-content: center; align-items: center;">
                                <img id="preview" src="#" alt="" style="max-width: 100%; max-height: 200px;" />
                            </div>
						</div>


                        <div class="form-group">
							<label>Account Pincode</label>
							<input class="form-control" value="" name="pincode" type="text">
						</div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Meke Deposit</button>
                        </div>

					</form>

				</div>

    </div>



    <script>
    document.getElementById('walletSelect').addEventListener('change', function() {
        var selectedWalletOption = this.options[this.selectedIndex];
        var walletAddressGroup = document.getElementById('walletAddressGroup');
        var walletAddressInput = document.getElementById('walletAddress');

        // Check if a wallet option is selected
        if (selectedWalletOption.value !== '') {
            var walletAddress = selectedWalletOption.getAttribute('data-address');
            walletAddressInput.value = walletAddress;
            walletAddressGroup.style.display = 'block';
        } else {
            walletAddressInput.value = '';
            walletAddressGroup.style.display = 'none';
        }
    });
</script>





        <script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var imagePreview = document.getElementById('imagePreview');
            var preview = document.getElementById('preview');
            preview.src = reader.result;
            imagePreview.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>



<?php require('footer.php') ?>