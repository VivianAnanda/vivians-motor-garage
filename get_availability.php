<?php
require_once 'config.php';
header('Content-Type: application/json');

$response = array();

if (isset($_GET['mechanic_id']) && isset($_GET['date'])) {
    $mechanic_id = intval($_GET['mechanic_id']);
    $date = sanitize_input($_GET['date']);
    
    // Get mechanic details
    $query = "SELECT * FROM mechanics WHERE mechanic_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $mechanic_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($mechanic = $result->fetch_assoc()) {
        $available_slots = get_available_slots($mechanic_id, $date);
        
        $response['success'] = true;
        $response['mechanic'] = $mechanic['mechanic_name'];
        $response['available_slots'] = $available_slots;
        $response['is_available'] = $available_slots > 0;
    } else {
        $response['success'] = false;
        $response['message'] = "Mechanic not found.";
    }
} elseif (isset($_GET['date'])) {
    // Get all mechanics with availability for the date
    $date = sanitize_input($_GET['date']);
    $mechanics = get_mechanics_availability($date);
    
    $response['success'] = true;
    $response['mechanics'] = $mechanics;
} else {
    $response['success'] = false;
    $response['message'] = "Missing parameters.";
}

echo json_encode($response);
$conn->close();
?>
