<?php
require ('../action/main_work.php');
if (!isset($_SESSION['user_unique_id'])) {
    header("Location: ../login.php");
    exit;
}
$user = $for->getsingledetail(($_SESSION['user_unique_id']));

?>

<?php require('head.php') ?>

<style>

    .title {
      text-align: center;
    }
    .title h4 {
      font-size: 32px; /* Adjust the font size as needed */
      color: #333; /* Adjust the color as needed */
    }
    .file-upload-btn {
      cursor: pointer;
      display: inline-block;
      padding: 20px; /* Increase the padding to make it bigger */
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 10px; /* Adjust the border radius for rounded corners */
      transition: background-color 0.3s;
      text-align: center;
      width: 100%;
    }
    .file-upload-btn:hover {
      background-color: #0056b3;
    }
    #fileInput {
      display: none;
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

                <div class="pd-40 card-box mb-30" >
                    <div class="clearfix mb-30">
                        <div class="pull-left">
                            <h4 class="text-blue h4">Please upload your cheque deposit below</h4>
                        </div>
                    </div>
                    <label for="fileInput" class="file-upload-btn">Click here to upload</label>
    <form class="dropzone" action="../action/main_work.php?option=check" method="post" enctype="multipart/form-data" id="my-awesome-dropzone">
      <!-- Hidden file input -->
      <div class="fallback">
        <input type="file" name="image" id="fileInput" accept="image/*" onchange="previewImage(event)" />
      </div>
      <div id="imagePreview" style="display: none;">
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
<script>
    // Function to trigger file input when label is clicked
    document.querySelector('.file-upload-btn').addEventListener('click', function() {
      document.getElementById('fileInput').click();
    });

    function previewImage(event) {
      const preview = document.getElementById('imagePreview');
      const img = document.getElementById('preview');
      img.src = URL.createObjectURL(event.target.files[0]);
      preview.style.display = 'flex';
    }
  </script>


<?php require('footer.php') ?>