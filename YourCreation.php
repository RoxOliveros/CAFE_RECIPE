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
    <title>Sweet Creation - Your Creation</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="navbar.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="yourcreation-style.css">
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
                        <a class="nav-link active" href="#">YOUR CREATION</a>
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

    <!-- YOUR CREATION SECTION -->
    <section class="creation-section">
        <div class="container">
            <h1 class="creation-title">Your Creations</h1>
            <p class="creation-subtitle">Manage and track your delicious recipes</p>

            <!-- STATS CARDS -->
            <div class="stats-container">
                <div class="stat-card">
                    <i class="bi bi-file-earmark-text-fill stat-icon"></i>
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
                <div class="empty-state" id="emptyRecipe" style="display: none;">
                    <i class="bi bi-inbox empty-icon"></i>
                    <h3 class="empty-title">No Recipes Yet</h3>
                    <p class="empty-text">Start creating your first recipe and share it with the community!</p>
                    <button class="empty-btn" onclick="createNewRecipe()">Create Your First Recipe</button>
                </div>
            </div>

            <br>

            <!-- BOOKMARKS -->
            <div class="my-recipes-container">
                <h2 class="section-header">
                    <i class="bi bi-journal-bookmark"></i>
                    Bookmarks
                </h2>

                <!-- Bookmark Cards -->
                <div id="bookmarksList">
                    <!-- Cards will be generated here -->
                </div>

                <!-- Empty State (shown when no recipes) -->
                <div class="empty-state" id="emptyBookmark" style="display: none;">
                    <i class="bi bi-bookmark empty-icon"></i>
                    <h3 class="empty-title">No Bookmarks Yet</h3>
                    <p class="empty-text">Start saving your first recipe and look it up later!</p>
                    <button class="empty-btn" onclick="saveNewRecipe()">Save Your First Recipe</button>
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


        let userRecipes = [];

        // Fetch user's recipes from database
        fetch('get-user-recipes.php')
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    document.getElementById('emptyRecipe').style.display = 'block';
                    return;
                }

                userRecipes = data.recipes;
                updateStats(data.stats);
                renderRecipes();
            })
            .catch(err => console.error(err));
            
        let userBookmarks = [];

        // Fetch user's bookmarked recipes from database
        fetch('get-user-bookmarks.php')
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    console.error(data.error);
                    document.getElementById('emptyBookmark').style.display = 'block';
                    return;
                }

                userBookmarks = data.bookmarks;
                renderBookmarks();
            })
            .catch(err => console.error(err));


        // Update stats cards
        function updateStats(stats) {
            document.querySelector('.stats-container .stat-card:nth-child(1) .stat-number').textContent = stats.totalRecipes;
            document.querySelector('.stats-container .stat-card:nth-child(2) .stat-number').textContent = stats.totalLikes;
            document.querySelector('.stats-container .stat-card:nth-child(3) .stat-number').textContent = stats.totalSaves;
            document.querySelector('.stats-container .stat-card:nth-child(4) .stat-number').textContent = stats.totalComments;
        }

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
                            <button class="action-btn btn-delete" onclick="deleteRecipe(${recipe.id}, '${recipe.title.replace(/'/g, "\\'")}')" title="Delete Recipe">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }
        
        // Function to create bookmarked recipe card HTML
        function createBookmarkCard(recipe) {
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
                        <span id="save-count-${recipe.id}">${recipe.saves}</span>
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
                            <button class="action-btn btn-edit" onclick="viewRecipe(${recipe.id})" title="View Recipe">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                            <button class="action-btn btn-edit active" onclick="toggleSave(${recipe.id})" id="saveBtn-${recipe.id}" title="Unsave Recipe" style="background-color: #3498db; color: #fff;">
                                <i class="bi bi-bookmark-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        // For bookmark and unbookmark
        function toggleSave(recipeId) {
            const btn = document.getElementById('saveBtn-' + recipeId);
            const countSpan = document.getElementById('save-count-' + recipeId);

            let action = '';
            let currentSaves = countSpan ? parseInt(countSpan.textContent) : 0;
            
            if (btn.classList.contains('active')) {
                btn.classList.remove('active');
                btn.title = "Save Recipe";
                btn.style.backgroundColor = "#e8f4f8";
                btn.style.color = "#3498db";
                action = 'remove-save';
                if (countSpan) countSpan.textContent = currentSaves - 1;
            } else {
                btn.classList.add('active');
                btn.title = "Unsave Recipe";
                btn.style.backgroundColor = "#3498db";
                btn.style.color = "#fff";
                action = 'add-save';
                if (countSpan) countSpan.textContent = currentSaves + 1;
            }
            
            const requestData = {
                action: action,
                recipe_id: recipeId
            }

            fetch('add-remove-bookmark.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(requestData)
            });
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
            const emptyRecipe = document.getElementById('emptyRecipe');

            if (userRecipes.length === 0) {
                container.innerHTML = '';
                emptyRecipe.style.display = 'block';
            } else {
                emptyRecipe.style.display = 'none';
                container.innerHTML = userRecipes.map(recipe => createRecipeCard(recipe)).join('');
            }
        }

        // Render bookmakrs
        function renderBookmarks() {
            const container = document.getElementById('bookmarksList');
            const emptyBookmark = document.getElementById('emptyBookmark');

            if (userBookmarks.length === 0) {
                container.innerHTML = '';
                emptyBookmark.style.display = 'block';
            } else {
                emptyBookmark.style.display = 'none';
                container.innerHTML = userBookmarks.map(bookmark => createBookmarkCard(bookmark)).join('');
            }
        }

        // Create new recipe
        function createNewRecipe() {
            window.location.href = 'AddRecipe.php';
        }

        // Create new recipe
        function saveNewRecipe() {
            window.location.href = 'Recipes.php';
        }

        // Edit recipe
        function editRecipe(recipeId) {
            window.location.href = 'EditRecipe.php?id=' + recipeId;
        }
        
        // View recipe
       function viewRecipe(recipeId) {
            window.location.href = 'ViewRecipe.php?id=' + recipeId;
        }

        // Delete recipe
        function deleteRecipe(recipeId, recipeTitle) {
            showConfirmation(
                `Are you sure you want to delete "${recipeTitle}"? This action cannot be undone.`,
                () => {
                    // Show loading toast
                    const loadingToast = showLoading('Deleting recipe...', 'Please wait');
                    
                    // Send delete request to backend
                    fetch('delete-recipe.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ id: recipeId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Close loading toast
                        setTimeout(() => {
                            loadingToast.close();
                        }, 1500);
                        
                        setTimeout(() => {
                            if (data.success) {
                                // Show success toast
                                showSuccess('Recipe deleted successfully! 🎉');
                                
                                // Reload recipes after a short delay
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                // Show error toast
                                showError(data.message || 'Failed to delete recipe');
                            }
                        }, 1500);
                    })
                    .catch(error => {
                        // Close loading toast
                        loadingToast.close();
                        
                        console.error('Error:', error);
                        // Show error toast
                        showError('An unexpected error occurred. Please try again.');
                    });
                }
            );
        }
    </script>
</body>
</html>