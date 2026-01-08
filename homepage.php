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
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="homepage-style.css">
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
            
            <div class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="hamburger-menu" id="hamburgerMenu">
                <a href="AboutUs.php">About Us</a>
                <a href="Login.php" class="login-link">Login</a>
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

                <!-- RIGHT CONTENT -->
                <div class="col-lg-6">
                    <p class="top-subtitle">UPDATED DAILY BY THE COMMUNITY</p>
                    <h2 class="top-title"><span>TOP</span> CONTRIBUTORS</h2>

                    <div class="top-list">
                        <div class="top-item">
                            <span class="num">1</span>
                            <button class="bar" onclick=""></button>
                        </div>
                        <div class="top-item">
                            <span class="num">2</span>
                            <button class="bar" onclick=""></button>
                        </div>
                        <div class="top-item">
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
                    <img src="Asset/pie.png" alt="Pie/Tart">
                </button>
                <button class="icon-btn">
                    <img src="Asset/frozen.png" alt="Ice Cream">
                </button>
                <button class="icon-btn">
                    <img src="Asset/pudding.png" alt="Pudding">
                </button>
                <button class="icon-btn">
                    <img src="Asset/cookies.png" alt="Cookie">
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

    
    // menubar
    function toggleMenu() {
    const menu = document.getElementById("hamburgerMenu");
    menu.classList.toggle("active");
    }

    // Close menu when a link is clicked
    const links = document.querySelectorAll("#hamburgerMenu a");
    links.forEach(link => {
    link.addEventListener("click", () => {
        document.getElementById("hamburgerMenu").classList.remove("active");
    });
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
