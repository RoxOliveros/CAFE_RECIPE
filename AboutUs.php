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

    <style>
        body {
            background-color: #f9f4e9;
            font-family: 'Fredoka', sans-serif;
        }

        /*NAVBAR*/
        .navbar {
            background-color: transparent;
            transition: all 0.4s ease-in-out;
        }

        .navbar.scrolled {
            background-color: rgba(255, 243, 224, 0.9) !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 5px 0;
        }

        .navbar-nav .nav-link {
            color: #b08261 !important;
            font-weight: 700;
            font-size: 18px;
            text-transform: uppercase;
            padding: 8px 0 !important;
            margin: 0 15px;
            position: relative;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0;
            height: 3px;
            background-color: #6b300a;
            transition: width 0.3s ease;
        }

        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #6b300a !important;
            background-color: transparent !important;
        }

        .btn-login {
            background-color: #a85a1a;
            color: #fff;
            border-radius: 999px;
            padding: 10px 28px;
            font-size: 14px;
            font-weight: 700;
            border: none;
            transition: transform 0.2s ease;
        }

        .btn-login:hover {
            background-color: #8f4a14;
            color: #fff;
            transform: scale(1.05);
        }

        /* ABOUT US SECTION */
        .about-section {
            padding-top: 150px;
            padding-bottom: 80px;
        }

        .about-hero {
            text-align: center;
            margin-bottom: 80px;
        }

        .about-title {
            font-size: 58px;
            font-weight: 900;
            color: #8f4a14;
            margin-bottom: 20px;
        }

        .about-subtitle {
            font-size: 20px;
            color: #b08261;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* CONTENT CARDS */
        .content-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .content-card {
            background: #fff;
            border-radius: 30px;
            padding: 50px;
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }

        .card-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #f9f4e9 0%, #faf7f2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
        }

        .card-icon i {
            font-size: 40px;
            color: #c89b52;
        }

        .card-title {
            font-size: 32px;
            font-weight: 800;
            color: #6b300a;
            margin-bottom: 20px;
        }

        .card-text {
            font-size: 16px;
            color: #8f4a14;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .card-text strong {
            color: #6b300a;
        }

        /* HIGHLIGHT BOX */
        .highlight-box {
            background: #faf7f2;
            border-left: 4px solid #c89b52;
            padding: 20px 25px;
            border-radius: 12px;
            margin-top: 20px;
        }

        .highlight-box p {
            margin: 0;
            font-size: 15px;
            color: #8f4a14;
            font-style: italic;
        }

        /* FEATURES GRID */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .feature-item {
            background: #faf7f2;
            padding: 25px;
            border-radius: 16px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-3px);
            background: #f9f4e9;
        }

        .feature-icon {
            font-size: 36px;
            color: #c89b52;
            margin-bottom: 15px;
        }

        .feature-title {
            font-size: 18px;
            font-weight: 700;
            color: #6b300a;
            margin-bottom: 10px;
        }

        .feature-text {
            font-size: 14px;
            color: #8f4a14;
            line-height: 1.6;
        }

        /* CTA SECTION */
        .cta-section {
            background: linear-gradient(135deg, #c89b52 0%, #a85a1a 100%);
            border-radius: 30px;
            padding: 60px 40px;
            text-align: center;
            margin-top: 60px;
            box-shadow: 0 8px 30px rgba(200, 155, 82, 0.3);
        }

        .cta-title {
            font-size: 36px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 15px;
        }

        .cta-text {
            font-size: 18px;
            color: #fff3e0;
            margin-bottom: 30px;
        }

        .cta-btn {
            background: #fff;
            color: #8f4a14;
            border: none;
            border-radius: 50px;
            padding: 15px 40px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        /* FOOTER */
        .custom-footer {
            background-color: #c79850;
            border-radius: 50px 50px 0 0;
            margin-top: 80px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .about-title {
                font-size: 40px;
            }

            .content-card {
                padding: 30px 25px;
            }

            .card-title {
                font-size: 26px;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .cta-section {
                padding: 40px 25px;
            }

            .cta-title {
                font-size: 28px;
            }
        }
    </style>
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

            <!-- LOGIN -->
            <div class="d-none d-lg-block ms-auto">
                <button class="btn-login">LOGIN</button>
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

    <style>
    .custom-footer a:hover {
        color: #fff !important;
        transform: translateX(3px);
    }

    .custom-footer .social-link:hover {
        background: rgba(255,255,255,0.4) !important;
        transform: scale(1.1) !important;
    }
    </style>

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
    </script>

</body>
</html>