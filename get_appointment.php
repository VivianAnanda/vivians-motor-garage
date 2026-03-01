<?php
require_once 'config.php';
header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');

if (isset($_GET['id'])) {
    $appointment_id = intval($_GET['id']);
    
    $query = "SELECT a.*, m.mechanic_name, m.specialization 
              FROM appointments a 
              JOIN mechanics m ON a.mechanic_id = m.mechanic_id 
              WHERE a.appointment_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($appointment = $result->fetch_assoc()) {
        $response['success'] = true;
        $response['appointment'] = $appointment;
    } else {
        $response['message'] = "Appointment not found.";
    }
    
    $stmt->close();
} else {
    $response['message'] = "Missing appointment ID.";
}

$conn->close();
echo json_encode($response);
?>
