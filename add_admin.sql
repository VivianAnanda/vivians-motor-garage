-- Add a default admin account for testing
-- Email: admin@carworkshop.com
-- Password: admin123

-- Note: Password is hashed using PHP's password_hash()
-- The password "admin123" has been pre-hashed

INSERT INTO admin_users (username, email, password, created_at) VALUES
('Admin', 'admin@carworkshop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', CURRENT_TIMESTAMP);

-- This creates an admin account with:
-- Email: admin@carworkshop.com
-- Password: admin123
