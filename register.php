<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<!-- Site favicon -->
     <link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-119386393-1');
	</script>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
    }
    .form-container {
      max-width: 400px;
      margin: 50px auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
    
  
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="form-container">
          <h2 class="text-center mb-4">Register</h2>

          <form action="action/main_work.php?option=register"  method="post">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control" id="fullName" name="name" placeholder="Full Name" value="<?php if (isset($_SESSION{'name'})) {echo $_SESSION['name'];}?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" value="<?php if (isset($_SESSION{'lastname'})) {echo $_SESSION['lastname'];}?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="<?php if (isset($_SESSION{'email'})) {echo $_SESSION['email'];}?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                </div>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" value="<?php if (isset($_SESSION{'phone'})) {echo $_SESSION['phone'];}?>">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="text" class="form-control" id="pincode"  maxlength="6" name="pincode" placeholder="6 Digit Pincode">
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>

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

<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
</html>
