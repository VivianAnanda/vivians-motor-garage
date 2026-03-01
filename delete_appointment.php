<?php
require_once 'config.php';
header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = intval($_POST['appointment_id']);

    if ($appointment_id <= 0) {
        $response['message'] = "Invalid appointment ID.";
        echo json_encode($response);
        exit;
    }

    // Update status to cancelled instead of deleting (better for record keeping)
    $query = "UPDATE appointments SET status = 'cancelled' WHERE appointment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $appointment_id);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Appointment cancelled successfully!";
    } else {
        $response['message'] = "Error cancelling appointment. Please try again.";
    }

    $stmt->close();
} else {
    $response['message'] = "Invalid request method.";
}

$conn->close();
echo json_encode($response);
?>
