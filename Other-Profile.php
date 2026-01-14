<?php
session_start();
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

// DUMMY DATA for profile user (replace with real query later)
$profileUser = [
    'user_id' => $profile_user_id,
    'username' => 'sweetbaker101',
    'display_name' => 'Sarah Johnson',
    'avatar_img' => 'https://i.pravatar.cc/300?img=47',
    'bio' => '🧁 Passionate home baker | 🍰 Sharing my sweet creations | 📍 Manila, PH',
    'location' => 'Manila, Philippines',
    'joined_date' => '2023-06-15'
];

// DUMMY STATS
$stats = [
    'followers' => 1234,
    'following' => 567,
    'recipes' => 28
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($profileUser['display_name']); ?> - Sweet Creation</title>

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
    <div class="modal fade" id="followersModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Followers</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="followersList">
                        <!-- Followers list will be loaded here -->
                    </div>
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
                <div class="modal-body">
                    <div id="followingList">
                        <!-- Following list will be loaded here -->
                    </div>
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

        // DUMMY DATA for recipes
        const dummyRecipes = [
            {
                id: 1,
                image: 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=500&h=500&fit=crop',
                title: 'Red Velvet Cupcakes',
                likes: 324,
                comments: 45
            },
            {
                id: 2,
                image: 'https://images.unsplash.com/photo-1557925923-cd4648e211a0?w=500&h=500&fit=crop',
                title: 'Chocolate Chip Cookies',
                likes: 289,
                comments: 32
            },
            {
                id: 3,
                image: 'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?w=500&h=500&fit=crop',
                title: 'Strawberry Cheesecake',
                likes: 512,
                comments: 67
            },
            {
                id: 4,
                image: 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=500&h=500&fit=crop',
                title: 'Blueberry Muffins',
                likes: 198,
                comments: 28
            },
            {
                id: 5,
                image: 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=500&h=500&fit=crop',
                title: 'Vanilla Macarons',
                likes: 445,
                comments: 89
            },
            {
                id: 6,
                image: 'https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=500&h=500&fit=crop',
                title: 'Lemon Tart',
                likes: 276,
                comments: 41
            },
            {
                id: 7,
                image: 'https://images.unsplash.com/photo-1586985289906-406988974504?w=500&h=500&fit=crop',
                title: 'Chocolate Brownies',
                likes: 367,
                comments: 53
            },
            {
                id: 8,
                image: 'https://images.unsplash.com/photo-1509365390695-33c2a5b153f9?w=500&h=500&fit=crop',
                title: 'Cinnamon Rolls',
                likes: 421,
                comments: 72
            }
        ];

        // DUMMY DATA for liked recipes
        const dummyLikedRecipes = [
            {
                id: 9,
                image: 'https://images.unsplash.com/photo-1571115177098-24ec42ed204d?w=500&h=500&fit=crop',
                title: 'Tiramisu',
                likes: 634,
                comments: 91
            },
            {
                id: 10,
                image: 'https://images.unsplash.com/photo-1562440499-64c9a111f713?w=500&h=500&fit=crop',
                title: 'Apple Pie',
                likes: 502,
                comments: 78
            },
            {
                id: 11,
                image: 'https://images.unsplash.com/photo-1517427294546-5aa121f68e8a?w=500&h=500&fit=crop',
                title: 'Panna Cotta',
                likes: 389,
                comments: 56
            },
            {
                id: 12,
                image: 'https://images.unsplash.com/photo-1551024506-0bccd828d307?w=500&h=500&fit=crop',
                title: 'Caramel Flan',
                likes: 298,
                comments: 44
            }
        ];

        // DUMMY DATA for followers
        const dummyFollowers = [
            { id: 1, name: 'Emily Parker', username: 'emilyeats', avatar: 'https://i.pravatar.cc/150?img=1' },
            { id: 2, name: 'Michael Chen', username: 'chefmike', avatar: 'https://i.pravatar.cc/150?img=12' },
            { id: 3, name: 'Jessica Martinez', username: 'jessicabakes', avatar: 'https://i.pravatar.cc/150?img=9' },
            { id: 4, name: 'David Kim', username: 'davidscuisine', avatar: 'https://i.pravatar.cc/150?img=13' },
            { id: 5, name: 'Amanda Taylor', username: 'amandacooks', avatar: 'https://i.pravatar.cc/150?img=5' }
        ];

        // DUMMY DATA for following
        const dummyFollowing = [
            { id: 6, name: 'Chef Gordon', username: 'gordonbakes', avatar: 'https://i.pravatar.cc/150?img=33' },
            { id: 7, name: 'Baker\'s Delight', username: 'bakersdelight', avatar: 'https://i.pravatar.cc/150?img=27' },
            { id: 8, name: 'Sweet Tooth', username: 'sweettooth', avatar: 'https://i.pravatar.cc/150?img=20' }
        ];

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

            container.innerHTML = `
                <div class="profile-avatar-section">
                    <img src="${profile.avatar_img}" alt="Profile Avatar" class="profile-avatar">
                    
                    <div class="profile-actions">
                        <button class="follow-btn" id="followBtn" onclick="toggleFollow()">
                            <i class="bi bi-person-plus-fill"></i>
                            <span id="followText">Follow</span>
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
                        <div class="stat-item" onclick="showFollowers()">
                            <span class="stat-number">${profile.follower_count}</span>
                            <span class="stat-label">Followers</span>
                        </div>
                        <div class="stat-item" onclick="showFollowing()">
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

        // Load user recipes with dummy data
        function loadUserRecipes() {
            const container = document.getElementById('userRecipes');
            container.innerHTML = dummyRecipes.map(recipe => `
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

        // Load liked recipes with dummy data
        function loadLikedRecipes() {
            const container = document.getElementById('likedRecipes');
            container.innerHTML = dummyLikedRecipes.map(recipe => `
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

        // Load followers
        function loadFollowers() {
            const container = document.getElementById('followersList');
            container.innerHTML = dummyFollowers.map(user => `
                <div class="follow-user-item" onclick="viewUserProfile(${user.id})">
                    <img src="${user.avatar}" alt="${user.name}">
                    <div class="follow-user-info">
                        <div class="follow-user-name">${user.name}</div>
                        <div class="follow-user-username">@${user.username}</div>
                    </div>
                </div>
            `).join('');
        }

        // Load following
        function loadFollowing() {
            const container = document.getElementById('followingList');
            container.innerHTML = dummyFollowing.map(user => `
                <div class="follow-user-item" onclick="viewUserProfile(${user.id})">
                    <img src="${user.avatar}" alt="${user.name}">
                    <div class="follow-user-info">
                        <div class="follow-user-name">${user.name}</div>
                        <div class="follow-user-username">@${user.username}</div>
                    </div>
                </div>
            `).join('');
        }

        // Toggle follow
        function toggleFollow() {
            const btn = document.getElementById('followBtn');
            const text = document.getElementById('followText');
            const icon = btn.querySelector('i');
            
            if (btn.classList.contains('following')) {
                btn.classList.remove('following');
                icon.className = 'bi bi-person-plus-fill';
                text.textContent = 'Follow';
                showToast('Unfollowed successfully', 'success');
            } else {
                btn.classList.add('following');
                icon.className = 'bi bi-person-check-fill';
                text.textContent = 'Following';
                showToast('Following successfully', 'success');
            }
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

        // Show followers modal
        function showFollowers() {
            loadFollowers();
            const modal = new bootstrap.Modal(document.getElementById('followersModal'));
            modal.show();
        }

        // Show following modal
        function showFollowing() {
            loadFollowing();
            const modal = new bootstrap.Modal(document.getElementById('followingModal'));
            modal.show();
        }

        // View recipe
        function viewRecipe(recipeId) {
            console.log('Viewing recipe:', recipeId);
            showToast('Opening recipe...', 'info');
            // window.location.href = 'ViewRecipe.php?id=' + recipeId;
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
            loadUserRecipes();
            
            // Load liked recipes when tab is shown
            const likedTab = document.querySelector('[data-bs-target="#liked-tab"]');
            if (likedTab) {
                likedTab.addEventListener('shown.bs.tab', function() {
                    loadLikedRecipes();
                });
            }
        });
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