<?php
require ('../action/main_work.php');
if (!isset($_SESSION['user_unique_id'])) {
    header("Location: ../login.php");
    exit;
}
$UserDetails = $for->alltable();
$user = $for->getsingledetail(($_SESSION['user_unique_id']));
$fee = $for->feeself();



$rowsPerPage = 10;
$totalRows = count($UserDetails);
$totalPages = ceil($totalRows / $rowsPerPage);
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1; 
$offset = ($currentPage - 1) * $rowsPerPage;
$currentPageRows = array_slice($UserDetails, $offset, $rowsPerPage);

?>



<?php require('head.php')?>

<style>
    .pagination {
        margin-top: 20px;
        text-align: right;
    }

    .pagination a {
        color: #333;
        padding: 8px 16px;
        text-decoration: none;
        transition: background-color 0.3s;
        border: 1px solid #ddd;
        margin: 0 4px;
    }

    .pagination a.active {
        background-color: #007bff;
        color: white;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }

    .checkbox-datatable {
        width: 100%;
        border-collapse: collapse;
    }

    .checkbox-datatable th,
    .checkbox-datatable td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .checkbox-datatable th {
        background-color: #f2f2f2;
    }

    .checkbox-datatable tbody tr:nth-child(even) {
        background-color: #f2f2f2;
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
								<h4>History</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">History</li>
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
				<div class="card-box mb-30">
					<div class="pd-20">
						<h4 class="text-blue h4">Data Table with History</h4>
					</div>
					<div class="pb-20" style="overflow-x: auto;">
    <table class="checkbox-datatable table nowrap">
        <thead>
            <tr>
                <th><div class="dt-checkbox">
                        <input type="checkbox" name="select_all" value="1" id="example-select-all">
                        <span class="dt-checkbox-label"></span>
                    </div>
                </th>
                <th>Reference</th>
                <th>Amount</th>
                <th>Account type</th>
                <th>Transaction type</th>
                <th>Payment Account</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($currentPageRows as $row): ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row->Refrence_id; ?></td>
                    <td><?php echo $row->amount; ?></td>
                    <td><?php echo $row->type; ?></td>
                    <td style="color: <?php echo $row->transaction_type === 'Credit' ? 'green' : 'red'; ?>">
                        <?php echo $row->transaction_type; ?>
                    </td>



                    <td><?php echo $row->account; ?></td>
                    <td>
                        <?php
                        $buttonClass = '';
                        if ($row->status == 'Processing') {
                            $buttonClass = 'btn-warning'; 
                        } elseif ($row->status == 'complete') {
                            $buttonClass = 'btn-success'; 
                        }
                        ?>
                        <button type="button" class="btn <?php echo $buttonClass; ?>"><?php echo $row->status; ?></button>
                    </td>
                    <td>
                        <?php
                        $timestamp = strtotime($row->created_at);
                        $formattedDatetime = date('Y-m-d H:i:s', $timestamp);
                        echo $formattedDatetime;
                        ?>
                    </td>
					<td>
						<a href="invoice.php?ref_id=<?php echo $row->Refrence_id; ?>" class="btn btn-info">View Receipt</a>
					</td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Pagination links -->
<div class="pagination">
    <?php for ($page = 1; $page <= $totalPages; $page++): ?>
        <a href="?page=<?php echo $page; ?>"<?php if ($page == $currentPage) echo ' class="active"'; ?>><?php echo $page; ?></a>
    <?php endfor; ?>
</div>


				</div>

    </div>










<?php require('footer.php') ?>