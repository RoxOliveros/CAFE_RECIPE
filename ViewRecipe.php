<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Creation - Recipe</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f9f4e9;
            font-family: 'Fredoka', sans-serif;
        }

        /* BACK BUTTON */
        .back-button {
            position: fixed;
            top: 30px;
            left: 30px;
            background: #fff;
            border: 2px solid #c89b52;
            color: #8f4a14;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .back-button:hover {
            background: #c89b52;
            color: #fff;
            transform: scale(1.1);
        }

        .back-button i {
            font-size: 20px;
        }

        /* RECIPE SECTION */
        .recipe-section {
            padding: 80px 20px 80px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* RECIPE HEADER */
        .recipe-header {
            background: #fff;
            border-radius: 30px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .recipe-title {
            font-size: 42px;
            font-weight: 900;
            color: #6b300a;
            margin-bottom: 15px;
        }

        .recipe-meta {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .meta-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #faf7f2;
            padding: 10px 18px;
            border-radius: 12px;
            font-size: 14px;
            color: #8f4a14;
            font-weight: 600;
        }

        .meta-badge i {
            color: #c89b52;
            font-size: 16px;
        }

        .recipe-description {
            font-size: 16px;
            color: #8f4a14;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .creator-info {
            display: flex;
            align-items: center;
            gap: 15px;
            padding-top: 20px;
            border-top: 2px solid #f0e6d6;
        }

        .creator-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 3px solid #c89b52;
            object-fit: cover;
        }

        .creator-details {
            flex: 1;
        }

        .creator-name {
            font-size: 16px;
            font-weight: 700;
            color: #6b300a;
        }

        .creator-date {
            font-size: 13px;
            color: #b08261;
        }

        .recipe-actions {
            display: flex;
            gap: 12px;
            margin-left: auto;
        }

        .action-button {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 20px;
            position: relative;
        }

        .btn-like {
            background: #fde8e8; 
            color: #e74c3c;
        }

        .btn-like.active {
            background: #e74c3c;
            color: #fff;
        }

        .btn-like:hover {
            transform: scale(1.1);
        }

        .btn-save {
            background: #e8f4f8;
            color: #3498db;
        }

        .btn-save.active {
            background: #3498db;
            color: #fff;
        }

        .btn-save:hover {
            transform: scale(1.1);
        }

        .action-count {
            position: absolute;
            bottom: -8px;
            right: -8px;
            background: #6b300a;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 20px;
        }

        /* MEDIA SECTION */
        .media-section {
            background: #fff;
            border-radius: 30px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .recipe-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 20px;
            margin-bottom: 20px;
        }

        .recipe-video {
            width: 100%;
            height: 500px;
            border-radius: 20px;
        }

        /* CONTENT GRID */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .content-card {
            background: #fff;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .content-title {
            font-size: 28px;
            font-weight: 800;
            color: #6b300a;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .content-title i {
            color: #c89b52;
            font-size: 30px;
        }

        /* INGREDIENTS */
        .ingredient-item {
            padding: 12px 0;
            border-bottom: 1px solid #f0e6d6;
            font-size: 15px;
            color: #8f4a14;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .ingredient-item:last-child {
            border-bottom: none;
        }

        .ingredient-item i {
            color: #c89b52;
            font-size: 8px;
        }

        /* INSTRUCTIONS */
        .instruction-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0e6d6;
        }

        .instruction-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .step-number {
            width: 35px;
            height: 35px;
            background: #c89b52;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
        }

        .step-text {
            flex: 1;
            font-size: 15px;
            color: #8f4a14;
            line-height: 1.7;
            padding-top: 5px;
        }

        /* COMMENTS SECTION */
        .comments-section {
            background: #fff;
            border-radius: 30px;
            padding: 40px;
            margin-top: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .comment-box {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .comment-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            border: 2px solid #c89b52;
            flex-shrink: 0;
        }

        .comment-input {
            flex: 1;
        }

        .comment-input textarea {
            width: 100%;
            border: 2px solid #e6dcc8;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            color: #6b300a;
            font-family: 'Fredoka', sans-serif;
            resize: vertical;
            min-height: 80px;
        }

        .comment-input textarea:focus {
            outline: none;
            border-color: #c89b52;
        }

        .comment-submit {
            background: #c89b52;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .comment-submit:hover {
            background: #a85a1a;
        }

        .comments-list {
            margin-top: 30px;
        }

        .comment-item {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #f0e6d6;
        }

        .comment-item:last-child {
            border-bottom: none;
        }

        .comment-content {
            flex: 1;
        }

        .comment-author {
            font-size: 15px;
            font-weight: 700;
            color: #6b300a;
            margin-bottom: 5px;
        }

        .comment-date {
            font-size: 12px;
            color: #b08261;
            margin-bottom: 10px;
        }

        .comment-text {
            font-size: 14px;
            color: #8f4a14;
            line-height: 1.6;
        }

        /* COMMENT BTN DROPDOWN */
        .comment-btn-dropdown {
            position: absolute;
            top: 25px; /* Adjust based on icon size */
            right: 0;
            background: #fff;
            border: 1px solid #e6dcc8;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            min-width: 100px;
            z-index: 100;
            display: none;
        }

        .comment-btn-dropdown.active {
            display: block;
        }

        .comment-btn-dropdown button {
            width: 100%;
            padding: 12px 15px;
            border: none;
            background: none;
            color: #e74c3c;
            text-align: right;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            font-family: 'Fredoka', sans-serif;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .comment-btn-dropdown button:hover {
            background: #fde8e8;
        }

        /* RESPONSIVE */
        @media (max-width: 968px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .recipe-title {
                font-size: 32px;
            }

            .recipe-image,
            .recipe-video {
                height: 350px;
            }

            .back-button {
                top: 15px;
                left: 15px;
            }
        }
    </style>
</head>

<body>

    <!-- BACK BUTTON -->
    <button class="back-button" onclick="goBack()">
        <i class="bi bi-arrow-left"></i>
    </button>

    <!-- RECIPE SECTION -->
    <section class="recipe-section">
        <div id="recipeContainer">
            <!-- Recipe content will be generated here -->
        </div>
    </section>

    <script>

        // Fetch current user
        let currentUserId = null;

        fetch('get-user-profile.php')
            .then(res => res.json())
            .then(data => { currentUserId = data.user_id; });

        // Get recipe ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        const recipeId = urlParams.get('id');

        if (!recipeId) {
            alert('Recipe not found');
            window.location.href = 'Recipes.php';
        }

        // Fetch recipe from database
        fetch('get-recipe.php?id=' + recipeId)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('Error: ' + data.error);
                    window.location.href = 'Recipes.php';
                } else {
                    renderRecipe(data);
                }
            })
            .catch(error => {
                console.error('Error loading recipe:', error);
                alert('Failed to load recipe');
            });

        // Function to render recipe
        function renderRecipe(recipe) {
            const container = document.getElementById('recipeContainer');
            
            // Format date
            const date = new Date(recipe.creator.createdDate);
            const formattedDate = date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
            
            // Generate ingredients HTML
            const ingredientsHTML = recipe.ingredients.map(ingredient => `
                <div class="ingredient-item">
                    <i class="bi bi-circle-fill"></i>
                    <span>${ingredient}</span>
                </div>
            `).join('');
            
            // Generate instructions HTML
            const instructionsHTML = recipe.instructions.map((instruction, index) => `
                <div class="instruction-item">
                    <div class="step-number">${index + 1}</div>
                    <div class="step-text">${instruction}</div>
                </div>
            `).join('');
            
            // Generate comments HTML
            const commentsHTML = recipe.comments.map(comment => {
                const commentDate = new Date(comment.date);
                const commentFormattedDate = commentDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                
                const isAuthor = (currentUserId && parseInt(comment.authorId) === parseInt(currentUserId));

                // Only generate the icon and dropdown if isAuthor is true
                const actionMenu = isAuthor ? `
                    <div style="float: right; position: relative;">
                        <i class="bi bi-three-dots-vertical" 
                        onclick="toggleCommentBtnDropdown(event, ${comment.id})" 
                        style="cursor: pointer;"></i>
                        
                        <div class="comment-btn-dropdown" id="dropdown-${comment.id}">
                            <button onclick="deleteComment(${comment.id})">
                                <i class="bi bi-trash-fill"></i> Delete
                            </button>
                        </div>
                    </div>
                ` : '';

                return `
                    <div class="comment-item">
                        <img src="${comment.avatar}" alt="${comment.author}" class="comment-avatar">
                        <div class="comment-content">
                            <div class="comment-author" style="position: relative;">
                                ${comment.author}
                                <span style="color: #b08261; font-weight: 600;">${comment.username}</span>
                                ${actionMenu}
                            </div>
                            <div class="comment-date">${commentFormattedDate}</div>
                            <div class="comment-text">${comment.text}</div>
                        </div>
                    </div>
                `;
            }).join('');
            
            // Video section (if video exists)
            let mediaSection = '';
            if (recipe.videoUrl) {
                if (recipe.videoUrl.includes('youtube.com') || recipe.videoUrl.includes('youtu.be')) {
                    mediaSection = `
                        <div class="media-section">
                            <iframe class="recipe-video" src="${recipe.videoUrl}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    `;
                } else {
                    mediaSection = `
                        <div class="media-section">
                            <video class="recipe-video" controls>
                                <source src="${recipe.videoUrl}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    `;
                }
            }

            // Check the liked state from the database
            const likedRecipe = recipe.isLiked ? 'active' : '';
            
            // Check the saved state from the database
            const savedRecipe = recipe.isSaved ? 'active' : '';
            
            container.innerHTML = `
                <!-- HEADER -->
                <div class="recipe-header">
                    <h1 class="recipe-title">${recipe.title}</h1>
                    
                    <div class="recipe-meta">
                        <div class="meta-badge">
                            <i class="bi bi-tag-fill"></i>
                            <span>${recipe.category}</span>
                        </div>
                        <div class="meta-badge">
                            <i class="bi bi-clock-fill"></i>
                            <span>${recipe.time}</span>
                        </div>
                        <div class="meta-badge">
                            <i class="bi bi-people-fill"></i>
                            <span>${recipe.servings} servings</span>
                        </div>
                        <div class="meta-badge">
                            <i class="bi bi-bar-chart-fill"></i>
                            <span>${recipe.difficulty}</span>
                        </div>
                    </div>
                    
                    <p class="recipe-description">${recipe.description}</p>
                    
                    <div class="creator-info">
                        <img src="${recipe.creator.avatar}" alt="${recipe.creator.name}" class="creator-avatar">
                        <div class="creator-details">
                            <div class="creator-name">${recipe.creator.name}</div>
                            <div class="creator-date">Posted on ${formattedDate}</div>
                        </div>
                        
                        <div class="recipe-actions">
                            <button class="action-button btn-like ${likedRecipe}" onclick="toggleLike()" id="likeBtn">
                                <i class="bi bi-heart-fill"></i>
                                <span class="action-count" id="likeCount">${recipe.stats.likes}</span>
                            </button>
                            <button class="action-button btn-save ${savedRecipe}" onclick="toggleSave()" id="saveBtn">
                                <i class="bi bi-bookmark-fill"></i>
                                <span class="action-count" id="saveCount">${recipe.stats.saves}</span>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- IMAGE -->
                <div class="media-section">
                    <img src="${recipe.image}" alt="${recipe.title}" class="recipe-image">
                </div>
                
                <!-- VIDEO (if exists) -->
                ${mediaSection}
                
                <!-- INGREDIENTS & INSTRUCTIONS -->
                <div class="content-grid">
                    <div class="content-card">
                        <h2 class="content-title">
                            <i class="bi bi-list-check"></i>
                            Ingredients
                        </h2>
                        ${ingredientsHTML}
                    </div>
                    
                    <div class="content-card">
                        <h2 class="content-title">
                            <i class="bi bi-list-ol"></i>
                            Instructions
                        </h2>
                        ${instructionsHTML}
                    </div>
                </div>
                
                <!-- COMMENTS -->
                <div class="comments-section">
                    <h2 class="content-title">
                        <i class="bi bi-chat-dots-fill"></i>
                        Comments (${recipe.stats.comments})
                    </h2>
                    
                    <div class="comment-box">
                        <img id="avatar_img" alt="You" class="comment-avatar">
                        <div class="comment-input">
                            <textarea placeholder="Share your thoughts about this recipe..." id="commentText" style="resize: none;"></textarea>
                            <button class="comment-submit" onclick="postComment()">Post Comment</button>
                        </div>
                    </div>
                    
                    <div class="comments-list">
                        ${commentsHTML}
                    </div>
                </div>
            `;
            loadProfile();
        }

        // Back button
        function goBack() {
            window.history.back();
        }

        // Toggle like
        function toggleLike() {
            const btn = document.getElementById('likeBtn');
            const count = document.getElementById('likeCount');

            let currentCount = parseInt(count.textContent);
            let action = '';
            
            if (btn.classList.contains('active')) {
                btn.classList.remove('active');
                count.textContent = currentCount - 1;
                action = 'remove-like';
            } else {
                btn.classList.add('active');
                count.textContent = currentCount + 1;
                action = 'add-like';
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

        // Toggle save
        function toggleSave() {
            const btn = document.getElementById('saveBtn');
            const count = document.getElementById('saveCount');

            let currentCount = parseInt(count.textContent);
            let action = '';
            
            if (btn.classList.contains('active')) {
                btn.classList.remove('active');
                count.textContent = currentCount - 1;
                action = 'remove-save';
            } else {
                btn.classList.add('active');
                count.textContent = currentCount + 1;
                action = 'add-save';
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

        // Post comment
        function postComment() {
            const textarea = document.getElementById('commentText');
            const text = textarea.value.trim();
            
            if (text) {
                // Send to backend
                fetch('post-comment.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ 
                        recipe_id: recipeId, 
                        comment: text 
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Comment posted successfully! 🎉');
                        textarea.value = '';
                        // Reload recipe to show new comment
                        window.location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to post comment');
                });
            }
        }

        // Fetch avatar image
        async function loadProfile() {
            try {
                // Fetch JSON data from backend
                const response = await fetch('get-user-profile.php');
                const data = await response.json();

                // Find the image element by id, and set the receive image
                document.getElementById('avatar_img').src = data.avatar_img;
            } catch (error) {
                console.error('Error loading user profile: ', error);
            }
        }

        // Toggle comment dropdown
        function toggleCommentBtnDropdown(event, commentId) {
            event.stopPropagation(); // Prevent the global click listener from immediately closing it
            
            // Close all other open dropdowns first
            document.querySelectorAll('.comment-btn-dropdown').forEach(dropdown => {
                if (dropdown.id !== `dropdown-${commentId}`) {
                    dropdown.classList.remove('active');
                }
            });

            // Toggle the clicked one
            const currentDropdown = document.getElementById(`dropdown-${commentId}`);
            currentDropdown.classList.toggle('active');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            document.querySelectorAll('.comment-btn-dropdown').forEach(dropdown => {
                dropdown.classList.remove('active');
            });
        });

        // For deleting a comment
        function deleteComment(commentId) {
            if (confirm('Are you sure you want to delete this comment?')) {
                fetch('delete-comment.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ comment_id: commentId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Comment deleted successfully! 🎉');
                        // Smoothly reload to update comment count and list
                        window.location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(err => console.error('Error deleting comment:', err));
            }
        }
    </script>
</body>
</html>