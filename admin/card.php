<?php
require ('../action/main_work.php');

$UserDetails = $for->allCard();



$rowsPerPage = 10;
$totalRows = count($UserDetails);
$totalPages = ceil($totalRows / $rowsPerPage);
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1; 
$offset = ($currentPage - 1) * $rowsPerPage;
$currentPageRows = array_slice($UserDetails, $offset, $rowsPerPage);
// die();
?>


<?php require('head.php')?>
<?php require('sidebar.php')?>
<?php require('topbar.php')?>

<div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Card</h2>
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
                                                   <th >Card Id</th>
                                                   <th>Name</th>
                                                   <th>account</th>
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
                                                    <td><?php echo $row->card_id; ?></td>
                                                    <?php $user = $for->getsingledetail($row->user_unique_id); ?>
                                                    <td><?php echo $user->name; ?></td>
                                                   <td><?php echo $row->account; ?></td>
                                                   <td><?php echo $row->status; ?></td>

                                                   <td>
                                                      <form method="post" action="../action/main_work.php?option=deleteCard">
                                                         <input type="hidden" name="user_id" value="<?php echo $row->card_id; ?>">
                                                         <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Delete">Delete</button>
                                                      </form>
                                                   </td>


                                                   <td>
                                                   <?php
                                                   $userId = $row->card_id;
                                                   $status = ($row->status == 'Processing') ? 'Complete' : 'Processing';
                                                   ?>
                                                      <form action="../action/main_work.php?option=<?php echo $status; ?>" method="post">
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





<?php require('footer.php')?>