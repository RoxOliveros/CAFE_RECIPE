<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit;
}

// Include database connection
require_once 'config/database.php';

$current_user_id = $_SESSION['user_id'];
$profile_user_id = isset($_GET['id']) ? intval($_GET['id']) : 1; // Default to user 1 for demo

// Fetch current user info (for navbar)
$stmt = $conn->prepare("SELECT user_id, username, display_name, avatar_img FROM users WHERE user_id = ?");
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$currentUser = $stmt->get_result()->fetch_assoc();
$stmt->close();

$profile_stmt = $conn->prepare("SELECT user_id, username, display_name, avatar_img FROM users WHERE user_id = ?");
$profile_stmt->bind_param("i", $profile_user_id);
$profile_stmt->execute();
$userProfile = $profile_stmt->get_result()->fetch_assoc();
$profile_stmt->close();

// Check if current user is following the profile user
$is_following = false;
$check_stmt = $conn->prepare("SELECT 1 FROM followers WHERE follower_id = ? AND following_id = ?");
$check_stmt->bind_param("ii", $current_user_id, $profile_user_id);
$check_stmt->execute();
$is_following = $check_stmt->get_result()->num_rows > 0;
$check_stmt->close();

$userProfileName = htmlspecialchars($userProfile['display_name']);

echo "<script>
    const isLoggedIn = " . ($isLoggedIn ? 'true' : 'false') . ";
</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $userProfileName; ?> - Sweet Creation</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="navbar.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="other-profile-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="toast-notifications.css?v=<?php echo time(); ?>">
</head>

<body>

    <!--navbar-->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container d-flex align-items-center">

            <!-- LOGO -->
            <a class="navbar-brand me-auto" href="homepage.php">
                <img src="Asset/LogoSC.png" alt="Sweet Creation Logo" width="70" height="60">
            </a>

            <!-- TOGGLER -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- MENU -->
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
                <!-- Current User Display -->
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

    <!-- PROFILE HEADER -->
    <section class="profile-header">
        <div class="container">
            <div class="profile-card">
                <div class="profile-cover"></div>
                
                <div id="profileContainer" class="profile-info-wrapper">
                    <!-- Profile information will be loaded here -->    
                </div>
            </div>
        </div>
    </section>

    <!-- PROFILE CONTENT -->
    <section class="profile-content">
        <div class="container">
            <ul class="nav nav-tabs profile-tabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#recipes-tab">
                        <i class="bi bi-grid-3x3"></i> Recipes
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#liked-tab">
                        <i class="bi bi-heart-fill"></i> Liked
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-4">
                <!-- RECIPES TAB -->
                <div class="tab-pane fade show active" id="recipes-tab">
                    <div class="recipes-grid" id="userRecipes">
                        <!-- Dummy recipe cards will be loaded here -->
                    </div>
                </div>

                <!-- LIKED TAB -->
                <div class="tab-pane fade" id="liked-tab">
                    <div class="recipes-grid" id="likedRecipes">
                        <!-- Dummy liked recipe cards will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </section>

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

    <script src="toast-notifications.js"></script>
    <script>
        const profileUserId = <?php echo $profile_user_id; ?>;
        const currentUserId = <?php echo $current_user_id; ?>;

        const urlParams = new URLSearchParams(window.location.search);
        const userId = urlParams.get('id');

        if (!userId) {
            alert('User not found');
            window.location.href = 'homepage.php';
        }

        // Fetch user's bookmarked recipes from database
        fetch('get-user-profile.php?id=' + userId)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    document.getElementById('emptyBookmark').style.display = 'block';
                    return;
                }
                renderProfile(data);
            })
            .catch(err => console.error(err));

        function renderProfile(profile) {
            const container = document.getElementById('profileContainer');

            const bio = profile.bio ? profile.bio : 'No bio yet.';
            const date = new Date(profile.created_at);
            const $member_since = date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
            
            const followingActive = <?php echo $is_following ? 'true' : 'false'; ?>;
            const btnClass = followingActive ? 'follow-btn following' : 'follow-btn';
            const btnText = followingActive ? 'Following' : 'Follow';
            const btnIcon = followingActive ? 'bi-person-check-fill' : 'bi-person-plus-fill';

            container.innerHTML = `
                <div class="profile-avatar-section">
                    <img src="${profile.avatar_img}" alt="Profile Avatar" class="profile-avatar">
                    
                    <div class="profile-actions">
                        <button class="${btnClass}" id="followBtn" onclick="toggleFollow()">
                            <i class="bi ${btnIcon}"></i>
                            <span id="followText">${btnText}</span>
                        </button>
                        
                        <div class="dropdown">
                            <button class="more-options-btn" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="hideUser()">
                                        <i class="bi bi-eye-slash"></i>
                                        Hide Posts
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="blockUser()">
                                        <i class="bi bi-shield-x"></i>
                                        Block User
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="profile-details">
                    <h1 class="profile-name">${profile.display_name}</h1>
                    <p class="profile-username">@${profile.username}</p>
                    
                    <p class="profile-bio">${bio}</p>
                    
                    <div class="profile-meta">
                        <span><i class="bi bi-calendar-fill" style="color: #c89b52;"></i> Joined ${$member_since}</span>
                    </div>

                    <div class="profile-stats">
                        <div class="stat-item">
                            <span class="stat-number">${profile.recipes_count}</span>
                            <span class="stat-label">Recipes</span>
                        </div>
                        <div class="stat-item" onclick="showFollowersModal(<?php echo $profile_user_id; ?>)">
                            <span class="stat-number" id="followerCount">${profile.follower_count}</span>
                            <span class="stat-label">Followers</span>
                        </div>
                        <div class="stat-item" onclick="showFollowingModal(<?php echo $profile_user_id; ?>)">
                            <span class="stat-number">${profile.following_count}</span>
                            <span class="stat-label">Following</span>
                        </div>
                    </div>
                </div>
            `;
        }

        // Navbar scroll effect
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Hamburger menu toggle
        function toggleMenu() {
            const menu = document.getElementById("hamburgerMenu");
            menu.classList.toggle("active");
        }

        // Logout function
        function logoutUser() {
            const confirmLogout = confirm("Are you sure you want to logout?");
            
            if (confirmLogout) {
                document.getElementById("hamburgerMenu").classList.remove("active");
                window.location.href = "Logout.php";
            }
        }

        // Close menu when clicking any menu link
        document.querySelectorAll("#hamburgerMenu a").forEach(link => {
            link.addEventListener("click", () => {
                document.getElementById("hamburgerMenu").classList.remove("active");
            });
        });

        let userRecipes = [];

        fetch('get-others-recipes.php?id=' + userId)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    document.getElementById('emptyBookmark').style.display = 'block';
                    return;
                }
                userRecipes = data.recipes;
                loadUserRecipes();
            })
            .catch(err => console.error(err));

        // Load user recipes with dummy data
        function loadUserRecipes() {
            const container = document.getElementById('userRecipes');

            if (userRecipes.length === 0) {
                container.innerHTML = `
                    <div class="no-recipes">
                        <div class="no-recipes-content">
                            <i class="bi bi-inbox"></i>
                            <h3>No Recipes Yet</h3>
                            <p>This user hasn't posted any recipes yet. Check back later!</p>
                        </div>
                    </div>
                `;
            } else {
                container.innerHTML = userRecipes.map(recipe => `
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
            }
        }

        let likedRecipes = [];
        
        fetch('get-others-likes.php?id=' + userId)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    document.getElementById('emptyBookmark').style.display = 'block';
                    return;
                }
                likedRecipes = data.liked_recipes;
            })
            .catch(err => console.error(err));

        // Load liked recipes with dummy data
        function loadLikedRecipes() {
            const container = document.getElementById('likedRecipes');

            if (likedRecipes.length === 0) {
                container.innerHTML = `
                    <div class="no-recipes">
                        <div class="no-recipes-content">
                            <i class="bi bi-heart"></i>
                            <h3>No Liked Recipes Yet</h3>
                            <p>This user hasn't liked any recipes yet. Check back later!</p>
                        </div>
                    </div>
                `;
            } else {
                container.innerHTML = likedRecipes.map(recipe => `
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

        // Toggle follow
        function toggleFollow() {
            const btn = document.getElementById('followBtn');
            const text = document.getElementById('followText');
            const icon = btn.querySelector('i');
            
            const followers = document.getElementById('followerCount');
            const followerCount = parseInt(followers.textContent);

            const isFollowing = btn.classList.contains('following');
            const action = isFollowing ? 'unfollow' : 'follow';

            btn.disabled = true;
            
            fetch('toggle-follow.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    action: action, 
                    other_user_id: profileUserId 
                })
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                if (data.success) {
                    if (action === 'follow') {
                        btn.classList.add('following');
                        icon.className = 'bi bi-person-check-fill';
                        text.textContent = 'Following';
                        followers.textContent = followerCount + 1;
                        showSuccess('Followed successfully');
                    } else {
                        btn.classList.remove('following');
                        icon.className = 'bi bi-person-plus-fill';
                        text.textContent = 'Follow';
                        followers.textContent = followerCount - 1;
                        showSuccess('Unfollowed successfully');
                    }
                } else {
                    showError(data.message);
                }
            })
            .catch(err => {
                btn.disabled = false;
                console.error('Error:', err);
            });
        }

        // Hide user
        function hideUser() {
            if (confirm('Are you sure you want to hide posts from this user? You can undo this in settings.')) {
                showToast('User posts hidden successfully', 'success');
            }
        }

        // Block user
        function blockUser() {
            if (confirm('Are you sure you want to block this user? They will not be able to see your profile or interact with your content.')) {
                showToast('User blocked successfully', 'success');
                setTimeout(() => {
                    window.location.href = 'Recipes.php';
                }, 1500);
            }
        }

        // View recipe
        function viewRecipe(recipeId) {
            window.location.href = 'ViewRecipe.php?id=' + recipeId;
        }

        // View user profile
        function viewUserProfile(userId) {
            console.log('Viewing user profile:', userId);
            showToast('Opening profile...', 'info');
            // window.location.href = 'Other-Profile.php?id=' + userId;
        }

        // Show toast function (if not in toast.js)
        function showToast(message, type = 'info') {
            // Create toast element if doesn't exist
            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container';
                toastContainer.style.cssText = 'position: fixed; top: 100px; right: 20px; z-index: 9999;';
                document.body.appendChild(toastContainer);
            }

            const toast = document.createElement('div');
            toast.className = `toast-notification toast-${type}`;
            toast.style.cssText = `
                background: ${type === 'success' ? '#4caf50' : type === 'error' ? '#f44336' : '#2196f3'};
                color: white;
                padding: 16px 24px;
                border-radius: 12px;
                margin-bottom: 10px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                animation: slideIn 0.3s ease;
                font-weight: 600;
            `;
            toast.textContent = message;
            
            toastContainer.appendChild(toast);
            
            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
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
            const likedTab = document.querySelector('[data-bs-target="#liked-tab"]');
            if (likedTab) {
                likedTab.addEventListener('shown.bs.tab', function() {
                    loadLikedRecipes();
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
    
    <style>
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
</body>
</html>