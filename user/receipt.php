<?php
require ('../action/main_work.php');
if (!isset($_SESSION['user_unique_id'])) {
    header("Location: ../login.php");
    exit;
}
$UserDetails = $for->alltable();
$user = $for->getsingledetail(($_SESSION['user_unique_id']));
if (isset($_GET['ref_id'])) {
    $ref_id = $_GET['ref_id'];
}
$row = $for->Invoice($ref_id);
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



                <div class="invoice-wrap">
    <div id="print-content"  class="invoice-box">
        <div class="invoice-header">
            <div class="logo text-center">
                <img src="vendors/images/banner-img.png" alt="">
            </div>
        </div>
        <h4 class="text-center mb-30 weight-600">INVOICE</h4>
        <div class="row pb-30">
            <div class="col-md-6">
                <h5 class="mb-15">Invoice</h5>
                <p class="font-14 mb-5"> <strong class="weight-600">Transaction</strong></p>
            </div>
            <div class="col-md-6 text-md-right">
                <p class="font-14 mb-5"><?php echo $ref_id; ?> </strong></p>
                <p class="font-14 mb-5"><?php  print $row[0]->status;?></p>

            </div>
        </div>
        <div class="invoice-desc pb-30">
            <div class="invoice-desc-footer">
                <div class="invoice-desc-head clearfix">
                    <div class="invoice-sub">Transaction Amount</div>
                    <div class="invoice-subtotal">$<?php  print $row[0]->amount;?></div>
                </div>
                <div class="clearfix">
                    <div class="invoice-sub">Transaction Type</div>
                    <div class="invoice-subtotal"><?php  print $row[0]->type;?></div>
                </div>
                <div class="invoice-desc-head clearfix">
                    <div class="invoice-sub">Payment Account</div>
                    <div class="invoice-subtotal"><?php echo substr($row[0]->account,0); ?></div>
                </div>
                <div class="clearfix">
                    <div class="invoice-sub">Transaction Status</div>
                    <div class="invoice-subtotal"><?php  print $row[0]->status;?></div>
                </div>
                <div class="invoice-desc-head clearfix">
                    <div class="invoice-sub">Transaction Date</div>
                    <div class="invoice-subtotal"><?php echo date("Y-m-d H:i:s", strtotime($row[0]->created_at)); ?></div>

                </div>
                <div class="invoice-desc-body">
                    <ul>
                        <li class="clearfix">
                            <!-- <div class="invoice-sub">
                                <p class="font-14 mb-5">Account No: <strong class="weight-600">123 456 789</strong></p>
                                <p class="font-14 mb-5">Code: <strong class="weight-600">4556</strong></p>
                            </div> -->
                            <div class="invoice-rate font-20 weight-600">Grand Total</div>
                            <div class="invoice-subtotal"><span class="weight-600 font-24 text-danger">$<?php  print $row[0]->amount;?></span></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <h4 class="text-center pb-20">Thank You!!</h4>
        
        <button onclick="printContent()" class="btn btn-primary">Print</button>

    </div>

</div>











    </div>








    <script>
    function printContent() {
        var originalContents = document.body.innerHTML;
        var printContents = document.getElementById("print-content").innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

<?php require('footer.php') ?>