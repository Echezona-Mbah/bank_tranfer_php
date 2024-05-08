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

.title h4 {
      font-size: 24px; /* Adjust the font size as needed */
      color: #007bff; /* Adjust the color as needed */
    }
    .file-upload-btn {
      cursor: pointer;
      display: block;
      margin: 0 auto;
      width: 200px; /* Adjust the width of the box */
      height: 200px; /* Adjust the height of the box */
      border: 2px dashed #007bff; /* Add a dashed border */
      border-radius: 10px; /* Adjust the border radius for rounded corners */
      padding: 20px; /* Add padding inside the box */
      text-align: center;
      box-sizing: border-box; /* Include padding and border in the box dimensions */
      position: relative; /* Make position relative for absolute positioning of the image */
    }
    .file-upload-btn img {
      position: absolute; /* Position the image absolutely */
      top: 0; /* Position at the top */
      left: 0; /* Position at the left */
      width: 100%; /* Fill the entire width of the button */
      height: 100%; /* Fill the entire height of the button */
      object-fit: cover; /* Maintain aspect ratio and cover the button area */
      border-radius: 8px; /* Match the button's border radius */
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

                <form class="dropzone" action="../action/main_work.php?option=check" method="post" enctype="multipart/form-data" id="my-awesome-dropzone">
                    <!-- Hidden file input -->
                    <div class="fallback">
                        <input type="file" name="image" id="fileInput" accept="image/*" onchange="previewImage(event)" />
                    </div>
                    <label for="fileInput" class="file-upload-btn">
                        <img id="preview" src="#" alt="Upload">
                    </label>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Deposit Cheque</button>
                    </div>
                </form> 
                </div>

		</div>


        <script>
    function previewImage(event) {
      const img = document.getElementById('preview');
      img.src = URL.createObjectURL(event.target.files[0]);
    }
  </script>


<?php require('footer.php') ?>