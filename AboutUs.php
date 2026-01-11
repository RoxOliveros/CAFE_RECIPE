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
    <link rel="stylesheet" href="aboutus-style.css"> 
</head>

<body>

    <!--navbar-->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container d-flex align-items-center">

            <!-- LOGO -->
            <a class="navbar-brand me-auto" href="#">
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
             <!-- Current User Display -->
                <a href="Profile.php" class="current-user profile-link">
                    <img src="<?php session_start();
                        echo !empty($_SESSION['avatar_img']) ? htmlspecialchars($_SESSION['avatar_img']) : 
                            'https://ui-avatars.com/api/?name=' . urlencode($_SESSION['display_name'] ?? $_SESSION['username']) . '&background=ff6b9d&color=fff&bold=true&size=40'; 
                    ?>" alt="Avatar" class="navbar-avatar">
                    <span class="navbar-username">
                        <?php echo htmlspecialchars($_SESSION['display_name'] ?? $_SESSION['username']); ?>
                    </span>
                    </a>

                <a href="AboutUs.php">About Us</a>
                <a href="#" class="login-link" onclick="logoutUser()">Logout</a>
            </div>
        </div>
    </nav>

    <!-- ABOUT US SECTION -->
    <section class="about-section">
        <div class="container">
            
            <!-- HERO -->
            <div class="about-hero">
                <h1 class="about-title">About Sweet Creation</h1>
                <p class="about-subtitle">
                    A community-driven platform where bakers and dessert lovers come together to share, discover, and celebrate the art of sweet making.
                </p>
            </div>

            <!-- CONTENT CARDS -->
            <div class="content-container">
                
                <!-- WHAT IS SWEET CREATION -->
                <div class="content-card">
                    <div class="card-icon">
                        <i class="bi bi-cake2"></i>
                    </div>
                    <h2 class="card-title">What is Sweet Creation?</h2>
                    <p class="card-text">
                        Sweet Creation is a <strong>recipe-sharing social platform</strong> designed specifically for dessert enthusiasts. Whether you're a professional pastry chef, a home baker, or someone who simply loves sweets, this is your space to express creativity through recipes.
                    </p>
                    <p class="card-text">
                        Our platform allows you to <strong>post your original recipes</strong>, complete with photos and videos, share them with the community, and discover countless delicious creations from bakers around the world. From classic chocolate chip cookies to elaborate wedding cakes, every sweet creation has a home here.
                    </p>
                    
                    <div class="features-grid">
                        <div class="feature-item">
                            <div class="feature-icon">📝</div>
                            <div class="feature-title">Create & Share</div>
                            <div class="feature-text">Post your recipes with detailed instructions and beautiful photos</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">🔍</div>
                            <div class="feature-title">Discover</div>
                            <div class="feature-text">Browse thousands of sweet recipes from the community</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">💬</div>
                            <div class="feature-title">Connect</div>
                            <div class="feature-text">Engage with fellow bakers through comments and likes</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">📚</div>
                            <div class="feature-title">Save</div>
                            <div class="feature-text">Bookmark your favorite recipes to try later</div>
                        </div>
                    </div>
                </div>

                <!-- WHY DOES IT EXIST -->
                <div class="content-card">
                    <div class="card-icon">
                        <i class="bi bi-lightbulb"></i>
                    </div>
                    <h2 class="card-title">Why Does It Exist?</h2>
                    <p class="card-text">
                        We created Sweet Creation because we believe that <strong>every baker deserves a platform</strong> to showcase their talents and passion. Too often, amazing recipes get lost in general cooking websites or buried in social media feeds.
                    </p>
                    <p class="card-text">
                        Sweet Creation exists to:
                    </p>
                    <div class="card-text" style="padding-left: 25px;">
                        • <strong>Preserve culinary creativity</strong> - Your recipes deserve to be documented and shared properly<br>
                        • <strong>Build community</strong> - Connect with others who share your passion for baking<br>
                        • <strong>Inspire innovation</strong> - Discover new techniques and flavor combinations<br>
                        • <strong>Make baking accessible</strong> - Help beginners learn from experienced bakers<br>
                        • <strong>Celebrate sweet moments</strong> - Because desserts bring joy to life's special occasions
                    </div>
                    
                    <div class="highlight-box">
                        <p>"We believe that sharing recipes is sharing love, and every sweet creation has a story worth telling."</p>
                    </div>
                </div>

                <!-- WHO IS IT FOR -->
                <div class="content-card">
                    <div class="card-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h2 class="card-title">Who is it for?</h2>
                    <p class="card-text">
                        Sweet Creation is designed for <strong>everyone who loves desserts</strong>, regardless of skill level or experience:
                    </p>
                    
                    <div class="features-grid">
                        <div class="feature-item">
                            <div class="feature-icon">👨‍🍳</div>
                            <div class="feature-title">Professional Bakers</div>
                            <div class="feature-text">Share your expertise and build your personal brand in the baking community</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">🏠</div>
                            <div class="feature-title">Home Bakers</div>
                            <div class="feature-text">Document your favorite family recipes and discover new ones to try</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">🌟</div>
                            <div class="feature-title">Beginners</div>
                            <div class="feature-text">Learn from the community and build confidence with step-by-step recipes</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">🍰</div>
                            <div class="feature-title">Dessert Lovers</div>
                            <div class="feature-text">Find and save recipes for every occasion, from simple treats to show-stoppers</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">📸</div>
                            <div class="feature-title">Food Bloggers</div>
                            <div class="feature-text">Expand your reach and connect with a dedicated baking audience</div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">🎓</div>
                            <div class="feature-title">Students</div>
                            <div class="feature-text">Practice your skills and get feedback from experienced bakers</div>
                        </div>
                    </div>

                    <div class="highlight-box" style="margin-top: 30px;">
                        <p>"Whether you're baking for a special occasion, running a bakery, or just exploring a new hobby - Sweet Creation is your community."</p>
                    </div>
                </div>

                <!-- CTA -->
                <div class="cta-section">
                    <h2 class="cta-title">Ready to Share Your Sweet Creations?</h2>
                    <p class="cta-text">Join our community of passionate bakers and dessert lovers today!</p>
                    <button class="cta-btn" onclick="window.location.href='Recipes.php'">Explore Recipes</button>
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

     // menubar
    // Close hamburger menu
function toggleMenu() {
    const menu = document.getElementById("hamburgerMenu");
    menu.classList.toggle("active");
}

// Logout function (GLOBAL)
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
</script>
</body>
</html>