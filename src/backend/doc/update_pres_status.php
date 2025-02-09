<?php
session_start();
include('assets/inc/config.php');
include('assets/inc/checklogin.php');
check_login();

if(isset($_GET['pres_id']) && isset($_GET['status'])) {
    $pres_id = $_GET['pres_id'];
    $status = $_GET['status'];
    
    $query = "UPDATE his_prescriptions SET pres_status = ? WHERE pres_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('si', $status, $pres_id);
    
    if($stmt->execute()) {
        header("Location: pharma_view_presc.php?success=Status updated");
    } else {
        header("Location: pharma_view_presc.php?error=Update failed");
    }
} else {
    header("Location: pharma_view_presc.php");
}
?>