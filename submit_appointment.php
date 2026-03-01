<?php
require_once 'config.php';
header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $client_name = sanitize_input($_POST['client_name']);
    $client_address = sanitize_input($_POST['client_address']);
    $client_phone = sanitize_input($_POST['client_phone']);
    $car_license_number = sanitize_input($_POST['car_license_number']);
    $car_engine_number = sanitize_input($_POST['car_engine_number']);
    $appointment_date = sanitize_input($_POST['appointment_date']);
    $mechanic_id = intval($_POST['mechanic_id']);

    // Server-side validation
    $errors = array();

    // Validate name (only letters and spaces)
    if (!preg_match("/^[a-zA-Z\s]+$/", $client_name)) {
        $errors[] = "Name should contain only letters and spaces.";
    }

    // Validate phone (only numbers, 10-15 digits)
    if (!preg_match("/^[0-9]{10,15}$/", $client_phone)) {
        $errors[] = "Phone number should contain only numbers (10-15 digits).";
    }

    // Validate car engine number (alphanumeric)
    if (!preg_match("/^[a-zA-Z0-9]+$/", $car_engine_number)) {
        $errors[] = "Car engine number should be alphanumeric.";
    }

    // Validate date (not in the past)
    $today = date('Y-m-d');
    if ($appointment_date < $today) {
        $errors[] = "Appointment date cannot be in the past.";
    }

    // Validate mechanic selection
    if ($mechanic_id <= 0) {
        $errors[] = "Please select a mechanic.";
    }

    // Check if there are validation errors
    if (!empty($errors)) {
        $response['message'] = implode("<br>", $errors);
        echo json_encode($response);
        exit;
    }

    // Check if client already has an appointment on this date
    if (check_client_appointment($client_phone, $appointment_date)) {
        $response['message'] = "You already have an appointment scheduled on " . date('F j, Y', strtotime($appointment_date)) . ". Please choose a different date.";
        echo json_encode($response);
        exit;
    }

    // Check if mechanic has available slots
    $available_slots = get_available_slots($mechanic_id, $appointment_date);
    if ($available_slots <= 0) {
        $response['message'] = "Sorry, the selected mechanic is fully booked on this date. Please choose a different mechanic or date.";
        echo json_encode($response);
        exit;
    }

    // Insert appointment into database
    $query = "INSERT INTO appointments (client_name, client_address, client_phone, 
              car_license_number, car_engine_number, appointment_date, mechanic_id, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, 'confirmed')";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $client_name, $client_address, $client_phone, 
                      $car_license_number, $car_engine_number, $appointment_date, $mechanic_id);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Appointment successfully booked! Your appointment ID is " . $stmt->insert_id . ".";
        $response['appointment_id'] = $stmt->insert_id;
    } else {
        $response['message'] = "Error booking appointment. Please try again.";
    }

    $stmt->close();
} else {
    $response['message'] = "Invalid request method.";
}

$conn->close();
echo json_encode($response);
?>
