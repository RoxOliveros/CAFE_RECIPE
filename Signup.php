<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up - Sweet Creation</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="LoginSignup-style.css?v=<?php echo time(); ?>">

</head>
<body>
    <div class="auth-container">
    <!-- SIGNUP FORM -->
        <form id="signupForm" autocomplete="off">
            <div class="auth-header">
                <h2>Create Account</h2>
                <p>Join Sweet Creation today</p>
            </div>

            <div class="form-group">
                <label>Display Name</label>
                <input type="text" name="display_name" placeholder="Enter display name" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter username" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email" placeholder="Enter email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="signupPassword" placeholder="Create password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm password" required>
            </div>

           <div class="form-group">
                <label>Choose Avatar</label>

                <input type="hidden" name="avatar_img" id="selectedAvatar" value="Asset/no-profile.jpg">

                <div class="avatar-grid">
                    <img src="Asset/avatar1.jpg" class="avatar-option" onclick="selectAvatar(this)">
                    <img src="Asset/avatar2.jpg" class="avatar-option" onclick="selectAvatar(this)">
                    <img src="Asset/avatar3.jpg" class="avatar-option" onclick="selectAvatar(this)">
                    <img src="Asset/avatar4.jpg" class="avatar-option" onclick="selectAvatar(this)">
                    <img src="Asset/avatar5.jpg" class="avatar-option" onclick="selectAvatar(this)">
                    <img src="Asset/avatar6.jpg" class="avatar-option" onclick="selectAvatar(this)">
                    <img src="Asset/avatar7.jpg" class="avatar-option" onclick="selectAvatar(this)">
                    <img src="Asset/avatar8.jpg" class="avatar-option" onclick="selectAvatar(this)">

                </div>
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
    
        // For signing up
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Show loading message
            const loginBtn = this.querySelector('.submit-btn');
            const originalText = loginBtn.textContent;
            loginBtn.textContent = 'Signing up...';
            loginBtn.disabled = true;
        
            fetch('signup-account.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('You have signed up successfully! 🎉');
                    window.location.href = 'homepage.php';
                } else {
                    alert('Error: ' + data.message);
                    loginBtn.textContent = originalText;
                    loginBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while signing up.');
                loginBtn.textContent = originalText;
                loginBtn.disabled = false;
            });
        });

        function selectAvatar(img) {
            document.querySelectorAll('.avatar-option')
                .forEach(a => a.classList.remove('selected'));

            img.classList.add('selected');
            document.getElementById('selectedAvatar').value = img.src;
        }
    </script>

</body>
</html>
