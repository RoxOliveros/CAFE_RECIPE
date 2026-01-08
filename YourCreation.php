<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Creation - Your Creation</title>

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

        /* YOUR CREATION SECTION */
        .creation-section {
            padding-top: 150px;
            padding-bottom: 80px;
        }

        .creation-title {
            font-size: 52px;
            font-weight: 900;
            color: #8f4a14;
            margin-bottom: 15px;
            text-align: center;
        }

        .creation-subtitle {
            font-size: 16px;
            color: #b08261;
            text-align: center;
            margin-bottom: 50px;
        }

        /* STATS CARDS */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto 50px;
        }

        .stat-card {
            background: #fff;
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .stat-icon {
            font-size: 36px;
            color: #c89b52;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 800;
            color: #6b300a;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            color: #8f4a14;
            font-weight: 600;
        }

        /* CREATE NEW BUTTON */
        .create-new-section {
            max-width: 1200px;
            margin: 0 auto 40px;
        }

        .create-new-btn {
            width: 100%;
            background: #c89b52;
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 25px;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(200, 155, 82, 0.3);
        }

        .create-new-btn:hover {
            background: #a85a1a;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(200, 155, 82, 0.4);
        }

        .create-new-btn i {
            font-size: 28px;
        }

        /* MY RECIPES SECTION */
        .my-recipes-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            font-size: 28px;
            font-weight: 800;
            color: #6b300a;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-header i {
            color: #c89b52;
        }

        /* RECIPE CARD */
        .my-recipe-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .my-recipe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .recipe-card-content {
            display: flex;
            gap: 20px;
            padding: 20px;
        }

        .recipe-thumbnail {
            width: 180px;
            height: 140px;
            border-radius: 12px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .recipe-details {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .recipe-card-title {
            font-size: 22px;
            font-weight: 700;
            color: #6b300a;
            margin-bottom: 8px;
        }

        .recipe-card-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #8f4a14;
        }

        .meta-item i {
            color: #c89b52;
            font-size: 14px;
        }

        .recipe-card-stats {
            display: flex;
            gap: 20px;
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid #f0e6d6;
        }

        .stat-mini {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            color: #8f4a14;
            font-weight: 600;
        }

        .stat-mini i {
            color: #c89b52;
        }

        /* VISIBILITY BADGE */
        .visibility-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .visibility-public {
            background: #e8f8f5;
            color: #27ae60;
        }

        .visibility-followers {
            background: #fef5e7;
            color: #f39c12;
        }

        .visibility-private {
            background: #f4ecf7;
            color: #8e44ad;
        }

        .visibility-badge i {
            font-size: 13px;
        }

        /* ACTIONS */
        .recipe-actions {
            display: flex;
            gap: 10px;
            margin-left: auto;
        }

        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .btn-edit {
            background: #e8f4f8;
            color: #3498db;
        }

        .btn-edit:hover {
            background: #3498db;
            color: #fff;
            transform: scale(1.1);
        }

        .btn-delete {
            background: #fde8e8;
            color: #e74c3c;
        }

        .btn-delete:hover {
            background: #e74c3c;
            color: #fff;
            transform: scale(1.1);
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .empty-icon {
            font-size: 80px;
            color: #e6dcc8;
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 24px;
            font-weight: 700;
            color: #8f4a14;
            margin-bottom: 10px;
        }

        .empty-text {
            font-size: 16px;
            color: #b08261;
            margin-bottom: 25px;
        }

        .empty-btn {
            background: #c89b52;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .empty-btn:hover {
            background: #a85a1a;
            transform: translateY(-2px);
        }

        /* FOOTER */
        .custom-footer {
            background-color: #c79850;
            border-radius: 50px 50px 0 0;
            margin-top: 80px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .creation-title {
                font-size: 36px;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .recipe-card-content {
                flex-direction: column;
            }

            .recipe-thumbnail {
                width: 100%;
                height: 200px;
            }

            .recipe-actions {
                margin-left: 0;
                margin-top: 15px;
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
                        <a class="nav-link active" href="#">YOUR CREATION</a>
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

    <!-- YOUR CREATION SECTION -->
    <section class="creation-section">
        <div class="container">
            <h1 class="creation-title">Your Creations</h1>
            <p class="creation-subtitle">Manage and track your delicious recipes</p>

            <!-- STATS CARDS -->
            <div class="stats-container">
                <div class="stat-card">
                    <i class="bi bi-file-earmark-text stat-icon"></i>
                    <div class="stat-number">5</div>
                    <div class="stat-label">Total Recipes</div>
                </div>
                <div class="stat-card">
                    <i class="bi bi-heart-fill stat-icon"></i>
                    <div class="stat-number">1.2K</div>
                    <div class="stat-label">Total Likes</div>
                </div>
                <div class="stat-card">
                    <i class="bi bi-bookmark-fill stat-icon"></i>
                    <div class="stat-number">456</div>
                    <div class="stat-label">Total Saves</div>
                </div>
                <div class="stat-card">
                    <i class="bi bi-chat-fill stat-icon"></i>
                    <div class="stat-number">789</div>
                    <div class="stat-label">Total Comments</div>
                </div>
            </div>

            <!-- CREATE NEW BUTTON -->
            <div class="create-new-section">
                <button class="create-new-btn" onclick="createNewRecipe()">
                    <i class="bi bi-plus-circle"></i>
                    Create New Recipe
                </button>
            </div>

            <!-- MY RECIPES -->
            <div class="my-recipes-container">
                <h2 class="section-header">
                    <i class="bi bi-journal-text"></i>
                    My Recipes
                </h2>

                <!-- Recipe Cards -->
                <div id="recipesList">
                    <!-- Cards will be generated here -->
                </div>

                <!-- Empty State (shown when no recipes) -->
                <div class="empty-state" id="emptyState" style="display: none;">
                    <i class="bi bi-inbox empty-icon"></i>
                    <h3 class="empty-title">No Recipes Yet</h3>
                    <p class="empty-text">Start creating your first recipe and share it with the community!</p>
                    <button class="empty-btn" onclick="createNewRecipe()">Create Your First Recipe</button>
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

        // Sample user recipes data (replace with PHP/MySQL data)
        const userRecipes = [
            {
                id: 1,
                title: "Chocolate Delight Cake",
                category: "Cakes & Cupcakes",
                image: "https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400",
                time: "45 mins",
                servings: 12,
                likes: 234,
                saves: 89,
                comments: 45,
                createdDate: "2024-01-15",
                visibility: "public"
            },
            {
                id: 2,
                title: "Classic Chocolate Chip",
                category: "Cookies & Bars",
                image: "https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=400",
                time: "25 mins",
                servings: 24,
                likes: 512,
                saves: 203,
                comments: 78,
                createdDate: "2024-01-10",
                visibility: "followers"
            },
            {
                id: 3,
                title: "Vanilla Bean Dream",
                category: "Frozen Desserts",
                image: "https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=400",
                time: "4 hours",
                servings: 8,
                likes: 387,
                saves: 145,
                comments: 56,
                createdDate: "2024-01-05",
                visibility: "public"
            },
            {
                id: 4,
                title: "Homemade Apple Pie",
                category: "Pies & Tarts",
                image: "https://images.unsplash.com/photo-1535920527002-b35e96722eb9?w=400",
                time: "1.5 hours",
                servings: 8,
                likes: 456,
                saves: 178,
                comments: 92,
                createdDate: "2023-12-28",
                visibility: "private"
            },
            {
                id: 5,
                title: "Rainbow Cupcakes",
                category: "Cakes & Cupcakes",
                image: "https://images.unsplash.com/photo-1557925923-cd4648e211a0?w=400",
                time: "35 mins",
                servings: 12,
                likes: 623,
                saves: 287,
                comments: 134,
                createdDate: "2023-12-20",
                visibility: "public"
            }
        ];

        // Function to create recipe card HTML
        function createRecipeCard(recipe) {
            const visibilityConfig = {
                public: { icon: 'bi-globe', label: 'Public', class: 'visibility-public' },
                followers: { icon: 'bi-people-fill', label: 'Followers Only', class: 'visibility-followers' },
                private: { icon: 'bi-lock-fill', label: 'Private', class: 'visibility-private' }
            };
            
            const visibility = visibilityConfig[recipe.visibility] || visibilityConfig.public;
            const isPrivate = recipe.visibility === 'private';
            
            // Only show stats for public and followers recipes
            const statsHTML = !isPrivate ? `
                <div class="recipe-card-stats">
                    <div class="stat-mini">
                        <i class="bi bi-heart-fill"></i>
                        <span>${recipe.likes}</span>
                    </div>
                    <div class="stat-mini">
                        <i class="bi bi-bookmark-fill"></i>
                        <span>${recipe.saves}</span>
                    </div>
                    <div class="stat-mini">
                        <i class="bi bi-chat-fill"></i>
                        <span>${recipe.comments}</span>
                    </div>
                </div>
            ` : '';
            
            return `
                <div class="my-recipe-card">
                    <div class="recipe-card-content">
                        <img src="${recipe.image}" alt="${recipe.title}" class="recipe-thumbnail">
                        
                        <div class="recipe-details">
                            <div class="visibility-badge ${visibility.class}">
                                <i class="bi ${visibility.icon}"></i>
                                <span>${visibility.label}</span>
                            </div>
                            <h3 class="recipe-card-title">${recipe.title}</h3>
                            
                            <div class="recipe-card-meta">
                                <div class="meta-item">
                                    <i class="bi bi-tag"></i>
                                    <span>${recipe.category}</span>
                                </div>
                                <div class="meta-item">
                                    <i class="bi bi-clock"></i>
                                    <span>${recipe.time}</span>
                                </div>
                                <div class="meta-item">
                                    <i class="bi bi-people"></i>
                                    <span>${recipe.servings} servings</span>
                                </div>
                                <div class="meta-item">
                                    <i class="bi bi-calendar3"></i>
                                    <span>${formatDate(recipe.createdDate)}</span>
                                </div>
                            </div>
                            
                            ${statsHTML}
                        </div>

                        <div class="recipe-actions">
                            <button class="action-btn btn-edit" onclick="editRecipe(${recipe.id})" title="Edit Recipe">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="action-btn btn-delete" onclick="deleteRecipe(${recipe.id}, '${recipe.title}')" title="Delete Recipe">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        // Format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            const options = { month: 'short', day: 'numeric', year: 'numeric' };
            return date.toLocaleDateString('en-US', options);
        }

        // Render recipes
        function renderRecipes() {
            const container = document.getElementById('recipesList');
            const emptyState = document.getElementById('emptyState');

            if (userRecipes.length === 0) {
                container.innerHTML = '';
                emptyState.style.display = 'block';
            } else {
                emptyState.style.display = 'none';
                container.innerHTML = userRecipes.map(recipe => createRecipeCard(recipe)).join('');
            }
        }

        // Initialize page
        renderRecipes();

        // Create new recipe
        function createNewRecipe() {
            window.location.href = 'create-recipe.php';
        }

        // Edit recipe
        function editRecipe(recipeId) {
            console.log('Editing recipe:', recipeId);
            // window.location.href = 'edit-recipe.php?id=' + recipeId;
            alert('Edit functionality will be implemented with your backend!');
        }

        // Delete recipe
        function deleteRecipe(recipeId, recipeTitle) {
            if (confirm(`Are you sure you want to delete "${recipeTitle}"? This action cannot be undone.`)) {
                console.log('Deleting recipe:', recipeId);
                
                // Remove from array (in production, this would be a backend call)
                const index = userRecipes.findIndex(r => r.id === recipeId);
                if (index > -1) {
                    userRecipes.splice(index, 1);
                    renderRecipes();
                    alert('Recipe deleted successfully!');
                }
                
                // In production:
                // fetch('delete-recipe.php', {
                //     method: 'POST',
                //     body: JSON.stringify({ id: recipeId })
                // }).then(response => response.json())
                //   .then(data => {
                //       if(data.success) {
                //           renderRecipes();
                //       }
                //   });
            }
        }
    </script>

</body>
</html>