<?php
require ('../action/main_work.php');
if (!isset($_SESSION['user_unique_id'])) {
    header("Location: ../login.php");
    exit;
}
$userDetail = $for->getLoggedInUser();

?>

<?php require('head.php')?>


<?php require('header.php') ?>

<?php require('sidebar.php') ?>


<div class="mobile-menu-overlay"></div>

<div class="main-container">


<div class="pd-ltr-20 xs-pd-20-10">

				<!-- Select-2 Start -->
				<div class="pd-20 card-box mb-30">
					<div class="clearfix">
						<div class="pull-left">
							<h4 class="text-blue h4">MORE INFORMATIONS NEEDED</h4>
							<!-- <p class="mb-30">Select2 for custom search and select</p> -->
						</div>
					</div>
                    <form action="../action/main_work.php?option=kyc" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="single-select">ID Front</label>
                                    <input type="file"  class="form-control"name="id_front" id="id_front" accept="image/*" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="multiple-select">ID Back</label>
                                    <input type="file" class="form-control" name="id_back" id="id_back" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="single-select">Proof of Address</label>
                                    <input type="file" class="form-control" name="proof_address" id="proof_address" accept="image/*">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="single-select">ID Number</label>
									<input id="demo1" class="form-control" type="text" name="idnumber">
								</div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>

				</div>
				<!-- Select-2 end -->




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