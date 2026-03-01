<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

require_once 'config.php';

// Get all appointments with mechanic details
$query = "SELECT a.*, m.mechanic_name, m.specialization 
          FROM appointments a 
          JOIN mechanics m ON a.mechanic_id = m.mechanic_id 
          ORDER BY a.appointment_date DESC, a.created_at DESC";
$appointments_result = $conn->query($query);

// Get all mechanics for the edit dropdown
$mechanics_query = "SELECT * FROM mechanics ORDER BY mechanic_name";
$mechanics_result = $conn->query($mechanics_query);
$mechanics = array();
while ($mech = $mechanics_result->fetch_assoc()) {
    $mechanics[] = $mech;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Car Workshop</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .admin-header {
            background: linear-gradient(135deg, rgba(100, 100, 100, 0.3) 0%, rgba(60, 60, 60, 0.3) 100%);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 10px;
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
            padding: 0 20px;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        .stat-card h3 {
            margin: 0;
            font-size: 2em;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .stat-card p {
            margin: 10px 0 0 0;
            color: #f0f0f0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="admin-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1>Vivian's Motor Garage - Admin Panel</h1>
                    <p>Manage Workshop Appointments</p>
                    <p style="font-size: 0.9em; opacity: 0.9; margin-top: 5px;">Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</p>
                </div>
                <div style="display: flex; gap: 10px;">
                    <a href="index.php" class="btn btn-secondary">User Panel</a>
                    <a href="logout.php" class="btn btn-secondary" style="background: #e74c3c;">Logout</a>
                </div>
            </div>
        </div>

        <?php
        // Calculate statistics
        $total_appointments = $appointments_result->num_rows;
        $today = date('Y-m-d');
        
        $appointments_result->data_seek(0);
        $today_count = 0;
        $confirmed_count = 0;
        while ($apt = $appointments_result->fetch_assoc()) {
            if ($apt['appointment_date'] == $today) $today_count++;
            if ($apt['status'] == 'confirmed') $confirmed_count++;
        }
        $appointments_result->data_seek(0);
        ?>

        <div class="stats-container">
            <div class="stat-card">
                <h3><?php echo $total_appointments; ?></h3>
                <p>Total Appointments</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $today_count; ?></h3>
                <p>Today's Appointments</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $confirmed_count; ?></h3>
                <p>Confirmed</p>
            </div>
            <div class="stat-card">
                <h3>5</h3>
                <p>Active Mechanics</p>
            </div>
        </div>

        <div class="admin-content">
            <h2>Appointments List</h2>
            <div id="admin_message"></div>

            <div class="table-responsive">
                <table class="appointments-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client Name</th>
                            <th>Phone</th>
                            <th>Car License</th>
                            <th>Appointment Date</th>
                            <th>Mechanic</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($appointments_result->num_rows > 0): ?>
                            <?php while ($appointment = $appointments_result->fetch_assoc()): ?>
                                <tr id="row_<?php echo $appointment['appointment_id']; ?>">
                                    <td><?php echo $appointment['appointment_id']; ?></td>
                                    <td><?php echo htmlspecialchars($appointment['client_name']); ?></td>
                                    <td><?php echo htmlspecialchars($appointment['client_phone']); ?></td>
                                    <td><?php echo htmlspecialchars($appointment['car_license_number']); ?></td>
                                    <td>
                                        <span class="date-display">
                                            <?php echo date('M d, Y', strtotime($appointment['appointment_date'])); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($appointment['mechanic_name']); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $appointment['status']; ?>">
                                            <?php echo ucfirst($appointment['status']); ?>
                                        </span>
                                    </td>
                                    <td class="action-buttons">
                                        <button onclick="editAppointment(<?php echo $appointment['appointment_id']; ?>)" 
                                                class="btn btn-edit btn-sm">Edit</button>
                                        <button onclick="deleteAppointment(<?php echo $appointment['appointment_id']; ?>)" 
                                                class="btn btn-delete btn-sm">Cancel</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 20px;">
                                    No appointments found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Appointment</h2>
            <form id="editForm">
                <input type="hidden" id="edit_appointment_id" name="appointment_id">
                
                <div class="form-group">
                    <label>Client Name:</label>
                    <input type="text" id="edit_client_name" readonly class="readonly">
                </div>

                <div class="form-group">
                    <label>Phone:</label>
                    <input type="text" id="edit_phone" readonly class="readonly">
                </div>

                <div class="form-group">
                    <label for="edit_date">Appointment Date *</label>
                    <input type="date" id="edit_date" name="appointment_date" required>
                </div>

                <div class="form-group">
                    <label for="edit_mechanic">Mechanic *</label>
                    <select id="edit_mechanic" name="mechanic_id" required>
                        <?php foreach ($mechanics as $mech): ?>
                            <option value="<?php echo $mech['mechanic_id']; ?>">
                                <?php echo htmlspecialchars($mech['mechanic_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div id="edit_availability_info" class="info-box"></div>
                </div>

                <div class="form-group">
                    <label for="edit_status">Status *</label>
                    <select id="edit_status" name="status" required>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Update Appointment</button>
                    <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script src="admin.js"></script>
</body>
</html>
