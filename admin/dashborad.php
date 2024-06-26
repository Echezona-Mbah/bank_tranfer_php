<?php
require ('../action/main_work.php');

$Totaluser = $for->Totaluser();
$Totalcard = $for->Totalcard();
$Totaldeposit = $for->Totaldeposit();
$Totaldepositcheck = $for->Totaldepositcheck();
$UserDetails = $for->alluser();



$rowsPerPage = 12;
$totalRows = count($UserDetails);
$totalPages = ceil($totalRows / $rowsPerPage);
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1; 
$offset = ($currentPage - 1) * $rowsPerPage;
$currentPageRows = array_slice($UserDetails, $offset, $rowsPerPage);
// die();



$search = isset($_GET['search']) ? $_GET['search'] : '';
$filteredRows = [];
foreach ($currentPageRows as $row) {
    if (stripos($row->name, $search) !== false ||
        stripos($row->lastname, $search) !== false ||
        stripos($row->email, $search) !== false ||
        stripos($row->phone, $search) !== false) {
        $filteredRows[] = $row;
    }
}
?>






<?php require('head.php')?>
<style>
   .search-form {
    margin-bottom: 20px;
}

.input-group {
    width: 100%;
}

.input-group-append .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

.input-group-append .btn-primary {
    border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
}

</style>
<?php require('sidebar.php')?>
<?php require('topbar.php')?>
               <!-- dashboard inner -->
               <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Dashboard</h2>
                           </div>
                        </div>
                     </div>
                     <div class="row column1">
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-user yellow_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?php echo $Totaluser ?></p>
                                    <p class="head_couter">Welcome</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-clock-o blue1_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?php echo $Totalcard ?></p>
                                    <p class="head_couter">Request Card</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-cloud-download green_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?php echo $Totaldeposit ?></p>
                                    <p class="head_couter">Total Crypto deposit</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30">
                              <div class="couter_icon">
                                 <div> 
                                    <i class="fa fa-comments-o red_color"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?php echo $Totaldepositcheck ?></p>
                                    <p class="head_couter">Total Check deposit</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="row column1">
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Project <small>( Listing Design )</small></h2>
                                 </div>
                              </div>
                              <form method="get" class="search-form">
                                 <div class="input-group">
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Search by name, lastname, email, or phone" value="<?php echo htmlentities($search); ?>">
                                    <div class="input-group-append">
                                          <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                 </div>
                              </form>

                              <div class="full price_table padding_infor_info">
                                 <div class="row">
                                    <div class="col-lg-12">
                                       <div class="table-responsive-sm">
                                          <table class="table table-striped projects">
                                             <thead class="thead-dark">
                                                <tr>
                                                   <th style="width: 2%">No</th>
                                                   <th style="width: 30%">Name</th>
                                                   <th>LastName</th>
                                                   <th>Email</th>
                                                   <th>Phone</th>
                                                   <th>Photo</th>
                                                   <th>Saving Account No</th>
                                                   <th>Current Account No</th>
                                                   <th>Loan Balance</th>
                                                   <th>Saving Balance</th>
                                                   <th>Current Balance</th>
                                                   <th>Suspended</th>
                                                   <th>Status</th>
                                                   <th>Delete</th>
                                                   <th>Credit Account</th>
                                                   <th>Debit Account</th>
                                                   <th>Edit</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                             <?php $i = 1; ?>
                                                <?php foreach ($currentPageRows as $row): ?>

                                                <tr>
                                                <td><?php echo $i++; ?></td>
                                                   <td><?php echo $row->name; ?></td>
                                                   <td><?php echo $row->lastname; ?></td>
                                                   <td><?php echo $row->email; ?></td>
                                                   <td><?php echo $row->phone; ?></td>
                                                   <td>
                                                      <ul class="list-inline">
                                                         <li>
                                                            <img width="40" src="<?php echo $row->image; ?>" class="rounded-circle" alt="#">
                                                         </li>
                                                      </ul>
                                                   </td>
                                                   <td><?php echo $row->saving;?></td>
                                                   <td><?php echo $row->current;?></td>
                                                   <td><?php echo $row->loan_balance;?></td>
                                                   <td>$<?php echo $row->saving_balance; ?></td>
                                                   <td>$<?php echo $row->current_balance; ?></td>

                                                   <td>
                                                   <?php
                                                   $userId = $row->user_unique_id;
                                                   $status = ($row->status == 'suspended') ? 'active' : 'suspended';
                                                   ?>
                                                      <form action="../action/main_work.php?option=<?php echo $status; ?>" method="post">
                                                      <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                                                      <input type="hidden" name="status" value="<?php echo $status; ?>">
                                                      <button class="btn btn-secondary" data-toggle="tooltip" data-placement="top"  type="submit">
                                                         <?php echo ucfirst($status); ?>
                                                      </button>
                                                   </form>
                                                   </td>

                                                   <td>
                                                   <?php
                                                   $userId = $row->user_unique_id;
                                                   $status = ($row->status == 'pending') ? 'confirmed' : 'pending';
                                                   ?>
                                                   <form action="../action/main_work.php?option=<?php echo $status; ?>" method="post">
                                                      <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                                                      <input type="hidden" name="status" value="<?php echo $status; ?>">
                                                      <button class="btn btn-primary toggle-status" data-toggle="tooltip" data-placement="top" title="Toggle Status" type="submit">
                                                         <?php echo ucfirst($status); ?>
                                                      </button>
                                                   </form>
                                                   </td>

                                                   <td>
                                                      <form method="post" action="../action/main_work.php?option=delete">
                                                         <input type="hidden" name="user_id" value="<?php echo $row->user_unique_id; ?>">
                                                         <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="left" title="Delete">Delete</button>
                                                      </form>
                                                   </td>

                                                   <td><a class="btn btn-success" href="add.php?user=<?php echo $row->user_unique_id; ?>" data-toggle="tooltip" data-placement="left" title="Left">Add Money</a></td>

                                                   <td><a class="btn btn-warning " href="remove.php?user=<?php echo $row->user_unique_id; ?>" data-toggle="tooltip" data-placement="left" title="Left">Remove Money</a></td>

                                                   <td><a class="btn btn-success" href="edit.php?user=<?php echo $row->user_unique_id; ?>" data-toggle="tooltip" data-placement="left" title="Left">Edit</a></td>

                                                </tr>
                                                <?php endforeach; ?>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- Pagination links -->
                            <div class="pagination">
                                <?php for ($page = 1; $page <= $totalPages; $page++): ?>
                                    <a href="?page=<?php echo $page; ?>"<?php if ($page == $currentPage) echo ' class="active"'; ?>><?php echo $page; ?></a>
                                <?php endfor; ?>
                            </div>
                           </div>
                        </div>
                        <!-- end row -->
                     </div>



 

<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Your custom JavaScript code -->
<script>
$(document).ready(function() {
    $('.toggle-status').click(function() {
        var button = $(this);
        var userId = button.data('order-id');
        console.log('userId:', userId);

        $.ajax({
            url: 'toggle_status.php',
            type: 'POST',
            data: { userId: userId },
            success: function(response) {
                console.log('Response:', response);
                try {
                    var responseData = JSON.parse(response);
                    if (responseData.newStatus) {
                        console.log('New status:', responseData.newStatus);
                        button.text(responseData.newStatus);
                    } else {
                        console.error('Invalid response format:', response);
                    }
                } catch (error) {
                    console.error('Error parsing response:', error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating status:', error);
                // Handle error response as needed
            }
        });
    });
});
</script>





<?php require('footer.php')?>