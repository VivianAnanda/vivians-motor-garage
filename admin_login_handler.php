<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get and sanitize input
$email = sanitize_input($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Validate input
if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Please provide both email and password']);
    exit;
}

// Check credentials
$stmt = $conn->prepare("SELECT admin_id, username, password FROM admin_users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    exit;
}

$admin = $result->fetch_assoc();

// Verify password
if (password_verify($password, $admin['password'])) {
    // Set session variables
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_id'] = $admin['admin_id'];
    $_SESSION['admin_username'] = $admin['username'];
    $_SESSION['login_time'] = time();
    
    echo json_encode([
        'success' => true, 
        'message' => 'Login successful',
        'username' => $admin['username']
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
}

$stmt->close();
$conn->close();
?>
