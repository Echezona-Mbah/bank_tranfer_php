                  <!-- footer -->
                  <div class="container-fluid">
                     <div class="footer">
                        <p>Copyright © 2018 Designed by html.design. All rights reserved.<br><br>
                           Distributed By: <a href="https://themewagon.com/">ThemeWagon</a>
                        </p>
                     </div>
                  </div>
               </div>
               <!-- end dashboard inner -->
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
	 echo "  timer: 4000";
	 echo "});";
	 echo "</script>";
   }





 ?>











      <!-- jQuery -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <!-- wow animation -->
      <script src="js/animate.js"></script>
      <!-- select country -->
      <script src="js/bootstrap-select.js"></script>
      <!-- owl carousel -->
      <script src="js/owl.carousel.js"></script> 
      <!-- chart js -->
      <script src="js/Chart.min.js"></script>
      <script src="js/Chart.bundle.min.js"></script>
      <script src="js/utils.js"></script>
      <script src="js/analyser.js"></script>
      <!-- nice scrollbar -->
      <script src="js/perfect-scrollbar.min.js"></script>
      <script>
         var ps = new PerfectScrollbar('#sidebar');
      </script>
      <!-- custom js -->
      <script src="js/chart_custom_style1.js"></script>
      <script src="js/custom.js"></script>
   </body>

<!-- Mirrored from themewagon.github.io/pluto/dashboard.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 24 Apr 2024 13:10:41 GMT -->
</html>