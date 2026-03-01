-- Car Workshop Appointment System Database
-- Create Database
CREATE DATABASE IF NOT EXISTS car_workshop;
USE car_workshop;

-- Table: mechanics
CREATE TABLE IF NOT EXISTS mechanics (
    mechanic_id INT AUTO_INCREMENT PRIMARY KEY,
    mechanic_name VARCHAR(100) NOT NULL,
    specialization VARCHAR(100),
    phone VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: appointments
CREATE TABLE IF NOT EXISTS appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(100) NOT NULL,
    client_address VARCHAR(255) NOT NULL,
    client_phone VARCHAR(15) NOT NULL,
    car_license_number VARCHAR(50) NOT NULL,
    car_engine_number VARCHAR(50) NOT NULL,
    appointment_date DATE NOT NULL,
    mechanic_id INT NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (mechanic_id) REFERENCES mechanics(mechanic_id),
    INDEX idx_appointment_date (appointment_date),
    INDEX idx_mechanic_id (mechanic_id)
);

-- Insert 5 mechanics
INSERT INTO mechanics (mechanic_name, specialization, phone) VALUES
('John Smith', 'Engine Specialist', '555-0101'),
('Michael Brown', 'Transmission Expert', '555-0102'),
('David Wilson', 'Electrical Systems', '555-0103'),
('James Davis', 'Body Work & Paint', '555-0104'),
('Robert Johnson', 'General Maintenance', '555-0105');

-- Create admin user table (optional for future enhancement)
CREATE TABLE IF NOT EXISTS admin_users (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin (email: admin@carworkshop.com, password: admin123)
INSERT INTO admin_users (username, email, password) VALUES
('Admin', 'admin@carworkshop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
