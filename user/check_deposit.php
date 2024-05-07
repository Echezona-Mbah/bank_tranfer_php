<?php
require ('../action/main_work.php');
if (!isset($_SESSION['user_unique_id'])) {
    header("Location: ../login.php");
    exit;
}
$user = $for->getsingledetail(($_SESSION['user_unique_id']));

?>

<?php require('head.php') ?>


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
								<h4>Mobile Check Deposit</h4>
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

                <div class="pd-40 card-box mb-30">
                    <div class="clearfix mb-30">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Please upload your cheque deposit below</h4>
                        </div>
                    </div>
                    <form class="dropzone"action="../action/main_work.php?option=check" method=post enctype="multipart/form-data" id="my-awesome-dropzone">
                        <div class="fallback">
                            <input type="file" name="image" id="fileInput" accept="image/*" onchange="previewImage(event)" />
                        </div>
                        <div id="imagePreview" style="display: none; display: flex; justify-content: center; align-items: center;">
                            <img id="preview" src="#" alt="" style="max-width: 100%; max-height: 200px;" />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Deposit Cheque</button>
                        </div>
                    </form>
                </div>

		</div>


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