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
$fee = $for->feecard();

?>



<?php require('head.php')?>

<style>


.atm-card {
  width: 300px;
  height: 200px;
  border-radius: 10px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
  position: relative;
  overflow: hidden; /* Hide overflow content */
  background: linear-gradient(to right, #ff0000 50%, #0000ff 50%); /* Red to blue gradient */
}

.card-front,
.card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
}

.card-front {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 20px;
  background-color: blueviolet; /* White background color for the front */
}

.card-back {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  transform: rotateY(180deg);
  background-color: blueviolet; /* Dark background color for the back */
}

.bank-name {
  font-size: 18px;
  margin-bottom: 10px;
  padding-left: 130px;
}

.card-number {
  font-size: 18px;
  margin-bottom: 10px;
}

.card-details {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}

.card-expiry,
.card-holder {
  font-size: 12px;
}

.chip {
  width: 50px;
  height: 30px;
  background: radial-gradient(circle at 15% 50%, #6c6c6c, #434343 70%);
  border-radius: 5px;
  position: absolute;
  top: 20px;
  left: 20px;
}

.magnetic-strip {
  width: 80%;
  height: 15px;
  background-color: #333;
  margin-bottom: 10px;
}

.signature {
  width: 80%;
  height: 10%;
  background-color: #fff;
  border: 1px solid #333;
}



</style>

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
								<h4>Apply New Cards</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Apply New Cards</li>
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



                <div class="atm-card">
  <div class="card-front">
    <div class="chip"></div>
    <h2 class="bank-name">CREDIT CARD</h2>
    <div class="card-number">1234 XXXX XXXX XXXX</div>
    <div class="card-details">
      <div class="card-expiry">Exp: 12/24</div>
      <div class="card-holder">Card Holder</div>
    </div>
  </div>
  <div class="card-back">
    <div class="magnetic-strip"></div>
    <div class="signature">Signature</div>
  </div>
</div>


                <form class="dropzone"action="../action/main_work.php?option=card" method=post enctype="multipart/form-data" id="my-awesome-dropzone"><br><br>

                <label>Fee: $<?php echo $fee ?></label>


                        <div class="form-group">
                            <label>Select Card Account</label>
                            
                            <select class="form-control" name="account">
                              <?php
                              if ($account !== 'No Data was returned') { 
                                  echo "<option value=''>Select Source Account</option>";
                                  while ($row = mysqli_fetch_assoc($account)) { 
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
							<label>Account Pincode</label>
							<input class="form-control" value="" name="pincode" type="text">
						</div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Apply For Cards</button>
                        </div>

				</form>










    </div>








<?php require('footer.php') ?>