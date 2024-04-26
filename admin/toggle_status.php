<?php
require ('../action/main_work.php');

if (isset($_POST['status'])) {
    $currentStatus = $_POST['status'];
    $response = toggleStatus($currentStatus);
      print_r("ghjkl");die();
    echo json_encode($response);
} else {
    echo json_encode(array('error' => 'Status not provided'));
}
?>
