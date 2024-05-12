<div class="footer-wrap pd-20 mb-20 card-box">
<a href="https://coastchartered.com" target="_blank">Coastchartered Bank..© 2024 Bank of America Corporation. All rights reserved.</a>
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
	 echo "  timer: 4500";
	 echo "});";
	 echo "</script>";
   }





 ?>



	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
	<script src="src/plugins/apexcharts/apexcharts.min.js"></script>
	<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
	<script src="vendors/scripts/dashboard.js"></script>
</body>

<!-- Mirrored from themewagon.github.io/deskapp2/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 05 Apr 2024 23:16:28 GMT -->
</html>