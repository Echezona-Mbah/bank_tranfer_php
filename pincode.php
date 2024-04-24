<?php
session_start();
if (!isset($_SESSION['user_unique_id'])) {
    header("Location: login.php");
    exit;
}

// Your index.php code goes here
// This code will only be executed if the user is logged in
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pincode Form</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
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
    .input-group-prepend .input-group-text {
      background-color: #007bff;
      color: #fff;
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #0056b3;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="form-container">
          <h2 class="text-center mb-4">Pincode</h2>

          <!-- Display the user's name -->
          <h3 class="text-center mb-3">Welcome, <?php echo $_SESSION['name']; ?></h3>

          <!-- Pincode form -->
          <form action="action/main_work.php?option=pincode" method="post">
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="text" class="form-control" id="pincode" maxlength="6" name="pincode" placeholder="Enter 6 Digit Pincode" required>
              </div>
            </div>

            <input type="hidden" name="userId" value="<?php echo $_SESSION['user_unique_id']; ?>" />

            <button type="submit" class="btn btn-primary btn-block">Unlock</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>

<!-- Font Awesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<!-- SweetAlert JS -->
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

</html>
