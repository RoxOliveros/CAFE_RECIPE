<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up - Sweet Creation</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="LoginSignup-style.css">
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
                <input type="username" name="username" placeholder="Enter username" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" autocomplete="new-password" required>
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

    <script>
    function showSignup() {
        window.location.href = 'Signup.php';
    }
    
    function goHome() {
        window.location.href = 'homepage.php';
    }
    </script>
</body>
</html>
