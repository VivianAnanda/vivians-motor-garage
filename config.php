<?php
// Database configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'car_workshop');

// Create connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8");

// Function to sanitize input
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

// Function to get available slots for a mechanic on a specific date
function get_available_slots($mechanic_id, $date) {
    global $conn;
    $query = "SELECT COUNT(*) as count FROM appointments 
              WHERE mechanic_id = ? AND appointment_date = ? 
              AND status != 'cancelled'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $mechanic_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $used_slots = $row['count'];
    return 4 - $used_slots; // Max 4 appointments per mechanic per day
}

// Function to check if client has appointment on a specific date
function check_client_appointment($phone, $date) {
    global $conn;
    $query = "SELECT * FROM appointments 
              WHERE client_phone = ? AND appointment_date = ? 
              AND status != 'cancelled'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $phone, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Function to get all mechanics with available slots for a date
function get_mechanics_availability($date) {
    global $conn;
    $query = "SELECT * FROM mechanics ORDER BY mechanic_name";
    $result = $conn->query($query);
    $mechanics = array();
    
    while ($row = $result->fetch_assoc()) {
        $row['available_slots'] = get_available_slots($row['mechanic_id'], $date);
        $mechanics[] = $row;
    }
    
    return $mechanics;
}
?>
