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
    <!-- SIGNUP FORM -->
        <form id="signupForm">
            <div class="auth-header">
                <h2>Create Account</h2>
                <p>Join Sweet Creation today</p>
            </div>

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="display_name" placeholder="Enter name" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter Username" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email" placeholder="Enter Email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="signupPassword" placeholder="Create password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm password" required>
            </div>

            <button type="submit" class="submit-btn">Sign Up</button>

            <div class="auth-switch">
                Already have an account? <a onclick="showLogin()">Login</a>
            </div>

            <div class="back-home">
                <a onclick="goHome()">← Back to Home</a>
            </div>

        </form>
    </div>

    <script>
    function showLogin() {
            window.location.href = 'Login.php';
        }

    function goHome() {
            window.location.href = 'homepage.php';
    }
    </script>

</body>
</html>
