<?php
require ('../action/main_work.php');

$UserDetails = $for->allDeposit();



$rowsPerPage = 10;
$totalRows = count($UserDetails);
$totalPages = ceil($totalRows / $rowsPerPage);
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1; 
$offset = ($currentPage - 1) * $rowsPerPage;
$currentPageRows = array_slice($UserDetails, $offset, $rowsPerPage);
// die();
?>


<?php require('head.php')?>
<style>
   .pagination {
    margin-top: 20px;
    text-align: center;
}

.pagination a {
    display: inline-block;
    padding: 5px 10px;
    margin: 0 5px;
    background-color: #f8f9fa;
    color: #343a40;
    text-decoration: none;
    border-radius: 3px;
    transition: background-color 0.3s;
}

.pagination a:hover {
    background-color: #e9ecef;
}

.pagination .active {
    background-color: #007bff;
    color: #fff;
}
</style>
<?php require('sidebar.php')?>
<?php require('topbar.php')?>

<div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Crypto Deposit</h2>
                           </div>
                        </div>
                     </div>

                     <div class="full price_table padding_infor_info">
                        <div class="row">
                              <div class="col-lg-12">
                                 <div class="table-responsive-sm">
                                    <table class="table table-striped projects">
                                             <thead class="thead-dark">
                                                <tr>
                                                   <th style="width: 2%">No</th>
                                                   <th >deposit Id</th>
                                                   <th>Name</th>
                                                   <th>account</th>
                                                   <th>Cypto Type</th>
                                                   <th>Wallet</th>
                                                   <th>Type</th>
                                                   <th>Proof</th>
                                                   <th>Status</th>
                                                   <th>Delete</th>
                                                   <th>action</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                             <?php $i = 1; ?>
                                                <?php foreach ($currentPageRows as $row): ?>

                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $row->deposit_id ; ?></td>
                                                    <?php $user = $for->getsingledetail($row->user_unique_id); ?>
                                                    <td><?php echo $user->name; ?></td>
                                                    <td><?php echo $row->account; ?></td>
                                                    <td><?php echo $row->cypto_type; ?></td>
                                                    <td><?php echo $row->wallet; ?></td>
                                                    <td><?php echo $row->type; ?></td>
                                                        <div class="modal fade" id="imageModal<?php echo $i; ?>" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <img id="modalImage<?php echo $i; ?>" src="<?php echo ($row->proof); ?>" alt="Modal Image" class="img-fluid">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <td>
                                                            <a href="<?php echo ($row->proof); ?>" data-toggle="modal" data-target="#imageModal<?php echo $i; ?>">
                                                                <img style="width: 300px; height: auto;" src="<?php echo ($row->proof); ?>" alt="Proof" class="img-fluid">
                                                            </a>
                                                        </td>
                                                    <td><?php echo $row->status; ?></td>

                                                   <td>
                                                      <form method="post" action="../action/main_work.php?option=deleteDeposit">
                                                         <input type="hidden" name="user_id" value="<?php echo $row->deposit_id; ?>">
                                                         <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Delete">Delete</button>
                                                      </form>
                                                   </td>


                                                   <td>
                                                   <?php
                                                   $userId = $row->deposit_id;
                                                   $status = ($row->status == 'Processing') ? 'Complete' : 'Processing';
                                                   $statu = ($row->status == 'Processing') ? 'depositComplete' : 'depositProcessing';
                                                   ?>
                                                      <form action="../action/main_work.php?option=<?php echo $statu; ?>" method="post">
                                                      <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                                                      <input type="hidden" name="status" value="<?php echo $status; ?>">
                                                      <button class="btn btn-success" data-toggle="tooltip" data-placement="top"  type="submit">
                                                         <?php echo ucfirst($status); ?>
                                                      </button>
                                                   </form>
                                                   </td>


                                                </tr>
                                                <?php endforeach; ?>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
 
                              <?php $i = 1; ?>
    <?php foreach ($currentPageRows as $row): ?>
        <!-- Modal for displaying the image -->
        <div class="modal fade" id="imageModal<?php echo $i; ?>" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <img id="modalImage<?php echo $i; ?>" src="<?php echo $row->proof; ?>" alt="Modal Image" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        <?php $i++; ?>
    <?php endforeach; ?>

                              <div class="pagination">
                                 <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                                    <a href="?page=<?php echo $page; ?>"<?php if ($page == $currentPage) echo ' class="active"'; ?>><?php echo $page; ?></a>
                                 <?php endfor; ?>
                              </div>

                            </div>


                            <script>
  $(document).ready(function() {
    $('#imageModal').on('show.bs.modal', function(event) {
      var imageSource = $(event.relatedTarget).attr('href'); 
      $('#modalImage').attr('src', imageSource);
    });
  });
</script>


<?php require('footer.php')?>