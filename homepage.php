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

        /*home*/
        .bg-section {
            max-width: 1300px;
            margin: 100px auto 0;
            overflow: hidden;
            margin-top: 60px;
        }

        .home-bg {
            background-image: url("Asset/BGHome.png");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 670px;
            position: relative;
        }

        /* Home bg Content */
        .bg-content {
            position: relative;
            z-index: 2;
            padding: 60px 70px 60px 120px;
            max-width: 650px;
            color: #6b300a;
            margin-left: 30px;
        }

            .bg-content h5 {
                letter-spacing: 6px;
                font-size: 30px;
                font-weight: 700;
                margin-top: 150px;
            }

            .bg-content span {
                color: #fff3e0;
            }

            .bg-content h1 {
                font-size: 52px;
                font-weight: 700;
                margin-bottom: 20px;
            }

            .bg-content p {
                background-color: rgba(255, 243, 224, 0.5);
                padding: 14px 18px;
                border-radius: 12px;
                font-size: 13px;
                margin-bottom: 22px;
                color: #4a2a14;
            }


        /*how it works*/
        .how-it-works-section {
            background-color: #fbf6eb;
            padding: 100px 0;
            margin-left: 120px;
        }

        .works-vid {
            border-radius: 20px;
            max-width: 400px;
        }

        .works-title {
            font-weight: 800;
            font-size: 32px;
            color: #6b300a;
        }

        .how-it-works-section span {
            color: #d09245;
        }

        .works-list {
            list-style: none;
            padding: 0;
            margin-top: 25px;
        }

            .works-list li {
                font-size: 14px;
                color: #6b300a;
                margin-bottom: 14px;
            }

            .works-list span {
                margin-right: 8px;
            }

        /*popular creations*/
        .popular-subtitle {
            font-size: 20px;
            letter-spacing: 2px;
            color: #6b300a;
            font-weight: 600;
        }

        .popular-title {
            font-size: 40px;
            font-weight: 800;
            color: #6b300a;
            margin-bottom: 40px;
        }

        .popular-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .popular-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

            .popular-item .num {
                width: 32px;
                height: 32px;
                background: #b56a2d;
                color: #fff;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 14px;
            }

            .popular-item .bar {
                width: 400px;
                height: 80px;
                background-color: #d2a35c;
                border-radius: 30px;
                flex: none;
            }

                .popular-item .bar:hover {
                    background-color: #836241;
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                    transform: translateY(-6px) scale(1);
                }

        /*pagination*/
        .pagination {
            margin-top: 30px;
            display: flex;
            gap: 20px;
            align-items: center;
            color: #6b300a;
            font-weight: 600;
            margin-left: 210px;
        }

            .pagination span {
                cursor: pointer;
            }


        /*Creator's Recommendation*/
        .creator-reco-section span {
            color: #d09245;
        }

        .creator-reco-title {
            font-size: 48px;
            font-weight: 800;
            letter-spacing: 2px;
            color: #6b300a;
        }

        /*Carousel*/
        /*creator recommendation*/

        .carousel-wrapper {
            position: relative;
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .carousel-viewport {
            width: calc(250px * 3 + 40px * 2);
            overflow-x: hidden;
            overflow-y: visible;
            display: flex;
            align-items: center;
            padding: 40px 0;
        }

        .carousel-track {
            display: flex;
            gap: 30px;
            transition: transform 0.5s ease;
        }

        .carousel-track.no-transition {
            transition: none;
        }

        .food-card {
            flex: 0 0 250px;
            height: 340px;
            background: #e6c18b;
            border-radius: 40px;
            padding: 20px;
            text-align: center;
            opacity: 0.6;
            transform: scale(0.85);
            transform-origin: center;
            transition: all 0.5s ease;
            position: relative;
        }

            .food-card img {
                width: 100%;
                height: 230px;
                object-fit: cover;
                border-radius: 24px;
            }

            .food-card.active {
                background: #d18d42;
                opacity: 1;
                transform: scale(1.15);
                transform-origin: center center;
                z-index: 3;
            }

        .card-title {
            font-size: 20px;
            font-weight: 600;
            color: #fff;
        }

        .readmore-btn {
            border: 2px solid #6b300a;
            background: transparent;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            color: #6b300a;
            margin-top: 10px;
        }

        .readmore-btn:hover {
            background-color: #6b4a2a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .favorite-btn {
            position: absolute;
            top: 260px;
            right: 200px;
            width: 40px;
            height: 40px;
            background: transparent;
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

            .favorite-btn i {
                font-size: 25px;
                color: #fff;
            }

            .favorite-btn.active {
                background: #6b300a;
            }

                .favorite-btn.active i {
                    color: #e74c3c;
                }

            .favorite-btn:hover {
                transform: scale(1.1);
            }

        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: #c49a6c;
            border: none;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            color: white;
            z-index: 10;
        }

            .nav-btn.left {
                left: 90px;
            }

            .nav-btn.right {
                right: 110px;
            }

        .carousel-icons {
            display: flex;
            justify-content: center;
            gap: 70px;
            margin-top: 30px;
        }

        .icon-btn {
            background: transparent;
            border: none;
            padding: 0;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .icon-btn img {
            width: 80px;
            height: auto;
            opacity: 0.85;
        }

        .icon-btn:hover {
            transform: translateY(-6px) scale(1.1);
        }

        .icon-btn:hover img {
            opacity: 1;
        }

        /*our people*/
        .our-people-section {
            padding: 110px 0px;
            background: #f9f4e9;
            margin-left: 130px;
        }

        .people-card-wrapper {
            position: relative;
            width: 100%;
            max-width: 610px;
        }

        .people-card {
            background: #c89b52;
            border-radius: 40px;
            padding: 50px 60px;
            height: 260px;
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .people-img {
            height: 370px;
            position: absolute;
            left: 30px;
            bottom: 0;
        }

        .people-info {
            margin-left: 260px;
        }

            .people-info h3 {
                font-size: 30px;
                font-weight: 600;
                color: #fff;
                line-height: 1.1;
                margin-top: 150px;
            }

                .people-info h3 span {
                    font-weight: 700;
                    font-size: 40px;
                }

            .people-info p {
                font-size: 10px;
                letter-spacing: 2px;
                font-weight: 700;
                color: #fff3e0;
            }

        .people-nav {
            position: absolute;
            top: 50%;
            font-size: 30px;
            transform: translateY(-50%);
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: none;
            color: #c89b52;
            background-color: #e6e6e6;
        }

            .people-nav.left {
                left: -20px;
            }

            .people-nav.right {
                right: -20px;
            }

            .people-nav:hover {
                background: #a87434;
            }

        /*right side content*/
        .our-people-title {
            font-size: 42px;
            font-weight: 900;
            color: #c89b52;
        }

        .our-people-text {
            font-size: 14px;
            color: #a87434;
            max-width: 360px;
            margin-bottom: 25px;
        }

        .people-avatars {
            display: flex;
            gap: 18px;
        }

            .people-avatars img {
                width: 58px;
                height: 58px;
                border-radius: 50%;
                border: 3px solid #c89b52;
                object-fit: cover;
            }

        /*footer*/
        .custom-footer {
            background-color: #c79850;
            border-radius: 50px 50px 0 0;
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
                        <a class="nav-link active" href="#">HOME</a>
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

            <!-- LOGIN -->
            <div class="d-none d-lg-block ms-auto">
                <button class="btn-login">LOGIN</button>
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

            </div>
        </div>
    </section>

    <!--how it works and popular creations-->
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

                <!-- RIGHT CONTENT -->
                <div class="col-lg-6">
                    <p class="popular-subtitle">UPDATED DAILY BY THE COMMUNITY</p>
                    <h2 class="popular-title"><span>POPULAR</span> CREATIONS</h2>

                    <div class="popular-list">
                        <div class="popular-item">
                            <span class="num">1</span>
                            <button class="bar" onclick=""></button>
                        </div>
                        <div class="popular-item">
                            <span class="num">2</span>
                            <button class="bar" onclick=""></button>
                        </div>
                        <div class="popular-item">
                            <span class="num">3</span>
                            <button class="bar" onclick=""></button>
                        </div>
                    </div>
                    <div class="pagination">
                        <span>&lt;</span>
                        <strong>1</strong>
                        <span>20</span>
                        <span>&gt;</span>
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
                </h2>
            </div>

            <div class="carousel-wrapper">
                <!-- LEFT ARROW -->
                <button class="nav-btn left" onclick="moveSlide(-1)">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <div class="carousel-viewport">
                    <div class="carousel-track" id="carouselTrack">

                        <div class="food-card">
                            <img src="Asset/sweetcreation1.jpg" alt="Sweet Creation">
                            <h5 class="card-title mt-3">Sweet Creation</h5>
                            <button class="readmore-btn" onclick="">Read More</button>
                            <div class="card-actions">
                                <button class="favorite-btn">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>


                        <div class="food-card active">
                            <img src="Asset/sweetcreation1.jpg" alt="Sweet Creation">
                            <h5 class="card-title mt-3">Sweet Creation</h5>
                            <button class="readmore-btn" onclick="">Read More</button>
                            <div class="card-actions">
                                <button class="favorite-btn">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>


                        <div class="food-card">
                            <img src="Asset/sweetcreation1.jpg" alt="Sweet Creation">
                            <h5 class="card-title mt-3">Sweet Creation</h5>
                            <button class="readmore-btn" onclick="">Read More</button>
                            <div class="card-actions">
                                <button class="favorite-btn">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>

                        <div class="food-card">
                            <img src="Asset/sweetcreation1.jpg" alt="Sweet Creation">
                            <h5 class="card-title mt-3">Sweet Creation</h5>
                            <button class="readmore-btn" onclick="">Read More</button>
                            <div class="card-actions">
                                <button class="favorite-btn">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>

                        <div class="food-card">
                            <img src="Asset/sweetcreation1.jpg" alt="Sweet Creation">
                            <h5 class="card-title mt-3">Sweet Creation</h5>
                            <button class="readmore-btn" onclick="">Read More</button>
                            <div class="card-actions">
                                <button class="favorite-btn">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- RIGHT ARROW -->
                <button class="nav-btn right" onclick="moveSlide(1)">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>

            <!-- btns for desserts -->
            <div class="carousel-icons">
                <button class="icon-btn">
                    <img src="Asset/cupcake.png" alt="Cupcake/Cake">
                </button>
                <button class="icon-btn">
                    <img src="Asset/cookie.png" alt="Cookie">
                </button>
                <button class="icon-btn">
                    <img src="Asset/icecream.png" alt="Ice Cream">
                </button>
                <button class="icon-btn">
                    <img src="Asset/pie.png" alt="Pie/Tart">
                </button>
                <button class="icon-btn">
                    <img src="Asset/pudding.png" alt="Pudding">
                </button>
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
                            <img src="Asset/von1.png" class="people-img" alt="Person">
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
                    <h2 class="our-people-title">OUR PEOPLE</h2>
                    <p class="our-people-text">
                        Start Saving These Sweets! Start Saving These Sweets!
                        Start Saving These Sweets! Start Saving These Sweets!
                    </p>

                    <div class="people-avatars">
                        <img src="Asset/people circle.jpg">
                        <img src="Asset/people circle.jpg">
                        <img src="Asset/people circle.jpg">
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

    <!-- Navbar script -->
    <script>
        const navbar = document.querySelector('.navbar');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Carousel script
        const track = document.getElementById("carouselTrack");
        const gap = 30;

        let cards = [...document.querySelectorAll(".food-card")];
        let isMoving = false;

        function cardWidth() {
            return cards[0].offsetWidth + gap;
        }

        function setActive() {
            cards.forEach(card => card.classList.remove("active"));
            cards[1].classList.add("active"); // ALWAYS center card
        }

        function moveNext() {
            if (isMoving) return;
            isMoving = true;

            track.style.transform = `translateX(-${cardWidth()}px)`;
            track.addEventListener("transitionend", () => {
                track.style.transition = "none";
                track.appendChild(cards[0]);
                track.style.transform = "translateX(0)";

                cards = [...document.querySelectorAll(".food-card")];
                setActive();

                track.offsetHeight;
                track.style.transition = "transform 0.5s ease";
                isMoving = false;
            }, { once: true });
        }

        function movePrev() {
            if (isMoving) return;
            isMoving = true;

            track.style.transition = "none";
            track.prepend(cards[cards.length - 1]);
            track.style.transform = `translateX(-${cardWidth()}px)`;

            track.offsetHeight;
            track.style.transition = "transform 0.5s ease";
            track.style.transform = "translateX(0)";

            track.addEventListener("transitionend", () => {
                cards = [...document.querySelectorAll(".food-card")];
                setActive();
                isMoving = false;
            }, { once: true });
        }
        setActive();

        function moveSlide(dir) {
            dir === 1 ? moveNext() : movePrev();
        }
        setInterval(moveNext, 6000);


        /* our people script */
        const avatarButtons = document.querySelectorAll(".people-avatars img");
        const peopleCards = document.querySelectorAll(".people-card");

        let currentIndex = 0;

        function showPerson(index) {
            peopleCards.forEach((card, i) => {
                card.style.display = i === index ? "flex" : "none";
            });

            avatarButtons.forEach((avatar, i) => {
                avatar.style.opacity = i === index ? "1" : "0.5";
                avatar.style.transform = i === index ? "scale(1.1)" : "scale(1)";
            });

            currentIndex = index;
        }

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
