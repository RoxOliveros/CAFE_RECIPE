<?php

session_start();
$isLoggedIn = isset($_SESSION['user_id']); 

require_once 'config/database.php';
require_once 'getTopContributors.php';

$currentUser = null;
if ($isLoggedIn) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT user_id, username, display_name, avatar_img FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $currentUser = $result->fetch_assoc();
    $stmt->close();
}
$currentUserId = $isLoggedIn ? $_SESSION['user_id'] : null;
echo "<script>const currentUserId = " . ($currentUserId ? $currentUserId : 'null') . ";</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Creation</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="navbar.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="homepage-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="toast.css?v=<?php echo time(); ?>">

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
                        <a class="nav-link active" href="#">HOME</a>
                    </li>
                    <li class="nav-item flex-fill">
                        <a class="nav-link " href="Recipes.php">RECIPES</a>
                    </li>
                    <li class="nav-item flex-fill">
                        <a class="nav-link" href="<?php echo $isLoggedIn ? 'YourCreation.php' : 'Login.php'; ?>">YOUR CREATION</a>
                    </li>
                    <li class="nav-item flex-fill">
                        <a class="nav-link" href="AboutUs.php">ABOUT US</a>
                    </li>
                </ul>
            </div>

            
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="hamburger-menu" id="hamburgerMenu">
                    <?php if ($isLoggedIn && $currentUser): ?>
                        <!-- Logged-in menu: Profile, About Us, Logout -->
                        <a href="Profile.php?id=<?php echo $currentUser['user_id']; ?>" class="current-user profile-link">
                            <img src="<?php 
                                echo !empty($currentUser['avatar_img']) ? htmlspecialchars($currentUser['avatar_img']) : 
                                    'Asset/no-profile.jpg'; 
                            ?>" alt="Avatar" class="navbar-avatar">
                            <span class="navbar-username">
                                <?php echo htmlspecialchars($currentUser['display_name'] ?? $currentUser['username']); ?>
                            </span>
                        </a>
                        <a href="AboutUs.php">About Us</a>
                        <a href="#" class="login-link" onclick="logoutUser()">Logout</a>
                    <?php else: ?>
                        <!-- Non-logged-in menu: About Us, Login -->
                        <a href="AboutUs.php">About Us</a>
                        <a href="Login.php" class="login-link">Login</a>
                    <?php endif; ?>
                </div>
        </div>
    </nav>

    <!-- background home content -->
    <section class="bg-section">
        <div class="home-bg">
            <div class="bg-content">
                <h5>CREATE <span>YOUR</span></h5>
                <h1><span>SWEET</span> RECIPE</h1>

                <p>
                Sweet Creation is a recipe-sharing social platform designed specifically for dessert enthusiasts. Whether you're a professional pastry chef, a home baker, or someone who simply loves sweets, this is your space to express creativity through recipes.
                 </p>

                 <a href="AboutUs.php" class="learnmore-btn">LEARN MORE</a>

            </div>
        </div>
    </section>

    <!--how it works and top contributor-->
    <section class="how-it-works-section">
        <div class="container">
            <div class="row align-items-center">

                <!-- LEFT CONTENT -->
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <video class="img-fluid works-vid" autoplay muted loop playsinline>
                        <source src="Asset/homeshortclip.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                    <h2 class="works-title mt-4">
                        HOW SWEET<br>
                        <span>CREATION WORKS</span>
                    </h2>

                    <ul class="works-list">
                        <li><span>🍪</span> <strong>Create</strong> - Post your own recipe with photos</li>
                        <li><span>🍪</span> <strong>Share</strong> - Let others discover your creation</li>
                        <li><span>🍪</span> <strong>Save</strong> - Bookmark recipes you love</li>
                    </ul>
                </div>

                <!-- RIGHT CONTENT - TOP CONTRIBUTORS -->
                <div class="col-lg-6">
                    <p class="top-subtitle">UPDATED DAILY BY THE COMMUNITY</p>
                    <h2 class="top-title"><span>TOP</span> CONTRIBUTORS</h2>

                    <div class="top-list">
                        <?php if ($contributorCount === 0): ?>
                            <!-- No contributors yet -->
                            <div class="no-contributors">
                                <i class="bi bi-trophy"></i>
                                <p>
                                    No contributors yet.<br>
                                    Be the first to <a href="YourCreation.php">create a recipe</a>!
                                </p>
                            </div>
                        <?php else: ?>
                        <?php 
                        // Show top 3 slots (fill empty ones with placeholders)
                            for ($i = 0; $i < 3; $i++): 
                                if ($i < $contributorCount):
                                    $contributor = $topContributors[$i];
                                    $barWidth = ($contributor['recipe_count'] / $maxCount) * 100;
                                    $barWidth = max($barWidth, 30);
                                    
                                    $avatar = !empty($contributor['avatar_img'])
                                        ? htmlspecialchars($contributor['avatar_img'])
                                        : 'https://ui-avatars.com/api/?name=' 
                                            . urlencode($contributor['display_name'] ?? $contributor['username']) 
                                            . '&background=ff6b9d&color=fff&bold=true&size=128';

                                    $displayName = htmlspecialchars($contributor['display_name'] ?? $contributor['username']);
                        ?>
                        <div class="top-item" data-rank="<?php echo $i + 1; ?>">
                        <span class="num"><?php echo $i + 1; ?></span>
                        <button 
                            class="bar rank-<?php echo $i + 1; ?>" 
                            style="width: <?php echo $barWidth; ?>%;"
                            onclick="viewProfile(<?php echo $contributor['user_id']; ?>)"
                            title="View <?php echo $displayName; ?>'s profile">

                            <img src="<?php echo $avatar; ?>" 
                                    alt="<?php echo $displayName; ?>" 
                                    class="contributor-avatar"
                                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($displayName); ?>&background=ff6b9d&color=fff&bold=true';">
                            <span class="contributor-name"><?php echo $displayName; ?></span>
                            <span class="recipe-count">
                            <?php echo $contributor['recipe_count']; ?> 
                            <?php echo $contributor['recipe_count'] == 1 ? 'recipe' : 'recipes'; ?>
                            </span>
                        </button>
                        </div>
                        <?php else: ?>
                        <div class="top-item top-item-empty" data-rank="<?php echo $i + 1; ?>">
                            <span class="num num-empty"><?php echo $i + 1; ?></span>
                            <div class="bar bar-empty rank-<?php echo $i + 1; ?>">
                                <div class="contributor-avatar-placeholder">
                                    <i class="bi bi-question-circle"></i>
                                </div>
                                <span class="contributor-name">
                                    <?php 
                                        if ($contributorCount === 1) {
                                            echo $i === 1 ? "Second place awaits..." : "Third place awaits...";
                                        } else {
                                            echo "Third place awaits...";
                                        }
                                    ?>
                                </span>
                                <span class="recipe-count">0 recipes</span>
                            </div>
                        </div>
                        <?php 
                            endif;
                            endfor; 
                        ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- creator recommendation-->
    <section class="creator-reco-section">
        <div class="container">
            <div class="align-items-center text-center">
                <h2 class="creator-reco-title">
                    <span>CREATOR'S</span> RECOMMENDATIONS
                </h2>
            </div>

            <div class="carousel-wrapper">

                <button class="nav-btn left" onclick="moveSlide(-1)">
                    <i class="bi bi-chevron-left"></i>
                </button>

                <div class="carousel-viewport">
                    <div class="carousel-track" id="carouselTrack"></div>
                    <div id="noRecipesMessage" class="no-recipes-message" style="display:none;"></div>
                </div>

                <button class="nav-btn right" onclick="moveSlide(1)">
                    <i class="bi bi-chevron-right"></i>
                </button>

            </div>

            <!-- btns for desserts -->
            <div class="carousel-icons">
                <button class="icon-btn" data-category="cakes" data-tooltip="Cakes & Cupcakes">
                    <img src="Asset/cupcake.png" alt="Cupcake/Cake">
                </button>
                <button class="icon-btn" data-category="pies" data-tooltip="Pies & Tarts">
                    <img src="Asset/pie.png" alt="Pie/Tart">
                </button>
                <button class="icon-btn" data-category="frozen" data-tooltip="Frozen Desserts">
                    <img src="Asset/frozen.png" alt="Ice Cream">
                </button>
                <button class="icon-btn" data-category="custards" data-tooltip="Custards & Puddings">
                    <img src="Asset/pudding.png" alt="Pudding">
                </button>
                <button class="icon-btn" data-category="cookies" data-tooltip="Cookies & Bars">
                    <img src="Asset/cookies.png" alt="Cookie">
                </button>
            </div>
        </div>
    </section>

    <!-- our people section-->
    <section class="our-people-section">
        <div class="container">
            <div class="row align-items-center">

                <!-- LEFT : PERSON CARD -->
                <div class="col-lg-7 d-flex justify-content-center justify-content-lg-start">
                    <div class="people-card-wrapper">

                        <button class="people-nav left" onclick="peoplePrev()">
                            <i class="bi bi-chevron-left"></i>
                        </button>

                        <div class="people-card">
                            <img src="Asset/von.png" class="people-img" alt="Person">
                            <div class="people-info">
                                <h3>RESMA<br><span>JESTER VON</span></h3>
                                <p>BACK END DEV</p>
                            </div>
                        </div>

                        <div class="people-card">
                            <img src="Asset/rox1.png" class="people-img" alt="Person">
                            <div class="people-info">
                                <h3>OLIVEROS<br><span>ROXANNE</span></h3>
                                <p>FRONT END DEV</p>
                            </div>
                        </div>

                        <div class="people-card">
                            <img src="Asset/jobs1.png" class="people-img" alt="Person">
                            <div class="people-info">
                                <h3>ARAW<br><span>JOBEL</span></h3>
                                <p>FRONT END DEV</p>
                            </div>
                        </div>

                        <button class="people-nav right" onclick="peopleNext()">
                            <i class="bi bi-chevron-right"></i>
                        </button>

                    </div>
                </div>

                <!-- RIGHT : TEXT + AVATARS -->
                <div class="col-lg-5">
                    <h2 class="our-people-title">OUR <span>PEOPLE</span></h2>
                    <div class="people-texts">
                        <p class="our-people-text" data-index="0">Hi, I'm Von! The Back-end developer who builds and manages the logic behind Sweet Creation.</p>
                        <p class="our-people-text" data-index="1">Hi, I'm Rox! The Front-end developer focused on creating clean and user-friendly interfaces.</p>
                        <p class="our-people-text" data-index="2">Hi, I'm Jobs! The Front-end developer who ensures the site looks good and feels easy to use.</p>
                    </div>

                    <div class="people-avatars">
                        <img src="Asset/vonavatar.jpg" alt="Von">
                        <img src="Asset/roxavatar.jpg" alt="Rox">
                        <img src="Asset/jobelavatar.jpg" alt="Jobs">
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

    <!-- Navbar script -->
    <script src="toast.js"></script>
    <script>
         const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Hamburger menu toggle (enhanced)
    function toggleMenu(event) {
        event.preventDefault();  
        event.stopPropagation();  
        console.log("Hamburger clicked!"); 
        
        const menu = document.getElementById("hamburgerMenu");
        if (menu) {
            menu.classList.toggle("active");
            console.log("Menu active state:", menu.classList.contains("active"));  
        } else {
            console.error("Hamburger menu not found!");
        }
    }

    // Backup event listener for hamburger
    document.addEventListener('DOMContentLoaded', function() {
        const hamburger = document.querySelector('.hamburger');
        if (hamburger) {
            hamburger.addEventListener('click', toggleMenu);
            console.log("Event listener added to hamburger");
        } else {
            console.error("Hamburger element not found!");
        }
    });

    // Logout function
    function logoutUser() {
        const confirmLogout = confirm("Are you sure you want to logout?");
        
        if (confirmLogout) {
            document.getElementById("hamburgerMenu").classList.remove("active");
            window.location.href = "Logout.php";
        }
    }

    // Close menu when clicking any menu link EXCEPT logout
    document.querySelectorAll("#hamburgerMenu a").forEach(link => {
        link.addEventListener("click", () => {
            document.getElementById("hamburgerMenu").classList.remove("active");
        });
    });
    

        // carousel script
        document.addEventListener('DOMContentLoaded', () => {
            const track = document.getElementById('carouselTrack');
            const gap = 30;
            let cards = [];
            let isMoving = false;
            let autoplayInterval;

            let allRecipes = [];
            let currentCategory = 'all';

            const categoryButtons = document.querySelectorAll('.carousel-icons .icon-btn');

            // Fetch recipes
            fetch('get-recipes.php')
                .then(res => res.json())
                .then(data => {
                    allRecipes = data;
                    renderCarousel(filterRecipes(currentCategory));
                })
                .catch(err => console.error(err));

            // Category button click
            categoryButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    currentCategory = btn.getAttribute('data-category');
                    categoryButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    renderCarousel(filterRecipes(currentCategory));
                });
            });

            function filterRecipes(category) {
                return category === 'all' ? allRecipes : allRecipes.filter(r => r.category === category);
            }



            function updateCardScales() {
                const viewport = document.querySelector('.carousel-viewport');
                const cards = document.querySelectorAll('.food-card');
                
                if (!viewport || cards.length === 0) return;
                
                const viewportRect = viewport.getBoundingClientRect();
                const viewportCenter = viewportRect.left + viewportRect.width / 2;
                
                cards.forEach(card => {
                    const cardRect = card.getBoundingClientRect();
                    const cardCenter = cardRect.left + cardRect.width / 2;
                    const distance = Math.abs(viewportCenter - cardCenter);
                    const maxDistance = viewportRect.width / 2;
                    const normalizedDistance = Math.min(distance / maxDistance, 1);
                    const scale = 1.15 - (normalizedDistance * 0.15);
                    
                    card.style.transform = `scale(${scale})`;
                    card.style.zIndex = scale > 1.05 ? '10' : '1';
                    
                    card.style.opacity = 0.7 + (0.3 * (1 - normalizedDistance));
                });
            }

          function renderCarousel(recipes) {
                const messageEl = document.getElementById('noRecipesMessage');
                track.innerHTML = '';
                messageEl.style.display = 'none';

                if (recipes.length === 0) {
                    messageEl.innerHTML = `
                        No recipes yet for this category. 
                        <a href="YourCreation.php">Add your recipe!</a>
                    `;
                    messageEl.style.display = 'block';
                    cards = [];
                    return;
                }

    recipes.forEach(recipe => {
        const card = document.createElement('div');
        card.className = 'food-card';
        card.innerHTML = `
            <div class="recipe-image-container">
                <img src="${recipe.image}" alt="${recipe.title}">
            </div>
            <div class="recipe-content">
                <h5 class="card-title">${recipe.title}</h5>
                <div class="recipe-creator">
                    <img src="${recipe.creatorAvatar || 'Asset/no-profile.jpg'}" 
                         alt="${recipe.creator}" 
                         class="creator-avatar"
                         onclick="viewProfile(event, ${recipe.creatorId})">
                    <span class="creator-name" onclick="viewProfile(event, ${recipe.creatorId})">${recipe.creator}</span>
                </div>
                <div class="recipe-stats">
                    <div class="stat-item">
                        <i class="bi bi-heart-fill"></i>
                        <span class="likes-count">${recipe.likes || 0}</span>
                    </div>
                    <div class="stat-item">
                        <i class="bi bi-chat-fill"></i>
                        <span>${recipe.comments || 0}</span>
                    </div>
                </div>
                <p class="recipe-description">${recipe.description || 'A delicious dessert recipe'}</p>
                <div class="recipe-footer">
                    <div class="recipe-time">
                        <i class="bi bi-clock"></i>
                        <span>${recipe.time || '30 mins'}</span>
                    </div>
                    <button class="readmore-btn" onclick="viewRecipe(${recipe.id})">View Recipe</button>
                </div>
            </div>
        `;
        track.appendChild(card);
    });

    cards = [...track.children];
    track.style.transform = 'translateX(0)';
    track.style.transition = 'none';
    
    setTimeout(() => {
        updateCardScales();
    }, 100);
    
    startAutoplay();
}

// Also call on window resize
window.addEventListener('resize', updateCardScales);

    function viewProfile(event, userId) {
    event.stopPropagation();
    
    if (!currentUserId || currentUserId === null) {
        window.location.href = 'Other-Profile.php?id=' + userId;  
        return;
    }
    
    // For logged-in users, check if viewing own profile
    if (userId === currentUserId) {
        window.location.href = 'Profile.php?id=' + userId;
    } else {
        window.location.href = 'Other-Profile.php?id=' + userId;
    }
}

            function cardWidth() {
                return cards[0] ? cards[0].offsetWidth + gap : 0;
            }

            function moveNext() {
                if (isMoving || cards.length === 0) return;
                isMoving = true;
                
                const w = cardWidth();
                
                track.style.transition = 'transform 0.5s ease';
                track.style.transform = `translateX(-${w}px)`;

                setTimeout(() => {
                    track.appendChild(track.firstElementChild);
                    cards = [...track.children];
                    
                    track.style.transition = 'none';
                    track.style.transform = 'translateX(0)';
                    
                    updateCardScales();
                    
                    setTimeout(() => {
                        isMoving = false;
                    }, 50);
                }, 500);
            }

            function movePrev() {
                if (isMoving || cards.length === 0) return;
                isMoving = true;

                const w = cardWidth();
                
                track.style.transition = 'none';
                track.prepend(track.lastElementChild);
                cards = [...track.children];
                
                track.style.transform = `translateX(-${w}px)`;
                track.offsetHeight;

                setTimeout(() => {
                    track.style.transition = 'transform 0.5s ease';
                    track.style.transform = 'translateX(0)';
                    
                    setTimeout(() => {
                        updateCardScales();
                        isMoving = false;
                    }, 500);
                }, 50);
            }

            function startAutoplay() {
                stopAutoplay();
                autoplayInterval = setInterval(moveNext, 5000);
            }

            function stopAutoplay() {
                if (autoplayInterval) clearInterval(autoplayInterval);
            }

            window.moveSlide = function(dir) {
                stopAutoplay();
                dir === 1 ? moveNext() : movePrev();
                setTimeout(startAutoplay, 500);
            }

            window.viewRecipe = function(id) {
                window.location.href = `ViewRecipe.php?id=${id}`;
            }

            track.addEventListener('mouseenter', stopAutoplay);
            track.addEventListener('mouseleave', startAutoplay);
            window.addEventListener('resize', () => {
                // Reset position on resize
                track.style.transition = 'none';
                track.style.transform = 'translateX(0)';
            });
        });


        /* our people script */
        const avatarButtons = document.querySelectorAll(".people-avatars img");
        const peopleCards = document.querySelectorAll(".people-card");
        const peopleTexts = document.querySelectorAll(".our-people-text");

        let currentIndex = 0;

        function showPerson(index) {
            peopleCards.forEach((card, i) => {
                card.style.display = i === index ? "block" : "none";
            });

            avatarButtons.forEach((avatar, i) => {
                avatar.style.opacity = i === index ? "1" : "0.5";
                avatar.style.transform = i === index ? "scale(1.1)" : "scale(1)";
            });

            peopleTexts.forEach((text, i) => {
                text.style.display = i === index ? "block" : "none";
            });

            currentIndex = index;
        }


        // Click avatars to change person
        avatarButtons.forEach((avatar, index) => {
            avatar.style.cursor = "pointer";
            avatar.addEventListener("click", () => {
                showPerson(index);
            });
        });

        function peopleNext() {
            currentIndex = (currentIndex + 1) % peopleCards.length;
            showPerson(currentIndex);
        }

        function peoplePrev() {
            currentIndex = (currentIndex - 1 + peopleCards.length) % peopleCards.length;
            showPerson(currentIndex);
        }
        showPerson(0);

    </script>
</body>
</html>