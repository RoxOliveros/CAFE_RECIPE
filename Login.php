<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up - Sweet Creation</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="LoginSignup-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="toast-notifications.css">
</head>
<body>
    <div class="auth-container">
        <!-- LOGIN FORM -->
        <form id="loginForm" autocomplete="off">
            <div class="auth-header">
                <h2>Welcome Back!</h2>
                <p>Login to your account</p>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="username" onkeydown="if(event.key === ' ') return false;" oninput="this.value = this.value.replace(/[^a-zA-Z0-9-_.]/g, '')" maxlength="20" name="username" placeholder="Enter username" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" onkeydown="if(event.key === ' ') return false;" oninput="this.value = this.value.replace(/\s/g, '')" maxlength="20" name="password" placeholder="Enter password" autocomplete="new-password" required>
            </div>

            <button type="submit" class="submit-btn">Login</button>

            <div class="auth-switch">
                Don't have an account? <a onclick="showSignup()">Sign Up</a>
            </div>

            <div class="back-home">
                <a onclick="goHome()">← Back to Home</a>
            </div>
        </form>
    </div>

    <script src="toast-notifications.js" defer></script>
    <script>
        function showSignup() {
            window.location.href = 'Signup.php';
        }
        
        function goHome() {
            window.location.href = 'homepage.php';
        }

        // For logging in
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);

            const loadingToast = showLoading('Checking account...', 'Please wait');
            
            // Show loading message
            const loginBtn = this.querySelector('.submit-btn');
            const originalText = loginBtn.textContent;
            loginBtn.textContent = 'Logging in...';
            loginBtn.disabled = true;
        
            fetch('login-account.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                setTimeout(() => {
                    loadingToast.close();
                }, 1500);
                
                setTimeout(() => {
                    if (data.success) {
                        // Show success toast
                        showSuccess('You have logged in successfully! 🎉');
                        
                        setTimeout(() => {
                            window.location.href = 'homepage.php';
                        }, 1500);
                    } else {
                        // Show error toast
                        showError(data.message || 'Failed to login');
                        loginBtn.textContent = originalText;
                        loginBtn.disabled = false;
                    }
                }, 1500);
            })
            .catch(error => {
                loadingToast.close();
                console.error('Error:', error);

                showError('An error occurred while logging in.');
                loginBtn.textContent = originalText;
                loginBtn.disabled = false;
            });
        });
    </script>
</body>
</html>
