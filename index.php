<?php
require_once 'config.php';

// Get today's date for minimum date validation
$today = date('Y-m-d');

// Get mechanics for dropdown
$mechanics_query = "SELECT * FROM mechanics ORDER BY mechanic_name";
$mechanics_result = $conn->query($mechanics_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Workshop - Appointment System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Vivian's Motor Garage</h1>
            <p class="tagline">Book Your Appointment with Expert Mechanics</p>
        </header>

        <div class="main-content">
            <!-- Appointment Form -->
            <div class="form-container">
                <h2>Book an Appointment</h2>
                <div id="message"></div>
                
                <form id="appointmentForm" method="POST" action="submit_appointment.php">
                    <div class="form-group">
                        <label for="client_name">Full Name *</label>
                        <input type="text" id="client_name" name="client_name" required>
                        <span class="error" id="name_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="client_address">Address *</label>
                        <textarea id="client_address" name="client_address" rows="3" required></textarea>
                        <span class="error" id="address_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="client_phone">Phone Number *</label>
                        <input type="text" id="client_phone" name="client_phone" 
                               placeholder="e.g., 01712345678" required>
                        <span class="error" id="phone_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="car_license_number">Car License Number *</label>
                        <input type="text" id="car_license_number" name="car_license_number" 
                               placeholder="e.g., DHK-METRO-11-1234" required>
                        <span class="error" id="license_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="car_engine_number">Car Engine Number *</label>
                        <input type="text" id="car_engine_number" name="car_engine_number" 
                               placeholder="e.g., 1234567890" required>
                        <span class="error" id="engine_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="appointment_date">Appointment Date *</label>
                        <input type="date" id="appointment_date" name="appointment_date" 
                               min="<?php echo $today; ?>" required>
                        <span class="error" id="date_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="mechanic_id">Select Mechanic *</label>
                        <select id="mechanic_id" name="mechanic_id" required>
                            <option value="">-- Choose a Mechanic --</option>
                            <?php while ($mechanic = $mechanics_result->fetch_assoc()): ?>
                                <option value="<?php echo $mechanic['mechanic_id']; ?>">
                                    <?php echo htmlspecialchars($mechanic['mechanic_name']); ?> 
                                    - <?php echo htmlspecialchars($mechanic['specialization']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <span class="error" id="mechanic_error"></span>
                        <div id="availability_info" class="info-box"></div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" id="submitBtn" class="btn btn-primary">
                            Book Appointment
                        </button>
                        <button type="reset" class="btn btn-secondary">Clear Form</button>
                    </div>
                </form>
            </div>

            <!-- Information Panel -->
            <div class="info-panel">
                <h3>📋 Important Information</h3>
                <ul>
                    <li>Each mechanic can handle up to 4 cars per day</li>
                    <li>Select your preferred date and mechanic</li>
                    <li>Available slots will be shown after selection</li>
                    <li>You can only book one appointment per day</li>
                    <li>Appointments must be booked at least for today or future dates</li>
                </ul>

                <h3>👨‍🔧 Our Mechanics</h3>
                <div class="mechanics-list" id="mechanics_list">
                    <!-- Will be populated by JavaScript -->
                </div>

                <div class="admin-link">
                    <a href="admin.php" class="btn btn-admin">Admin Panel</a>
                </div>
            </div>
        </div>

        <footer>
            <p>&copy; 2026 Elite Car Workshop. All rights reserved.</p>
        </footer>
    </div>

    <script src="script.js"></script>
</body>
</html>
