<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Creation - Recipes</title>

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

        /* RECIPES SECTION */
        .recipes-section {
            padding-top: 150px;
            padding-bottom: 80px;
        }

        .recipes-title {
            font-size: 52px;
            font-weight: 900;
            color: #8f4a14;
            margin-bottom: 40px;
            text-align: center;
        }

        /* SEARCH & FILTER */
        .search-filter-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 50px;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            width: 100%;
            max-width: 500px;
        }

        .search-box input {
            width: 100%;
            padding: 14px 50px 14px 24px;
            border: 2px solid #c89b52;
            border-radius: 50px;
            font-size: 16px;
            background-color: #fff;
            color: #6b300a;
            font-family: 'Fredoka', sans-serif;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: #8f4a14;
            box-shadow: 0 0 0 3px rgba(200, 155, 82, 0.2);
        }

        .search-box input::placeholder {
            color: #b08261;
        }

        .search-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #8f4a14;
            font-size: 20px;
            pointer-events: none;
        }

        /* FILTER DROPDOWN */
        .filter-dropdown {
            position: relative;
        }

        .filter-btn {
            background-color: #c89b52;
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover {
            background-color: #8f4a14;
            transform: translateY(-2px);
        }

        .filter-menu {
            position: absolute;
            top: 110%;
            right: 0;
            background-color: #fff;
            border: 2px solid #c89b52;
            border-radius: 20px;
            padding: 15px;
            min-width: 220px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .filter-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .filter-option {
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 15px;
            color: #6b300a;
            cursor: pointer;
            transition: all 0.2s ease;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .filter-option:hover {
            background-color: #f9f4e9;
            color: #8f4a14;
            transform: translateX(5px);
        }

        .filter-option:last-child {
            margin-bottom: 0;
        }

        /* RECIPE CARDS */
        .recipes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 35px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .recipe-card {
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            transition: all 0.4s ease;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .recipe-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(139, 69, 19, 0.2);
        }

        .recipe-image-container {
            position: relative;
            width: 100%;
            height: 240px;
            overflow: hidden;
        }

        .recipe-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .recipe-card:hover .recipe-image {
            transform: scale(1.08);
        }

        .recipe-category-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(200, 155, 82, 0.95);
            color: #fff;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .recipe-heart {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.95);
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .recipe-heart:hover {
            transform: scale(1.15);
            background: #fff;
            border-color: #e74c3c;
        }

        .recipe-heart i {
            font-size: 18px;
            color: #8f4a14;
            transition: all 0.3s ease;
        }

        .recipe-heart.active {
            background: #fff;
            border-color: #e74c3c;
        }

        .recipe-heart.active i {
            color: #e74c3c;
        }


        .recipe-content {
            padding: 20px;
        }

        .recipe-title {
            font-size: 20px;
            font-weight: 700;
            color: #6b300a;
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .recipe-creator {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .creator-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #c89b52;
        }

        .creator-name {
            font-size: 13px;
            color: #8f4a14;
            font-weight: 600;
        }

        .recipe-stats {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            padding-top: 12px;
            border-top: 1px solid #f0e6d6;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            color: #8f4a14;
        }

        .stat-item i {
            font-size: 14px;
            color: #c89b52;
        }

        .recipe-description {
            font-size: 13px;
            color: #8f4a14;
            line-height: 1.5;
            margin-bottom: 15px;
            opacity: 0.85;
        }

        .recipe-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .recipe-time {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            color: #8f4a14;
            font-weight: 600;
        }

        .recipe-time i {
            color: #c89b52;
        }

        .view-recipe-btn {
            background-color: #c89b52;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 8px 20px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .view-recipe-btn:hover {
            background-color: #8f4a14;
            transform: translateY(-2px);
        }

        
        .custom-footer {
            background-color: #c79850;
            border-radius: 50px 50px 0 0;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .recipes-title {
                font-size: 36px;
            }

            .search-filter-container {
                flex-direction: column;
                width: 100%;
                padding: 0 20px;
            }

            .search-box {
                max-width: 100%;
            }

            .filter-menu {
                right: auto;
                left: 50%;
                transform: translateX(-50%) translateY(-10px);
            }

            .filter-menu.active {
                transform: translateX(-50%) translateY(0);
            }

            .recipes-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 25px;
            }
        }

            /* Floating Action Button */
            
            .create-recipe-fab {
                position: fixed;
                bottom: 30px;
                right: 30px;
                width: 60px;
                height: 60px;
                background: #c89b52; /* Changed from gradient */
                border: none;
                border-radius: 50%;
                color: #fff;
                font-size: 24px;
                box-shadow: 0 4px 20px rgba(200, 155, 82, 0.4);
                cursor: pointer;
                transition: all 0.3s ease;
                z-index: 999;
            }

            .create-recipe-fab:hover {
                background: #a85a1a; /* Darker on hover */
                transform: scale(1.1) rotate(90deg);
                box-shadow: 0 6px 30px rgba(200, 155, 82, 0.6);
            }
            /* Tooltip Popup */
            .fab-tooltip {
                position: fixed;
                bottom: 100px;
                right: 30px;
                background: #fff;
                color: #6b300a;
                padding: 15px 20px;
                border-radius: 16px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
                font-size: 14px;
                font-weight: 600;
                white-space: nowrap;
                opacity: 0;
                visibility: hidden;
                transform: translateY(10px);
                transition: all 0.3s ease;
                z-index: 998;
                border: 2px solid #c89b52;
                max-width: 250px;
                white-space: normal;
                line-height: 1.5;
            }

            .fab-tooltip::after {
                content: '';
                position: absolute;
                bottom: -10px;
                right: 20px;
                width: 0;
                height: 0;
                border-left: 10px solid transparent;
                border-right: 10px solid transparent;
                border-top: 10px solid #c89b52;
            }

            .fab-tooltip::before {
                content: '';
                position: absolute;
                bottom: -7px;
                right: 22px;
                width: 0;
                height: 0;
                border-left: 8px solid transparent;
                border-right: 8px solid transparent;
                border-top: 8px solid #fff;
                z-index: 1;
            }

            .fab-tooltip.show {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }

            .fab-tooltip .tooltip-emoji {
                font-size: 20px;
                margin-right: 8px;
            }

            @media (max-width: 768px) {
                .create-recipe-fab {
                    bottom: 20px;
                    right: 20px;
                    width: 55px;
                    height: 55px;
                }
                
                .fab-tooltip {
                    bottom: 85px;
                    right: 20px;
                    max-width: 220px;
                    font-size: 13px;
                    padding: 12px 16px;
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
                <img src="Asset/LogoSC.png" alt="Sweet Creation Logo" width="120" height="110">
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
                        <a class="nav-link active" href="#">RECIPES</a>
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

    <!-- RECIPES SECTION -->
    <section class="recipes-section">
        <div class="container">
            <h1 class="recipes-title">SWEET RECIPES</h1>

            <!-- SEARCH & FILTER -->
            <div class="search-filter-container">
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Search recipes...">
                    <i class="bi bi-search search-icon"></i>
                </div>

                <div class="filter-dropdown">
                    <button class="filter-btn" onclick="toggleFilter()">
                        <span>Filter</span>
                        <i class="bi bi-funnel"></i>
                    </button>
                    <div class="filter-menu" id="filterMenu">
                        <div class="filter-option" onclick="filterRecipes('all')">All Recipes</div>
                        <div class="filter-option" onclick="filterRecipes('cakes')">Cakes & Cupcakes</div>
                        <div class="filter-option" onclick="filterRecipes('cookies')">Cookies & Bars</div>
                        <div class="filter-option" onclick="filterRecipes('frozen')">Frozen Desserts</div>
                        <div class="filter-option" onclick="filterRecipes('pies')">Pies & Tarts</div>
                        <div class="filter-option" onclick="filterRecipes('custards')">Custards & Puddings</div>
                    </div>
                </div>
            </div>

            <!-- RECIPE CARDS GRID -->
            <div class="recipes-grid" id="recipesGrid">
                <!-- Cards will be generated by JavaScript -->
            </div>
        </div>
    </section>

    <script>
        // Sample data structure - replace this with PHP/MySQL data
        const recipesData = [
            {
                id: 1,
                title: "Chocolate Delight Cake",
                category: "cakes",
                categoryLabel: "CAKE",
                image: "https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=400",
                creator: "@sarah_bakes",
                creatorAvatar: "https://i.pravatar.cc/150?img=1",
                likes: 234,
                comments: 89,
                description: "Rich, moist chocolate cake with silky ganache frosting",
                time: "45 mins"
            },
            {
                id: 2,
                title: "Classic Chocolate Chip",
                category: "cookies",
                categoryLabel: "COOKIES",
                image: "https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=400",
                creator: "@cookie_master",
                creatorAvatar: "https://i.pravatar.cc/150?img=5",
                likes: 512,
                comments: 203,
                description: "Perfectly chewy cookies loaded with chocolate chips",
                time: "25 mins"
            },
            {
                id: 3,
                title: "Vanilla Bean Dream",
                category: "frozen",
                categoryLabel: "FROZEN",
                image: "https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=400",
                creator: "@icecream_queen",
                creatorAvatar: "https://i.pravatar.cc/150?img=9",
                likes: 387,
                comments: 145,
                description: "Homemade ice cream with real vanilla beans",
                time: "4 hours"
            },
            {
                id: 4,
                title: "Homemade Apple Pie",
                category: "pies",
                categoryLabel: "PIE",
                image: "https://images.unsplash.com/photo-1535920527002-b35e96722eb9?w=400",
                creator: "@pie_perfection",
                creatorAvatar: "https://i.pravatar.cc/150?img=12",
                likes: 456,
                comments: 178,
                description: "Traditional apple pie with flaky butter crust",
                time: "1.5 hours"
            },
            {
                id: 5,
                title: "Silky Crème Brûlée",
                category: "custards",
                categoryLabel: "CUSTARD",
                image: "https://images.unsplash.com/photo-1470124182917-cc6e71b22ecc?w=400",
                creator: "@french_desserts",
                creatorAvatar: "https://i.pravatar.cc/150?img=20",
                likes: 298,
                comments: 112,
                description: "Classic French dessert with caramelized sugar top",
                time: "50 mins"
            },
            {
                id: 6,
                title: "Rainbow Cupcakes",
                category: "cakes",
                categoryLabel: "CUPCAKE",
                image: "https://images.unsplash.com/photo-1557925923-cd4648e211a0?w=400",
                creator: "@cupcake_dreams",
                creatorAvatar: "https://i.pravatar.cc/150?img=25",
                likes: 623,
                comments: 287,
                description: "Colorful vanilla cupcakes with buttercream frosting",
                time: "35 mins"
            },
            {
                id: 7,
                title: "Fudgy Brownies",
                category: "cookies",
                categoryLabel: "BROWNIE",
                image: "https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=400",
                creator: "@brownie_addict",
                creatorAvatar: "https://i.pravatar.cc/150?img=33",
                likes: 789,
                comments: 321,
                description: "Dense, fudgy brownies with crackly tops",
                time: "30 mins"
            },
            {
                id: 8,
                title: "Berry Fruit Tart",
                category: "pies",
                categoryLabel: "TART",
                image: "https://images.unsplash.com/photo-1519915212116-7cfef71f1d3e?w=400",
                creator: "@tart_lover",
                creatorAvatar: "https://i.pravatar.cc/150?img=41",
                likes: 345,
                comments: 156,
                description: "Fresh berries on vanilla cream in buttery crust",
                time: "1 hour"
            }
            
        ];

        // Function to create recipe card HTML
        function createRecipeCard(recipe) {
            return `
                <div class="recipe-card" data-category="${recipe.category}" data-id="${recipe.id}">
                    <div class="recipe-image-container">
                        <img src="${recipe.image}" alt="${recipe.title}" class="recipe-image">
                        <span class="recipe-category-badge">${recipe.categoryLabel}</span>
                        <div class="recipe-heart" onclick="toggleHeart(event, this)">
                            <i class="bi bi-heart"></i>
                        </div>
                    </div>
                    <div class="recipe-content">
                        <h3 class="recipe-title">${recipe.title}</h3>
                        <div class="recipe-creator">
                            <img src="${recipe.creatorAvatar}" alt="Creator" class="creator-avatar">
                            <span class="creator-name">${recipe.creator}</span>
                        </div>
                        <div class="recipe-stats">
                            <div class="stat-item">
                                <i class="bi bi-heart-fill"></i>
                                <span class="likes-count">${recipe.likes}</span>
                            </div>
                            <div class="stat-item">
                                <i class="bi bi-chat-fill"></i>
                                <span>${recipe.comments}</span>
                            </div>
                        </div>
                        <p class="recipe-description">${recipe.description}</p>
                        <div class="recipe-footer">
                            <div class="recipe-time">
                                <i class="bi bi-clock"></i>
                                <span>${recipe.time}</span>
                            </div>
                            <button class="view-recipe-btn" onclick="viewRecipe(${recipe.id})">View Recipe</button>
                        </div>
                    </div>
                </div>
            `;
        }

        // Function to render all recipes
        function renderRecipes(recipes) {
            const grid = document.getElementById('recipesGrid');
            grid.innerHTML = recipes.map(recipe => createRecipeCard(recipe)).join('');
        }

        // Initialize - render all recipes on page load
        renderRecipes(recipesData);

        // Navbar scroll effect
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Filter dropdown toggle
        function toggleFilter() {
            const filterMenu = document.getElementById('filterMenu');
            filterMenu.classList.toggle('active');
        }

        // Close filter when clicking outside
        document.addEventListener('click', function(event) {
            const filterDropdown = document.querySelector('.filter-dropdown');
            const filterMenu = document.getElementById('filterMenu');
            
            if (!filterDropdown.contains(event.target)) {
                filterMenu.classList.remove('active');
            }
        });

        // Filter recipes
        function filterRecipes(category) {
            const cards = document.querySelectorAll('.recipe-card');
            
            cards.forEach(card => {
                if (category === 'all' || card.dataset.category === category) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'scale(1)';
                    }, 10);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });

            document.getElementById('filterMenu').classList.remove('active');
        }

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.recipe-card');

            cards.forEach(card => {
                const title = card.querySelector('.recipe-title').textContent.toLowerCase();
                const creator = card.querySelector('.creator-name').textContent.toLowerCase();
                const description = card.querySelector('.recipe-description').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || creator.includes(searchTerm) || description.includes(searchTerm)) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'scale(1)';
                    }, 10);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });

        
        // Toggle heart/favorite
        function toggleHeart(event, element) {
            event.stopPropagation();
            element.classList.toggle('active');
            
            const icon = element.querySelector('i');
            const card = element.closest('.recipe-card');
            const likesElement = card.querySelector('.likes-count');
            let currentLikes = parseInt(likesElement.textContent);
            
            if (element.classList.contains('active')) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                likesElement.textContent = currentLikes + 1;
            } else {
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
                likesElement.textContent = currentLikes - 1;
            }
        }

        // View recipe function (you can implement this later)
       function viewRecipe(recipeId) {
            window.location.href = 'ViewRecipe.php?id=' + recipeId;
        }

        // Add transition styles for cards
        document.querySelectorAll('.recipe-card').forEach(card => {
            card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        });

       
    </script>

    <button class="create-recipe-fab" id="createFab" onclick="openCreateRecipe()">
        <i class="bi bi-plus-lg"></i>
    </button>

    <div class="fab-tooltip" id="fabTooltip">
        <span class="tooltip-emoji">✨</span>
        Want to share your sweet creation? Click here to create your own recipe!
    </div>

    <script>
        // FAB tooltip functionality
        const createFab = document.getElementById('createFab');
        const fabTooltip = document.getElementById('fabTooltip');

        if (createFab && fabTooltip) {
            createFab.addEventListener('mouseenter', function() {
                fabTooltip.classList.add('show');
            });

            createFab.addEventListener('mouseleave', function() {
                fabTooltip.classList.remove('show');
            });

            function openCreateRecipe() {
                window.location.href = 'AddRecipe.php'; 
            }
        }
    </script>

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

    


</body>
</html>