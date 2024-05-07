<?php session_start()?>
<!DOCTYPE html>
<html>

<!-- Mirrored from themewagon.github.io/deskapp2/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 05 Apr 2024 23:16:44 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>Coastchartered</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="user/vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="user/vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="user/vendors/images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="user/vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="user/vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="user/vendors/styles/style.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'UA-119386393-1');
	</script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


</head>
<body class="login-page">
	<div class="login-header box-shadow">
		<div class="container-fluid d-flex justify-content-between align-items-center">
			<div class="brand-logo">
				<a href="login.html">
					<img src="user/uploads/ffff.jpg" alt="">
				</a>
			</div>
			<div class="login-menu">
				<ul>
					<li><a href="register.php">Register</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-md-6 col-lg-7">
					<img src="user/vendors/images/login-page-img.png" alt="">
				</div>
				<div class="col-md-6 col-lg-5">
					<div class="login-box bg-white box-shadow border-radius-10">
						<div class="login-title">
							<h2 class="text-center text-primary">New Password <br> </h2>
						</div>
						<form  action="action/main_work.php?option=resetpassword" method=post>


                        <input type="hidden" name="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">


							<div class="input-group custom">
								<input type="password" class="form-control form-control-lg" placeholder="New Password" name="newpassword" value="">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
								</div>
							</div>

                            <div class="input-group custom">
								<input type="password" class="form-control form-control-lg" placeholder="Confirm New Password" name="confirmpassword" value="">
								<div class="input-group-append custom">
									<span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
								</div>
							</div>


							<div class="row">
								<div class="col-sm-12">
									<div class="input-group mb-0">
										
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
										
										<!-- <a class="btn btn-primary btn-lg btn-block" >Sign In</a> -->
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

 <?php

    if(isset($_SESSION['formError'])){
      echo "<script>";
      echo "Swal.fire({";
      echo "  icon: 'error',";
      echo "  title: 'Oops...',";
      echo "  html: '";

      foreach($_SESSION['formError'] as $eachErrorArray){
        foreach($eachErrorArray as $eachError){
          echo $eachError."<br>";
        }
      }

      echo "'});";
      echo "</script>";

      unset($_SESSION['formError']);
    }

    if(isset($_GET['success'])){
      echo "<script>";
      echo "Swal.fire({";
      echo "  icon: 'success',";
      echo "  title: 'Success',";
      echo "  text: '".htmlspecialchars($_GET['success'], ENT_QUOTES)."',";
      echo "  showConfirmButton: false,";
      echo "  timer: 3000";
      echo "});";
      echo "</script>";
    }
  ?>



	<!-- js -->
	<script src="user/vendors/scripts/core.js"></script>
	<script src="user/vendors/scripts/script.min.js"></script>
	<script src="user/vendors/scripts/process.js"></script>
	<script src="user/vendors/scripts/layout-settings.js"></script>
</body>

<!-- Mirrored from themewagon.github.io/deskapp2/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 05 Apr 2024 23:16:46 GMT -->
</html>