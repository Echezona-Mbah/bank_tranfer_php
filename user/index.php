<?php
require ('../action/main_work.php');
if (!isset($_SESSION['user_unique_id'])) {
    header("Location: ../login.php");
    exit;
}
$user = $for->getsingledetail(($_SESSION['user_unique_id']));
$lastgoin = $for->getlastlogin(($_SESSION['user_unique_id']));
$totalAmount = $user->saving_balance + $user->current_balance;
$UserDetails = $for->alltableID();

?>

<?php require('head.php') ?>


<?php require('header.php') ?>

<?php require('sidebar.php') ?>


<div class="mobile-menu-overlay"></div>

<div class="main-container">
    <div class="pd-ltr-20">
        <div class="card-box pd-20 height-100-p mb-30">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <img src="vendors/images/banner-img.png" alt="">
                </div>
                <div class="col-md-8">
                    <h4 class="font-20 weight-500 mb-10 text-capitalize">
                        Welcome back <div class="weight-600 font-30 text-blue"><?php echo $user->name; ?>!</div>
                    </h4>
                    <p class="font-18 max-width-600">"Welcome to Coastchartered! We're thrilled to have you join our banking family. With us, you're not just a customer – you're a valued member. As you embark on your banking journey with us, we're here to provide you with exceptional service, innovative financial solutions, and peace of mind. Thank you for choosing Coastchartered. Welcome aboard!"</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 mb-30">
                <div class="card-box height-100-p widget-style1">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data">
                            <div id="chart2"></div>
                        </div>
                        <div class="widget-data">
                            <div class="h4 mb-0"><?php echo number_format($totalAmount, 2); ?></div>
                            <div class="weight-600 font-14">Balance</div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-3 mb-30">
                <div class="card-box height-100-p widget-style1">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="widget-data">
                            <div class="h4 mb-0"></div>
                            <!-- <div class="weight-600 font-14">Bank Stament</div> -->
                            <div class="mt-3">
                                <a href="loan.php" class="btn btn-warning">Request loan</a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-3 mb-30">
                <div class="card-box height-100-p widget-style1">
                    <div class="d-flex flex-wrap align-items-center">
                        <!-- <div class="progress-data">
                                <div id="chart3"></div>
                            </div> -->
                        <div class="widget-data">
                            <div class="h4 mb-0"></div>
                            <div class="mt-3">
                                <a href="card.php" class="btn btn-primary">Request Card</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 mb-30">
                <div class="card-box height-100-p widget-style1">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data">
                            <div id="chart4"></div>
                        </div>
                        <div class="widget-data">
                            <div class="h4 mb-0">$0.00</div>
                            <div class="weight-600 font-14">Outflow</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                <div class="card-box pd-30 pt-10 height-100-p">
                    <h2 class="mb-30 h4">Browser Visit</h2>
                    <div class="browser-visits">
                        <ul>
                            <li class="d-flex flex-wrap align-items-center">
                                <!-- <div class="icon"><img src="vendors/images/chrome.png" alt=""></div> -->
                                <div class="browser-name">Loan Balance:</div>
                                <div class="visit"><span class="badge badge-pill badge-primary">$<?php echo number_format($user->loan_balance, 2); ?></span></div>
                            </li>
                            <li class="d-flex flex-wrap align-items-center">
                                <!-- <div class="icon"><img src="vendors/images/firefox.png" alt=""></div> -->
                                <div class="browser-name">Savings Balance:</div>
                                <div class="visit"><span class="badge badge-pill badge-secondary">$<?php echo number_format($user->saving_balance, 2); ?></span></div>
                            </li>
                            <li class="d-flex flex-wrap align-items-center">
                                <!-- <div class="icon"><img src="vendors/images/safari.png" alt=""></div> -->
                                <div class="browser-name">Current Balance:</div>
                                <div class="visit"><span class="badge badge-pill badge-success">$<?php echo number_format($user->current_balance, 2); ?></span></div>
                            </li>
                            <li class="d-flex flex-wrap align-items-center">
                                <!-- <div class="icon"><img src="vendors/images/edge.png" alt=""></div> -->
                                <div class="browser-name">Last Login IP:</div>
                                <div class="visit"><span class="badge badge-pill badge-warning">105.120.128.133</span></div>
                            </li>
                            <li class="d-flex flex-wrap align-items-center">
                                <!-- <div class="icon"><img src="vendors/images/opera.png" alt=""></div> -->
                                <div class="browser-name">Last Login Date:</div>
                                <div class="visit"><span class="badge badge-pill badge-info"><?php echo date('Y-m-d H:i', strtotime($lastgoin->update_at)); ?></span></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12 mb-30">
                <div class="card-box pd-30 pt-10 height-100-p">
                    <div class="mt-3">
                    </div>
                    <div class="mt-30" style="overflow-x: auto;">
                        <h3 class="mb-20 h5">Last History</h3>
                        <?php if (empty($UserDetails)): ?>
							<div class="alert alert-info" role="alert">
								No history availableddd.
							</div>
                        <?php else: ?>
                            <table class="table table-bordered"  style="overflow-x: auto;">
                                <thead>
                                    <tr>
                                    <th> Type</th>
                                    <th>Reference</th>
                                    <th>Amount</th>
                                    <th>Payment Account</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($UserDetails as $row): ?>
                                <tr>
                                <td><?php echo $row->type; ?></td>
                                <td><?php echo $row->Refrence_id; ?></td>
                                <td><?php echo $row->amount; ?></td>
                                <td><?php echo $row->account; ?></td>
                            </tr>
                        <?php endforeach; ?>
    
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>	
                    <a href="history.php" class="btn btn-primary">All History</a>
    
                    <div style="clear: both;"></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php require('footer.php') ?>
