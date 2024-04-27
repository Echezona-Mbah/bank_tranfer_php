<?php
// Include main_work.php to access toggleStatus method
require('../action/main_work.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming the initial status is 'pending'
    $currentStatus = 'pending';
    
    // Toggle the status using the toggleStatus method
    $result = $for->toggleStatus($currentStatus);
    
    // Return the updated status or error message as JSON response
    if (isset($result['newStatus'])) {
        echo json_encode(array('newStatus' => $result['newStatus']));
    } elseif (isset($result['error'])) {
        echo json_encode(array('error' => $result['error']));
    } else {
        echo json_encode(array('error' => 'Unexpected error occurred.'));
    }
} else {
    // Return error response if the request method is not POST
    echo json_encode(array('error' => 'Invalid request method'));
}
?>



