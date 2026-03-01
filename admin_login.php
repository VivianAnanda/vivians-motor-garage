<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Car Workshop</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .login-container {
            max-width: 450px;
            margin: 50px auto;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h1 {
            color: #333;
            font-size: 2em;
            margin-bottom: 10px;
        }
        .login-header p {
            color: #666;
            font-size: 1em;
        }
        .admin-icon {
            font-size: 4em;
            margin-bottom: 20px;
        }
        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c33;
            display: none;
        }
        .error-message.show {
            display: block;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 0.95em;
        }
        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <div class="admin-icon">🔐</div>
                <h1>Admin Login</h1>
                <p>Access the appointment management system</p>
            </div>

            <div id="errorMessage" class="error-message"></div>

            <form id="loginForm" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required
                        placeholder="admin@carworkshop.com"
                        autocomplete="email"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        placeholder="Enter your password"
                        autocomplete="current-password"
                    >
                </div>

                <button type="submit" class="submit-btn">
                    <span>Login to Admin Panel</span>
                </button>
            </form>

            <div class="back-link">
                <a href="welcome.html">← Back to Home</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const errorDiv = document.getElementById('errorMessage');
            const submitBtn = this.querySelector('.submit-btn');
            
            // Disable button during submission
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span>Logging in...</span>';
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('admin_login_handler.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Redirect to admin panel on success
                    window.location.href = 'admin.php';
                } else {
                    // Show error message
                    errorDiv.textContent = result.message || 'Invalid email or password';
                    errorDiv.classList.add('show');
                    
                    // Re-enable button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<span>Login to Admin Panel</span>';
                }
            } catch (error) {
                errorDiv.textContent = 'An error occurred. Please try again.';
                errorDiv.classList.add('show');
                
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<span>Login to Admin Panel</span>';
            }
        });

        // Clear error message when user starts typing
        document.getElementById('email').addEventListener('input', function() {
            document.getElementById('errorMessage').classList.remove('show');
        });
        document.getElementById('password').addEventListener('input', function() {
            document.getElementById('errorMessage').classList.remove('show');
        });
    </script>
</body>
</html>
