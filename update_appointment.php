<?php
require_once 'config.php';
header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = intval($_POST['appointment_id']);
    $appointment_date = sanitize_input($_POST['appointment_date']);
    $mechanic_id = intval($_POST['mechanic_id']);
    $status = sanitize_input($_POST['status']);

    // Validate inputs
    if ($appointment_id <= 0 || $mechanic_id <= 0) {
        $response['message'] = "Invalid appointment or mechanic ID.";
        echo json_encode($response);
        exit;
    }

    // Get current appointment details
    $query = "SELECT * FROM appointments WHERE appointment_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $current_appointment = $result->fetch_assoc();

    if (!$current_appointment) {
        $response['message'] = "Appointment not found.";
        echo json_encode($response);
        exit;
    }

    // Check if date or mechanic changed
    $date_changed = ($appointment_date != $current_appointment['appointment_date']);
    $mechanic_changed = ($mechanic_id != $current_appointment['mechanic_id']);

    // If date or mechanic changed, check availability
    if ($date_changed || $mechanic_changed) {
        // Check if the new mechanic has available slots on the new date
        // We need to exclude the current appointment from the count
        $query = "SELECT COUNT(*) as count FROM appointments 
                  WHERE mechanic_id = ? AND appointment_date = ? 
                  AND status != 'cancelled' AND appointment_id != ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isi", $mechanic_id, $appointment_date, $appointment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $used_slots = $row['count'];
        
        if ($used_slots >= 4) {
            $response['message'] = "The selected mechanic is fully booked on this date. Please choose a different mechanic or date.";
            echo json_encode($response);
            exit;
        }

        // Check if client already has another appointment on the new date
        if ($date_changed) {
            $query = "SELECT * FROM appointments 
                      WHERE client_phone = ? AND appointment_date = ? 
                      AND status != 'cancelled' AND appointment_id != ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $current_appointment['client_phone'], $appointment_date, $appointment_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $response['message'] = "This client already has an appointment on the selected date.";
                echo json_encode($response);
                exit;
            }
        }
    }

    // Update appointment
    $query = "UPDATE appointments 
              SET appointment_date = ?, mechanic_id = ?, status = ?
              WHERE appointment_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sisi", $appointment_date, $mechanic_id, $status, $appointment_id);
    
    if ($stmt->execute()) {
        // Get updated appointment details with mechanic name
        $query = "SELECT a.*, m.mechanic_name 
                  FROM appointments a 
                  JOIN mechanics m ON a.mechanic_id = m.mechanic_id 
                  WHERE a.appointment_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $updated_appointment = $result->fetch_assoc();
        
        $response['success'] = true;
        $response['message'] = "Appointment updated successfully!";
        $response['appointment'] = $updated_appointment;
    } else {
        $response['message'] = "Error updating appointment. Please try again.";
    }

    $stmt->close();
} else {
    $response['message'] = "Invalid request method.";
}

$conn->close();
echo json_encode($response);
?>
