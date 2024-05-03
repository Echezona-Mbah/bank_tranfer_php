<?php
require ('../action/main_work.php');

$UserDetails = $for->AdminWallect();



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
                              <h2>User Transfer</h2>
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
                                                   <th>bitcoin</th>
                                                   <th>etheurem</th>
                                                   <th>action</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                             <?php $i = 1; ?>
                                                <?php foreach ($currentPageRows as $row): ?>

                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $row->bitcoin; ?></td>
                                                    <td><?php echo $row->etheurem; ?></td>

                                                    <td><a class="btn btn-success" href="currencyUpdate.php?id=<?php echo $row->id; ?>" data-toggle="tooltip" data-placement="left" title="Left">Edit</a></td>


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