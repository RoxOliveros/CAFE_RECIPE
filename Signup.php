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
    <!-- SIGNUP FORM -->
        <form id="signupForm" autocomplete="off">
            <div class="auth-header">
                <h2>Create Account</h2>
                <p>Join Sweet Creation today</p>
            </div>

            <div class="form-group">
                <label>Display Name</label>
                <input type="text" oninput="this.value = this.value.replace(/ {2,}/g, ' ').replace(/^ /g, '').replace(/[^a-zA-Z ]/g, '')" title="Only letters and spaces are allowed." maxlength="50" name="display_name" placeholder="Enter display name" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" onkeydown="if(event.key === ' ') return false;" oninput="checkUsername(this)" title="Only letters, numbers, -, _, and . are allowed." maxlength="20" name="username" placeholder="Enter username" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" onkeydown="if(event.key === ' ') return false;" oninput="checkEmail(this)" title="Please follow this format - example@gmail.com" maxlength="50" name="email" id="email" placeholder="Enter email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" onkeydown="if(event.key === ' ') return false;" oninput="checkPassword(this)" maxlength="20" name="password" id="signupPassword" placeholder="Create password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" onkeydown="if(event.key === ' ') return false;" maxlength="20" name="confirm_password" id="confirmPassword" placeholder="Confirm password" required>
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

    <script src="toast-notifications.js" defer></script>
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
            
            const loadingToast = showLoading('Creating account...', 'Please wait');

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
                setTimeout(() => {
                    loadingToast.close();
                }, 1500);
                
                setTimeout(() => {
                    if (data.success) {
                        // Show success toast
                        showSuccess('You have signed up successfully! 🎉');
                        
                        setTimeout(() => {
                            window.location.href = 'homepage.php';
                        }, 1000);
                    } else {
                        // Show error toast
                        showError(data.message || 'Failed to signup');
                    loginBtn.textContent = originalText;
                    loginBtn.disabled = false;
                    }
                }, 1500);
            })
            .catch(error => {
                loadingToast.close();
                showError('Error:', error);

                showError('An error occurred while signing up.');
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

        function checkEmail(input) {
            const start = input.selectionStart;
            
            const newValue = input.value.replace(/[^a-zA-Z0-9-_.@]/g, '');
            
            if (input.value !== newValue) {
                input.value = newValue;
                
                input.setSelectionRange(start - 1, start - 1);
            }
        }

        function checkPassword(input) {
            if (input.value.length > 0 && input.value.length < 8) {
                input.setCustomValidity("Your password must be 8 characters or more.");
            } else {
                input.setCustomValidity(""); 
            }
        }

        function checkUsername(input) {
            input.value = input.value.replace(/[^a-zA-Z0-9-_.]/g, '')

            if (input.value.length > 0 && input.value.length < 8) {
                input.setCustomValidity("Your username must be 8 characters or more.");
            } else {
                input.setCustomValidity(""); 
            }
        }
    </script>

</body>
</html>
