<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);

require_once 'config/database.php';

$currentUser = null;

if ($isLoggedIn) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare(
        "SELECT user_id, username, display_name, avatar_img FROM users WHERE user_id = ?"
    );
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $currentUser = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

$currentUserId = $isLoggedIn ? $_SESSION['user_id'] : null;

echo "<script>
    const currentUserId = " . ($currentUserId !== null ? $currentUserId : 'null') . ";
    const isLoggedIn = " . ($isLoggedIn ? 'true' : 'false') . ";
</script>";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Creation - About Us</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="navbar.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="aboutus-style.css?v=<?php echo time(); ?>"> 
    <link rel="stylesheet" href="toast-notifications.css">
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
                        <a class="nav-link" href="#" onclick="viewYourCreation()">YOUR CREATION</a>
                    </li>
                    <li class="nav-item flex-fill">
                        <a class="nav-link active" href="#">ABOUT US</a>
                    </li>
                </ul>
            </div>

            <div class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="hamburger-menu" id="hamburgerMenu">
                <?php if ($isLoggedIn && $currentUser): ?>
                    <!-- Logged-in -->
                    <a href="Profile.php?id=<?php echo $currentUser['user_id']; ?>" class="current-user profile-link">
                        <img src="<?php echo !empty($currentUser['avatar_img']) 
                            ? htmlspecialchars($currentUser['avatar_img']) 
                            : 'Asset/no-profile.jpg'; ?>" 
                            class="navbar-avatar">
                        <span class="navbar-username">
                            <?php echo htmlspecialchars($currentUser['display_name'] ?? $currentUser['username']); ?>
                        </span>
                    </a>

                    <a href="AboutUs.php">About Us</a>
                    <a class="login-link" onclick="logoutUser()">Logout</a>

                <?php else: ?>
                    <!-- Guest -->
                    <a href="AboutUs.php">About Us</a>
                    <a href="Login.php">Login</a>
                <?php endif; ?>
            </div>

        </div>
    </nav>

    <!-- ABOUT US SECTION -->
    <section class="about-section">
        <div class="container">
            
            <!-- HERO -->
            <div class="about-hero">
                <div class="hero-badge">ABOUT SWEET CREATION</div>
                <h1 class="about-title">Bringing Bakers Together</h1>
                <p class="about-subtitle">
                    A community-driven platform where bakers and dessert enthusiasts share, discover, and celebrate the art of sweet making.
                </p>
            </div>

            <!-- STATS BAR -->
            <div class="stats-bar">
                <div class="stat-item">
                    <i class="bi bi-people-fill stat-icon"></i>
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Community Members</div>
                </div>
                <div class="stat-item">
                    <i class="bi bi-journal-bookmark-fill stat-icon"></i>
                    <div class="stat-number">50K+</div>
                    <div class="stat-label">Recipes Shared</div>
                </div>
                <div class="stat-item">
                    <i class="bi bi-heart-fill stat-icon"></i>
                    <div class="stat-number">1M+</div>
                    <div class="stat-label">Recipe Saves</div>
                </div>
                <div class="stat-item">
                    <i class="bi bi-star-fill stat-icon"></i>
                    <div class="stat-number">4.8/5</div>
                    <div class="stat-label">User Rating</div>
                </div>
            </div>

            <!-- CONTENT CARDS -->
            <div class="content-container">
                
                <!-- WHAT IS SWEET CREATION -->
                <div class="content-card">
                    <div class="card-header">
                        <div class="card-icon-wrapper">
                            <i class="bi bi-cake2-fill"></i>
                        </div>
                        <h2 class="card-title">What is Sweet Creation?</h2>
                    </div>
                    <p class="card-text">
                        Sweet Creation is a dedicated recipe-sharing platform designed specifically for dessert enthusiasts. Whether you're a professional pastry chef, a home baker, or someone who simply loves sweets, this is your space to express creativity through recipes.
                    </p>
                    <p class="card-text">
                        Our platform empowers you to post your original recipes complete with photos and videos, share them with a passionate community, and discover countless delicious creations from bakers worldwide. From classic chocolate chip cookies to elaborate wedding cakes, every sweet creation has a home here.
                    </p>
                    
                    <div class="features-grid">
                        <div class="feature-card">
                            <div class="feature-icon-box">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <h3 class="feature-title">Create & Share</h3>
                            <p class="feature-text">Post your recipes with detailed instructions, beautiful photos, and step-by-step guides</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon-box">
                                <i class="bi bi-search"></i>
                            </div>
                            <h3 class="feature-title">Discover</h3>
                            <p class="feature-text">Browse thousands of sweet recipes from our global community of bakers</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon-box">
                                <i class="bi bi-chat-dots-fill"></i>
                            </div>
                            <h3 class="feature-title">Connect</h3>
                            <p class="feature-text">Engage with fellow bakers through comments, ratings, and collaborative feedback</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon-box">
                                <i class="bi bi-bookmark-fill"></i>
                            </div>
                            <h3 class="feature-title">Save & Organize</h3>
                            <p class="feature-text">Bookmark your favorite recipes and create personalized collections to try later</p>
                        </div>
                    </div>
                </div>

                <!-- WHY DOES IT EXIST -->
                <div class="content-card mission-card">
                    <div class="card-header">
                        <div class="card-icon-wrapper">
                            <i class="bi bi-lightbulb-fill"></i>
                        </div>
                        <h2 class="card-title">Our Mission</h2>
                    </div>
                    <p class="card-text">
                        We created Sweet Creation because we believe every baker deserves a dedicated platform to showcase their talents and passion. Too often, amazing recipes get lost in general cooking websites or buried in social media feeds.
                    </p>
                    
                    <div class="mission-grid">
                        <div class="mission-item">
                            <div class="mission-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="mission-content">
                                <h3>Preserve Culinary Creativity</h3>
                                <p>Your recipes deserve to be properly documented and shared with those who appreciate them</p>
                            </div>
                        </div>
                        <div class="mission-item">
                            <div class="mission-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="mission-content">
                                <h3>Build Community</h3>
                                <p>Connect with others who share your passion for baking and sweet creation</p>
                            </div>
                        </div>
                        <div class="mission-item">
                            <div class="mission-icon">
                                <i class="bi bi-lightbulb"></i>
                            </div>
                            <div class="mission-content">
                                <h3>Inspire Innovation</h3>
                                <p>Discover new techniques, flavor combinations, and creative approaches to desserts</p>
                            </div>
                        </div>
                        <div class="mission-item">
                            <div class="mission-icon">
                                <i class="bi bi-book"></i>
                            </div>
                            <div class="mission-content">
                                <h3>Make Baking Accessible</h3>
                                <p>Help beginners learn from experienced bakers through detailed, easy-to-follow recipes</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="quote-box">
                        <div class="quote-icon">
                            <i class="bi bi-quote"></i>
                        </div>
                        <p class="quote-text">We believe that sharing recipes is sharing love, and every sweet creation has a story worth telling.</p>
                    </div>
                </div>

                <!-- WHO IS IT FOR -->
                <div class="content-card">
                    <div class="card-header">
                        <div class="card-icon-wrapper">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h2 class="card-title">Who is Sweet Creation For?</h2>
                    </div>
                    <p class="card-text">
                        Our platform is designed for everyone who loves desserts, regardless of skill level or experience. Sweet Creation welcomes:
                    </p>
                    
                    <div class="audience-grid">
                        <div class="audience-card">
                            <div class="audience-icon">
                                <i class="bi bi-award-fill"></i>
                            </div>
                            <h3 class="audience-title">Professional Bakers</h3>
                            <p class="audience-text">Share your expertise, build your brand, and connect with clients in the baking community</p>
                        </div>
                        <div class="audience-card">
                            <div class="audience-icon">
                                <i class="bi bi-house-heart-fill"></i>
                            </div>
                            <h3 class="audience-title">Home Bakers</h3>
                            <p class="audience-text">Document your favorite family recipes and discover new ones to master in your kitchen</p>
                        </div>
                        <div class="audience-card">
                            <div class="audience-icon">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                            <h3 class="audience-title">Beginners</h3>
                            <p class="audience-text">Learn from the community and build confidence with clear, step-by-step recipes</p>
                        </div>
                        <div class="audience-card">
                            <div class="audience-icon">
                                <i class="bi bi-heart-fill"></i>
                            </div>
                            <h3 class="audience-title">Dessert Enthusiasts</h3>
                            <p class="audience-text">Find and save recipes for every occasion, from simple treats to show-stopping centerpieces</p>
                        </div>
                        <div class="audience-card">
                            <div class="audience-icon">
                                <i class="bi bi-camera-fill"></i>
                            </div>
                            <h3 class="audience-title">Content Creators</h3>
                            <p class="audience-text">Expand your reach and connect with a dedicated audience passionate about baking</p>
                        </div>
                        <div class="audience-card">
                            <div class="audience-icon">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <h3 class="audience-title">Culinary Students</h3>
                            <p class="audience-text">Practice your skills, build your portfolio, and get feedback from experienced professionals</p>
                        </div>
                    </div>
                </div>

                <!-- CTA -->
                <div class="cta-section">
                    <div class="cta-content">
                        <h2 class="cta-title">Ready to Share Your Sweet Creations?</h2>
                        <p class="cta-text">Join our community of passionate bakers and dessert lovers today</p>
                        <div class="cta-buttons">
                            <button class="cta-btn primary" onclick="createRecipe()">
                                <i class="bi bi-plus-circle"></i>
                                Create Recipe
                            </button>
                            <button class="cta-btn secondary" onclick="window.location.href='Recipes.php'">
                                <i class="bi bi-grid-3x3-gap"></i>
                                Explore Recipes
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

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

    <script src="toast-notifications.js" defer></script>
    <script>
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
            showConfirmation("Are you sure you want to logout?", () => {
            
                const loadingToast = showLoading('Logging out...', 'Please wait');

                setTimeout(() => {
                    loadingToast.close();
                    showSuccess("You have logged out successfully! 🎉");

                    setTimeout(() => {
                        document.getElementById("hamburgerMenu").classList.remove("active");
                        window.location.href = "Logout.php";
                    }, 1500);
                }, 1500);
            });
        }

        // Close menu when clicking any menu link EXCEPT logout
        document.querySelectorAll("#hamburgerMenu a").forEach(link => {
            link.addEventListener("click", () => {
                document.getElementById("hamburgerMenu").classList.remove("active");
            });
        });

        function requireLogin(message = "Please login to continue.") {
            showWarning(message, "Login Required");
            setTimeout(() => {
                window.location.href = "Login.php";
            }, 1500); // let toast show first
        }

        function viewYourCreation() {
            if (!isLoggedIn) {
                requireLogin("You need to login to view your creations.");
                return;
            }
            
            window.location.href = 'YourCreation.php';
        }

        function createRecipe() {
            if (!isLoggedIn) {
                requireLogin("You need to login to create a recipe.");
                return;
            }
            
            window.location.href = 'AddRecipe.php';
        }
    </script>
</body>
</html>