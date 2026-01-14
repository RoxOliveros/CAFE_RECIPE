<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';
session_start();
$isLoggedIn = isset($_SESSION['user_id']);

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit;
}

$current_user_id = $_SESSION['user_id'];
$profile_user_id = isset($_GET['id']) ? intval($_GET['id']) : $current_user_id;
$is_own_profile = ($profile_user_id === $current_user_id);

// Fetch profile user data
$stmt = $conn->prepare("
    SELECT u.*, 
           (SELECT COUNT(*) FROM recipes WHERE user_id = u.user_id AND visibility = 'public') as recipe_count,
           (SELECT COUNT(*) FROM followers WHERE following_id = u.user_id) as followers_count,
           (SELECT COUNT(*) FROM followers WHERE follower_id = u.user_id) as following_count
    FROM users u 
    WHERE u.user_id = ?
");

if (!$stmt) {
    die("Database error: " . $conn->error);
}

$stmt->bind_param("i", $profile_user_id);
$stmt->execute();
$profile_user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$profile_user) {
    header("Location: homepage.php");
    exit;
}

// Check if current user follows this profile
$is_following = false;
if (!$is_own_profile) {
    $stmt = $conn->prepare("SELECT 1 FROM followers WHERE follower_id = ? AND following_id = ?");
    $stmt->bind_param("ii", $current_user_id, $profile_user_id);
    $stmt->execute();
    $is_following = $stmt->get_result()->num_rows > 0;
    $stmt->close();
}

// Fetch current user info for navbar
$stmt = $conn->prepare("SELECT user_id, username, display_name, avatar_img FROM users WHERE user_id = ?");
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$currentUser = $stmt->get_result()->fetch_assoc();
$stmt->close();

$avatar = !empty($profile_user['avatar_img']) ? htmlspecialchars($profile_user['avatar_img']) : 'Asset/no-profile.jpg';
$display_name = htmlspecialchars($profile_user['display_name'] ?? $profile_user['username']);
$username = htmlspecialchars($profile_user['username']);
$bio = htmlspecialchars($profile_user['bio'] ?? 'No bio yet.');
$member_since = date('F Y', strtotime($profile_user['created_at']));

echo "<script>
    const isLoggedIn = " . ($isLoggedIn ? 'true' : 'false') . ";
</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $display_name; ?> - Sweet Creation</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="toast-notifications.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="navbar.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="profile.css?v=<?php echo time(); ?>">
    
</head>
<body>

    <div id="toastContainer" class="toast-container"></div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container d-flex align-items-center">
            <a class="navbar-brand me-auto" href="homepage.php">
                <img src="Asset/LogoSC.png" alt="Sweet Creation Logo" width="70" height="60">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
                <ul class="navbar-nav nav-pills align-items-center gap-lg-4">
                    <li class="nav-item flex-fill">
                        <a class="nav-link" href="homepage.php">HOME</a>
                    </li>
                    <li class="nav-item flex-fill">
                        <a class="nav-link" href="Recipes.php">RECIPES</a>
                    </li>
                    <li class="nav-item flex-fill">
                        <a class="nav-link" href="YourCreation.php">YOUR CREATION</a>
                    </li>
                    <li class="nav-item flex-fill">
                        <a class="nav-link" href="AboutUs.php">ABOUT US</a>
                    </li>
                </ul>
            </div>
            
            <div class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="hamburger-menu" id="hamburgerMenu">
                <a href="Profile.php?id=<?php echo $currentUser['user_id']; ?>" class="current-user profile-link">
                    <img src="<?php 
                        echo !empty($currentUser['avatar_img']) ? htmlspecialchars($currentUser['avatar_img']) : 
                            'Asset/no-profile.jpg'; 
                    ?>" alt="Avatar" class="navbar-avatar">
                    <div class="user-text-details" style="display: flex; flex-direction: column; line-height: 1.2;">
                        <span class="navbar-username" style="font-size: 16px; font-weight: 600;">
                            <?php echo htmlspecialchars($currentUser['display_name']); ?>
                        </span>
                        <span class="navbar-username" style="font-size: 13px; font-weight: 100; color: #b08261;">
                            @<?php echo htmlspecialchars($currentUser['username']); ?>
                        </span>
                    </div>
                </a>
                <a href="AboutUs.php">About Us</a>
                <a href="#" class="login-link" onclick="logoutUser()">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Profile Header -->
    <section class="profile-header">
        <div class="container">
            <div class="profile-card">
                <div class="profile-cover"></div>
                
                <div class="profile-info-wrapper">
                    <div class="profile-avatar-section">
                        <img src="<?php echo $avatar; ?>" alt="<?php echo $display_name; ?>" class="profile-avatar" id="profileAvatar">
                        
                        <?php if ($is_own_profile): ?>
                            <button class="edit-profile-btn" onclick="openEditProfileModal()">
                                <i class="bi bi-pencil-fill"></i> Edit Profile
                            </button>
                            <button class="btn-delete-account" onclick="confirmDeleteAccount()" style="margin-left: 10px;">
                                <i class="bi bi-trash-fill"></i> Delete Account
                            </button>
                        <?php else: ?>
                            <button class="follow-btn <?php echo $is_following ? 'following' : ''; ?>" 
                                    id="followBtn" 
                                    onclick="toggleFollow(<?php echo $profile_user_id; ?>)">
                                <i class="bi <?php echo $is_following ? 'bi-check-circle-fill' : 'bi-plus-circle-fill'; ?>"></i>
                                <span><?php echo $is_following ? 'Following' : 'Follow'; ?></span>
                            </button>
                        <?php endif; ?>
                    </div>
                    
                    <div class="profile-details">
                        <h1 class="profile-name" id="profileDisplayName"><?php echo $display_name; ?></h1>
                        <p class="profile-username">@<?php echo $username; ?></p>
                        <p class="profile-bio" id="profileBio"><?php echo $bio; ?></p>
                        
                        <div class="profile-meta">
                            <span><i class="bi bi-calendar-fill" style="color: #c89b52;"></i> Joined <?php echo $member_since; ?></span>
                        </div>
                        
                        <div class="profile-stats">
                            <div class="stat-item">
                                <span class="stat-number"><?php echo $profile_user['recipe_count']; ?></span>
                                <span class="stat-label">Recipes</span>
                            </div>
                            <div class="stat-item" onclick="showFollowersModal(<?php echo $profile_user_id; ?>)">
                                <span class="stat-number" id="followersCount"><?php echo $profile_user['followers_count']; ?></span>
                                <span class="stat-label">Followers</span>
                            </div>
                            <div class="stat-item" onclick="showFollowingModal(<?php echo $profile_user_id; ?>)">
                                <span class="stat-number"><?php echo $profile_user['following_count']; ?></span>
                                <span class="stat-label">Following</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recipes Section -->
    <section class="profile-content">
        <div class="container">
            <ul class="nav nav-tabs profile-tabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#recipes-tab">
                        <i class="bi bi-grid-3x3"></i> Recipes
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#saved-tab">
                        <i class="bi bi-bookmark-fill"></i> Saved
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-4">
                <!-- RECIPES TAB -->
                <div class="tab-pane fade show active" id="recipes-tab">
                    <div class="recipes-grid" id="recipesGrid">
                        <!-- Dummy recipe cards will be loaded here -->
                    </div>
                </div>

                <!-- SAVED TAB -->
                <div class="tab-pane fade" id="saved-tab">
                    <div class="recipes-grid" id="savedGrid">
                        <!-- Dummy saved recipe cards will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-fill"></i> Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 30px; margin-bottom: -10px;">
                    <form id="editProfileForm" enctype="multipart/form-data">
                        <div class="avatar-upload-section">
                            <img src="<?php echo $avatar; ?>" alt="Avatar Preview" class="avatar-preview" id="avatarPreview">
                            <div>
                                <label for="avatarUpload" class="btn-upload-avatar">
                                    <i class="bi bi-camera-fill"></i> Change Avatar
                                </label>
                                <input type="file" id="avatarUpload" name="avatar" accept="image/*" style="display: none;">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="displayName" class="form-label">Display Name</label>
                            <input type="text" oninput="this.value = this.value.replace(/ {2,}/g, ' ').replace(/^ /g, '').replace(/[^a-zA-Z ]/g, '')" placeholder="Change display name" class="form-control" id="displayName" name="display_name" 
                                   value="<?php echo htmlspecialchars($profile_user['display_name'] ?? $profile_user['username']); ?>" required maxlength="50">
                        </div>
                        
                        <div class="mb-3">
                            <label for="bioText" class="form-label">Bio</label>
                            <textarea oninput="this.value = this.value.replace(/^[ \n]/g, '')" class="form-control" id="bioText" name="bio" rows="4" 
                                      maxlength="200" placeholder="Tell us about yourself..."><?php 
                                      $raw_bio = $profile_user['bio'] ?? '';
                                      echo htmlspecialchars($raw_bio);
                                      ?></textarea>
                            <small class="text-muted">Maximum 200 characters</small>
                        </div>
                        
                        <button type="submit" class="btn-save-profile">
                            <i class="bi bi-check-circle-fill"></i> Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FOLLOWERS MODAL -->
    <div class="modal fade" id="followModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Followers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="followModalBody">
                    <!-- Follower list will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- FOLLOWING MODAL -->
    <div class="modal fade" id="followingModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Following</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="followingModalBody">
                    <!-- Following list will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- footer-->
    <footer class="custom-footer">
        <div class="container py-5">
            <div class="row">
                
                <!-- LOGO & ABOUT -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <img src="Asset/footerLogo.png" alt="Sweet Creation" height="120" class="mb-3">
        
                    <!-- Social Media -->
                    <div style="display: flex; gap: 12px; margin-top: 20px;">
                        <a href="#" style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s ease;">
                            <i class="bi bi-facebook" style="font-size: 18px;"></i>
                        </a>
                        <a href="#" style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s ease;">
                            <i class="bi bi-instagram" style="font-size: 18px;"></i>
                        </a>
                        <a href="#" style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s ease;">
                            <i class="bi bi-twitter" style="font-size: 18px;"></i>
                        </a>
                        <a href="#" style="width: 40px; height: 40px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; transition: all 0.3s ease;">
                            <i class="bi bi-youtube" style="font-size: 18px;"></i>
                        </a>
                    </div>
                </div>

                <!-- QUICK LINKS -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 style="color: #fff; font-weight: 700; font-size: 18px; margin-bottom: 20px;">Quick Links</h5>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 12px;">
                            <a href="homepage.php" style="color: #fff3e0; text-decoration: none; font-size: 14px; transition: all 0.3s ease;">Home</a>
                        </li>
                        <li style="margin-bottom: 12px;">
                            <a href="Recipes.php" style="color: #fff3e0; text-decoration: none; font-size: 14px; transition: all 0.3s ease;">Recipes</a>
                        </li>
                        <li style="margin-bottom: 12px;">
                            <a href="YourCreation.php" style="color: #fff3e0; text-decoration: none; font-size: 14px; transition: all 0.3s ease;">Your Creation</a>
                        </li>
                        <li style="margin-bottom: 12px;">
                            <a href="AboutUs.php" style="color: #fff3e0; text-decoration: none; font-size: 14px; transition: all 0.3s ease;">About Us</a>
                        </li>
                    </ul>
                </div>

                <!-- CATEGORIES -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 style="color: #fff; font-weight: 700; font-size: 18px; margin-bottom: 20px;">Categories</h5>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 12px;">
                            <a href="#" style="color: #fff3e0; text-decoration: none; font-size: 14px;">Cakes & Cupcakes</a>
                        </li>
                        <li style="margin-bottom: 12px;">
                            <a href="#" style="color: #fff3e0; text-decoration: none; font-size: 14px;">Cookies & Bars</a>
                        </li>
                        <li style="margin-bottom: 12px;">
                            <a href="#" style="color: #fff3e0; text-decoration: none; font-size: 14px;">Frozen Desserts</a>
                        </li>
                        <li style="margin-bottom: 12px;">
                            <a href="#" style="color: #fff3e0; text-decoration: none; font-size: 14px;">Pies & Tarts</a>
                        </li>
                        <li style="margin-bottom: 12px;">
                            <a href="#" style="color: #fff3e0; text-decoration: none; font-size: 14px;">Custards & Puddings</a>
                        </li>
                    </ul>
                </div>

                <!-- CONTACT INFO -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 style="color: #fff; font-weight: 700; font-size: 18px; margin-bottom: 20px;">Contact Us</h5>
                    <div style="margin-bottom: 15px;">
                        <i class="bi bi-envelope-fill" style="color: #fff3e0; margin-right: 10px;"></i>
                        <a href="mailto:sweetcreation@gmail.com" style="color: #fff3e0; text-decoration: none; font-size: 14px;">sweetcreation@gmail.com</a>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <i class="bi bi-telephone-fill" style="color: #fff3e0; margin-right: 10px;"></i>
                        <a href="tel:+639344767596" style="color: #fff3e0; text-decoration: none; font-size: 14px;">+63 934 476 7596</a>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <i class="bi bi-geo-alt-fill" style="color: #fff3e0; margin-right: 10px;"></i>
                        <span style="color: #fff3e0; font-size: 14px;">Binan, Laguna, PH</span>
                    </div>
                </div>
            </div>

            <!-- BOTTOM BAR -->
            <div style="border-top: 2px solid rgba(255,255,255,0.2); margin-top: 30px; padding-top: 25px;">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <p style="color: #fff3e0; font-size: 13px; margin: 0;">
                            © 2024 Sweet Creation. All rights reserved.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <a href="#" style="color: #fff3e0; text-decoration: none; font-size: 13px; margin: 0 10px;">Privacy Policy</a>
                        <span style="color: #fff3e0;">•</span>
                        <a href="#" style="color: #fff3e0; text-decoration: none; font-size: 13px; margin: 0 10px;">Terms of Service</a>
                        <span style="color: #fff3e0;">•</span>
                        <a href="#" style="color: #fff3e0; text-decoration: none; font-size: 13px; margin: 0 10px;">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="toast-notifications.js" defer></script>
    <script>

        const profileUserId = <?php echo $profile_user_id; ?>;
        const currentUserId = <?php echo $current_user_id; ?>;
        const isOwnProfile = <?php echo $is_own_profile ? 'true' : 'false'; ?>;

        // Navbar scroll effect
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        function toggleMenu() {
            document.getElementById("hamburgerMenu").classList.toggle("active");
        }

        function logoutUser() {
            showConfirmation('Are you sure you want to logout?', () => {
                window.location.href = "Logout.php";
            });
        }

        // Edit Profile Functions
        function openEditProfileModal() {
            const modal = new bootstrap.Modal(document.getElementById('editProfileModal'));
            modal.show();
        }

        document.getElementById('avatarUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('avatarPreview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('editProfileForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            
            // Disable button immediately
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
                    
            const loadingToast = showLoading('Updating profile...', 'Please wait');
            
            try {
                const response = await fetch('edit-profile.php', {
                    method: 'POST',
                    body: formData
                });
                
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                
                const data = await response.json();
                
                if (data.success) {
                    setTimeout(() => {
                        loadingToast.close();

                    }, 1500);
                    setTimeout(() => { 
                        console.log('About to show success toast');
                        showSuccess('Your profile has been updated successfully!', 'Profile Updated!');

                        // Close modal FIRST
                        const modalElement = document.getElementById('editProfileModal');
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                        
                        // Wait for modal animation to complete
                        new Promise(resolve => setTimeout(resolve, 500));
                        
                        // Clean up any leftover backdrops
                        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                        document.body.classList.remove('modal-open');
                        document.body.style.removeProperty('padding-right');
                        document.body.style.removeProperty('overflow');
                        
                        // Update profile display
                        document.getElementById('profileDisplayName').textContent = data.user.display_name;
                        document.getElementById('profileBio').textContent = data.user.bio || 'No bio yet.';
                        
                        // Update avatar if changed
                        if (data.user.avatar_img) {
                            const avatarUrl = data.user.avatar_img + '?t=' + Date.now();
                            document.getElementById('profileAvatar').src = avatarUrl;
                            document.getElementById('avatarPreview').src = avatarUrl;
                        }
                        
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Save Changes';
                    }, 1500);
                } else {
                    showError(data.message || 'Failed to update profile. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Network error. Please check your connection and try again.');
            }
        });

        // Delete Account Function
        async function confirmDeleteAccount() {
            showConfirmation(
                'Are you absolutely sure? This action cannot be undone. All your recipes, comments, and data will be permanently deleted.',
                async () => {
                    const loading = showLoading('Deleting your account...', 'Please wait');
                    
                    try {
                        const response = await fetch('delete-account.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' }
                        });
                        
                        const data = await response.json();
                        setTimeout(() => {
                            loading.close();
                        }, 1500);
                        
                        setTimeout(() => {
                            if (data.success) {
                        
                                if (data.success) {
                                    showSuccess('Your account has been deleted! 🗑️', 'Account Deleted');
                                    
                                    setTimeout(() => {
                                        window.location.href = 'Login.php';
                                    }, 1500);
                                } else {
                                    showError(data.message || 'Failed to delete account. Please try again.');
                                }
                            } else {
                                // Show error toast
                                showError(data.message || 'Failed to delete account. Please try again.');
                            }
                        }, 1500);
                    } catch (error) {
                        loading.close();

                        console.error('Error:', error);
                        showError('Network error. Please try again.');
                    }
                }
            );
        }

        let userRecipes = [];

        // Fetch user's recipes from database
        fetch('get-user-recipes.php')
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    document.getElementById('emptyRecipe').style.display = 'block';
                    return;
                }
                userRecipes = data.recipes;
                loadUserRecipes();
            })
            .catch(err => console.error(err));

        async function loadUserRecipes() {
            try {
                const grid = document.getElementById('recipesGrid');
                
                if (userRecipes.length === 0) {
                    if (isOwnProfile) {
                        grid.innerHTML = `
                            <div class="no-recipes">
                                <div class="no-recipes-content">
                                    <i class="bi bi-journal-plus"></i>
                                    <h3>No Recipes Yet</h3>
                                    <p>Start sharing your delicious creations with the community! Your first recipe is just a click away.</p>
                                    <a href="YourCreation.php" class="btn-create-recipe">
                                        <i class="bi bi-plus-circle-fill" style="height: 75px; weight: 75x;"></i> Create Your First Recipe
                                    </a>
                                </div>
                            </div>
                        `;
                    } else {
                        grid.innerHTML = `
                            <div class="no-recipes">
                                <div class="no-recipes-content">
                                    <i class="bi bi-inbox"></i>
                                    <h3>No Recipes Yet</h3>
                                    <p>This user hasn't posted any recipes yet. Check back later!</p>
                                </div>
                            </div>
                        `;
                    }
                    return;
                }
                
                grid.innerHTML = userRecipes.map(recipe => `
                    <div class="recipe-card" onclick="viewRecipe(${recipe.id})">
                        <img src="${recipe.image}" alt="${recipe.title}">
                        <div class="recipe-overlay">
                            <h3>${recipe.title}</h3>
                            <div class="recipe-stats">
                                <span><i class="bi bi-heart-fill"></i> ${recipe.likes}</span>
                                <span><i class="bi bi-chat-fill"></i> ${recipe.comments}</span>
                            </div>
                        </div>
                    </div>
                `).join('');
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('recipesGrid').innerHTML = `
                    <div class="no-recipes">
                        <div class="no-recipes-content">
                            <i class="bi bi-exclamation-triangle"></i>
                            <h3>Oops!</h3>
                            <p>Something went wrong while loading recipes. Please try again later.</p>
                        </div>
                    </div>
                `;
            }
        }
        
        let savedRecipes = [];

        // Fetch user's recipes from database
        fetch('get-user-bookmarks.php')
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    document.getElementById('emptyRecipe').style.display = 'block';
                    return;
                }
                savedRecipes = data.bookmarks;
            })
            .catch(err => console.error(err));

        async function loadSavedRecipes() {
            if (!isOwnProfile) return;
            
            try {
                const grid = document.getElementById('savedGrid');
                
                if (savedRecipes.length === 0) {
                    grid.innerHTML = `
                        <div class="no-recipes">
                            <div class="no-recipes-content">
                                <i class="bi bi-bookmark"></i>
                                <h3>No Saved Recipes Yet</h3>
                                <p>Start bookmarking your favorite recipes to find them easily! Explore recipes to find out more.</p>
                                <a href="Recipes.php" class="btn-create-recipe">
                                    <i class="bi bi-search" style="height: 75px; weight: 75x;"></i> Explore Recipes
                                </a>
                            </div>
                        </div>
                    `;
                    return;
                }
                
                grid.innerHTML = savedRecipes.map(recipe => `
                    <div class="recipe-card" onclick="viewRecipe(${recipe.id})">
                        <img src="${recipe.image}" alt="${recipe.title}">
                        <div class="recipe-overlay">
                            <h3>${recipe.title}</h3>
                            <div class="recipe-stats">
                                <span><i class="bi bi-heart-fill"></i> ${recipe.likes}</span>
                                <span><i class="bi bi-chat-fill"></i> ${recipe.comments}</span>
                            </div>
                        </div>
                    </div>
                `).join('');
            } catch (error) {
                console.error('Error:', error);
            }
        }

        async function toggleFollow(userId) {
            const btn = document.getElementById('followBtn');
            
            try {
                const response = await fetch('toggle-follow.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ user_id: userId })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    btn.classList.toggle('following');
                    const icon = btn.querySelector('i');
                    const text = btn.querySelector('span');
                    
                    if (data.action === 'followed') {
                        icon.className = 'bi bi-check-circle-fill';
                        text.textContent = 'Following';
                        document.getElementById('followersCount').textContent = parseInt(document.getElementById('followersCount').textContent) + 1;
                        showSuccess('You are now following this user!');
                    } else {
                        icon.className = 'bi bi-plus-circle-fill';
                        text.textContent = 'Follow';
                        document.getElementById('followersCount').textContent = parseInt(document.getElementById('followersCount').textContent) - 1;
                        showInfo('You have unfollowed this user.');
                    }
                } else {
                    showError('Failed to update follow status. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        async function showFollowersModal(userId) {
            const modal = new bootstrap.Modal(document.getElementById('followModal'));
            modal.show();
            
            try {
                const response = await fetch(`get-followers.php?id=${userId}`);
                const followers = await response.json();
                
                if (followers.length === 0) {
                    document.getElementById('followModalBody').innerHTML = '<p class="text-center text-muted">No followers yet.</p>';
                    return;
                }
                
                document.getElementById('followModalBody').innerHTML = followers.map(user => `
                    <div class="follow-user-item" onclick="viewProfile(event, ${user.id})">
                        <img src="${user.avatar_img || 'Asset/no-profile.jpg'}" alt="${user.display_name}">
                        <div>
                            <div class="fw-bold">${user.display_name || user.username}</div>
                            <div class="text-muted small">@${user.username}</div>
                        </div>
                    </div>
                `).join('');
            } catch (error) {
                console.error('Error:', error);
            }
        }

        async function showFollowingModal(userId) {
            const modal = new bootstrap.Modal(document.getElementById('followingModal'));
            modal.show();
            
            try {
                const response = await fetch(`get-following.php?id=${userId}`);
                const following = await response.json();
                
                if (following.length === 0) {
                    document.getElementById('followingModalBody').innerHTML = '<p class="text-center text-muted">Not following anyone yet.</p>';
                    return;
                }
                
                document.getElementById('followingModalBody').innerHTML = following.map(user => `
                    <div class="follow-user-item" onclick="viewProfile(event, ${user.id})">
                        <img src="${user.avatar_img || 'Asset/no-profile.jpg'}" alt="${user.display_name}">
                        <div>
                            <div class="fw-bold">${user.display_name || user.username}</div>
                            <div class="text-muted small">@${user.username}</div>
                        </div>
                    </div>
                `).join('');
            } catch (error) {
                console.error('Error:', error);
            }
        }

        function viewRecipe(id) {
            window.location.href = `ViewRecipe.php?id=${id}`;
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            const recipeTab = document.querySelector('[data-bs-target="#recipes-tab"]');
            if (recipeTab) {
                recipeTab.addEventListener('shown.bs.tab', function() {
                    loadUserRecipes();
                });
            }
            
            // Load liked recipes when tab is shown
            const savedTab = document.querySelector('[data-bs-target="#saved-tab"]');
            if (savedTab) {
                savedTab.addEventListener('shown.bs.tab', function() {
                    loadSavedRecipes();
                });
            }
        });

        function viewProfile(event, userId) {
            event.stopPropagation(); 
            
            if (!isLoggedIn) {
                requireLogin("You need to login to view profiles.");
                return;
            }
            console.log("Viewing profile of user ID:", userId);
            if (userId === currentUserId) {
                window.location.href = 'Profile.php?id=' + userId;
            } else {
                window.location.href = 'Other-Profile.php?id=' + userId;
            }
        }
    </script>
</body>
</html>