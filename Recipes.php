<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit;
}

// Include database connection
require_once 'config/database.php';

$user_id = $_SESSION['user_id'];

// Fetch current user info
$stmt = $conn->prepare("SELECT user_id, username, display_name, avatar_img FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$currentUser = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

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
    <link rel="stylesheet" href="navbar.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="recipe-style.css?v=<?php echo time(); ?>">
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
                    <span class="navbar-username">
                        <?php echo htmlspecialchars($currentUser['display_name'] ?? $currentUser['username']); ?>
                    </span>
                </a>

                <a href="AboutUs.php">About Us</a>
                <a href="#" class="login-link" onclick="logoutUser()">Logout</a>
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

    <button class="create-recipe-fab" id="createFab" onclick="openCreateRecipe()">
        <i class="bi bi-plus-lg"></i>
    </button>

    <div class="fab-tooltip" id="fabTooltip">
        <span class="tooltip-emoji">✨</span>
        Want to share your sweet creation? Click here to create your own recipe!
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

    <script src="toast.js"></script>
    <script>
        let recipesData = [];

        fetch('get-recipes.php')
            .then(response => response.json())
            .then(data => {
                recipesData = data;
                renderRecipes(recipesData);
            })
            .catch(error => {
                console.error('Error loading recipes:', error);
            });

        function createRecipeCard(recipe) {
            // Check the liked state from the database
            const likedClass = recipe.isLiked ? 'active' : '';
            const heartIcon = recipe.isLiked ? 'bi-heart-fill' : 'bi-heart';

            return `
                <div class="recipe-card" data-category="${recipe.category}" data-id="${recipe.id}">
                    <div class="recipe-image-container">
                        <img src="${recipe.image}" alt="${recipe.title}" class="recipe-image">
                        <span class="recipe-category-badge">${recipe.categoryLabel}</span>
                        <div class="recipe-heart ${likedClass}" onclick="toggleHeart(event, this)">
                            <i class="bi ${heartIcon}"></i>
                        </div>
                    </div>
                    <div class="recipe-content">
                        <h3 class="recipe-title">${recipe.title}</h3>
                        <div class="recipe-creator">
                            <img src="${recipe.creatorAvatar}" alt="Creator" class="creator-avatar" onclick="viewProfile(event, ${recipe.creatorId})">
                            <span class="creator-name" onclick="viewProfile(event, ${recipe.creatorId})">${recipe.creator}</span>
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

        // Add this new function to handle profile viewing
        function viewProfile(event, userId) {
            event.stopPropagation(); // Prevent card click
            
            // Get current user ID from PHP (you'll need to add this in your PHP)
            const currentUserId = <?php echo $_SESSION['user_id']; ?>;
            
            // Check if viewing own profile
            if (userId === currentUserId) {
                window.location.href = 'Profile.php?id=' + userId;
            } else {
                window.location.href = 'Other-Profile.php?id=' + userId;
            }
        }

        // Function to render all recipes
        function renderRecipes(recipes) {
            const grid = document.getElementById('recipesGrid');
            grid.innerHTML = recipes.map(recipe => createRecipeCard(recipe)).join('');
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

        // Close menu when clicking any menu link EXCEPT logout
        document.querySelectorAll("#hamburgerMenu a").forEach(link => {
            link.addEventListener("click", () => {
                document.getElementById("hamburgerMenu").classList.remove("active");
            });
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
            const recipeId = card.getAttribute('data-id');
            
            let currentLikes = parseInt(likesElement.textContent);
            let action = element.classList.contains('active') ? 'add-like' : 'remove-like';

            if (action === 'add-like') {
                icon.classList.replace('bi-heart', 'bi-heart-fill');
                likesElement.textContent = currentLikes + 1;
            } else {
                icon.classList.replace('bi-heart-fill', 'bi-heart');
                likesElement.textContent = currentLikes - 1;
            }

            const requestData = {
                action: action,
                recipe_id: recipeId
            }

            fetch('add-remove-like.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            });
        }

        // View recipe function
        function viewRecipe(recipeId) {
            window.location.href = 'ViewRecipe.php?id=' + recipeId;
        }

        // Add transition styles for cards
        document.querySelectorAll('.recipe-card').forEach(card => {
            card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        });

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
        }

        function openCreateRecipe() {
            window.location.href = 'AddRecipe.php'; 
        }
    </script>
</body>
</html>