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
<style>
    .profile-upload {
    margin-top: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.upload-label {
    font-weight: bold;
}

.upload-input {
    margin-top: 5px;
    margin-bottom: 10px;
}

.upload-btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
}

.upload-btn:hover {
    background-color: #0056b3;
}

</style>

<?php require('sidebar.php') ?>


<div class="mobile-menu-overlay"></div>

<div class="main-container">


<div class="pd-ltr-20 xs-pd-20-10">
<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="title">
								<h4>Profile</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Profile</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
                        <div class="pd-20 card-box height-100-p">
                            <div class="profile-photo">
                                <a href="modal.html" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="fa fa-pencil"></i></a>
                                <img src="<?php echo ucwords($userDetail->image) ?>" alt="" class="avatar-photo">
                                <!-- <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body pd-5">
                                                <div class="img-container">
                                                    <img id="image" src="vendors/images/photo2.jpg" alt="Picture">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" value="Update" class="btn btn-primary">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        
							<h5 class="text-center h5 mb-0"><?php echo ucwords($userDetail->name) ?></h5>
							<p class="text-center text-muted font-14"><?php echo ucwords($userDetail->lastname) ?></p>
							<div class="profile-info">
								<h5 class="mb-20 h5 text-blue">Contact Information</h5>
								<ul>
									<li>
										<span>Email Address:</span>
										<?php echo ucwords($userDetail->email) ?>
									</li>
									<li>
										<span>Phone Number:</span>
										<?php echo ucwords($userDetail->phone) ?>
									</li>
                                    <li>
                                        <span>Joined Date:</span>
                                        <?php echo date('Y-m-d H:i:s', strtotime($userDetail->created_at)); ?>
                                    </li>
                                    <li class="profile-upload">
                                    <form class="dropzone"action="../action/main_work.php?option=profile" method=post enctype="multipart/form-data" id="my-awesome-dropzone">
                                        <div class="fallback">
                                            <input type="file" name="image" id="fileInput" accept="image/*" onchange="previewImage(event)" />
                                        </div>
                                        <div id="imagePreview" style="display: none; display: flex; justify-content: center; align-items: center;">
                                            <img id="preview" src="#" alt="" style="max-width: 100%; max-height: 200px;" />
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Upload Picture</button>
                                        </div>
                                    </form>
                                    </li>
								</ul>
							</div>

                           
						</div>
					</div>
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
						<div class="card-box height-100-p overflow-hidden">
							<div class="profile-tab height-100-p">
								<div class="tab height-100-p">
									<ul class="nav nav-tabs customtab" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-toggle="tab" href="#timeline" role="tab">Timeline</a>
										</li>
									</ul>
									<div class="tab-content">
										<!-- Timeline Tab start -->
										<div class="tab-pane fade show active" id="timeline" role="tabpanel">
											<div class="pd-20">
												<div class="profile-timeline">
													<div class="timeline-month">
														<h5>August, 2020</h5>
													</div>

													<div class="timeline-month">
														<h5>July, 2020</h5>
													</div>
													<div class="profile-timeline-list">
														<ul>
															<li>
																<div class="date">12 July</div>
																<div class="task-name"><i class="ion-android-alarm-clock"></i> Task Added</div>
																<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
																<div class="task-time">09:30 am</div>
															</li>
															<li>
																<div class="date">10 July</div>
																<div class="task-name"><i class="ion-ios-chatboxes"></i> Task Added</div>
																<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
																<div class="task-time">09:30 am</div>
															</li>
														</ul>
													</div>

												</div>
											</div>
										</div>
										<!-- Timeline Tab End -->

									</div>
								</div>
							</div>
						</div>
					</div>
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