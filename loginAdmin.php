<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
   
<!-- Mirrored from themewagon.github.io/pluto/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 24 Apr 2024 13:11:05 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Pluto - Responsive Bootstrap Admin Panel Templates</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- site icon -->
      <link rel="icon" href="admin/images/fevicon.html" type="image/png" />
      <!-- bootstrap css -->
      <link rel="stylesheet" href="admin/css/bootstrap.min.css" />
      <!-- site css -->
      <link rel="stylesheet" href="admin/style.css" />
      <!-- responsive css -->
      <link rel="stylesheet" href="admin/css/responsive.css" />
      <!-- color css -->
      <link rel="stylesheet" href="admin/css/colors.html" />
      <!-- select bootstrap -->
      <link rel="stylesheet" href="css/bootstrap-select.css" />
      <!-- scrollbar css -->
      <link rel="stylesheet" href="admin/css/perfect-scrollbar.css" />
      <!-- custom css -->
      <link rel="stylesheet" href="admin/css/custom.css" />
      <!-- calendar file css -->
      <link rel="stylesheet" href="admin/js/semantic.min.html" />


      <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


   </head>
   <body class="inner_page login">
      <div class="full_container">
         <div class="container">
            <div class="center verticle_center full_height">
               <div class="login_section">
                  <div class="logo_login">
                     <div class="center">
                        <img width="210" src="admin/images/logo/logo.png" alt="#" />
                     </div>
                  </div>
                  <div class="login_form">
                     <form action="action/main_work.php?option=loginAdmin" method=post>
                        <fieldset>
                           <div class="field">
                              <label class="label_field">Email Address</label>
                              <input type="email" name="email" placeholder="E-mail" value="<?php if (isset($_SESSION{'email'})) {echo $_SESSION['email'];}?>" />
                           </div>
                           <div class="field">
                              <label class="label_field">Password</label>
                              <input type="password" name="password" placeholder="Password" value="<?php if (isset($_SESSION{'Password'})) {echo $_SESSION['Password'];}?>" />
                           </div>
                           <div class="field">
                              <label class="label_field hidden">hidden label</label>
                              <label class="form-check-label"><input type="checkbox" class="form-check-input"> Remember Me</label>
                              <!-- <a class="forgot" href="#">Forgotten Password?</a> -->
                           </div>
                           <div class="field margin_0">
                              <label class="label_field hidden">hidden label</label>
                              <button class="main_bt" >Login</button>
                           </div>
                        </fieldset>
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






      <!-- jQuery -->
      <script src="admin/js/jquery.min.js"></script>
      <script src="admin/js/popper.min.js"></script>
      <script src="admin/js/bootstrap.min.js"></script>
      <!-- wow animation -->
      <script src="admin/js/animate.js"></script>
      <!-- select country -->
      <script src="admin/js/bootstrap-select.js"></script>
      <!-- nice scrollbar -->
      <script src="admin/js/perfect-scrollbar.min.js"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- custom js -->
      <script src="admin/js/custom.js"></script>
   </body>

<!-- Mirrored from themewagon.github.io/pluto/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 24 Apr 2024 13:11:05 GMT -->
</html>

