<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Creation - Create Recipe</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="toast-notifications.css">

    <style>
        body {
            background-color: #f9f4e9;
            font-family: 'Fredoka', sans-serif;
            padding: 40px 20px;
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

        /* CREATE RECIPE SECTION */
        .create-section {
            padding-top: 20px;
            padding-bottom: 80px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .create-title {
            font-size: 48px;
            font-weight: 900;
            color: #8f4a14;
            margin-bottom: 15px;
            text-align: center;
        }

        .create-subtitle {
            font-size: 16px;
            color: #b08261;
            text-align: center;
            margin-bottom: 50px;
        }

        .create-form-container {
            background: #fff;
            border-radius: 30px;
            padding: 50px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .form-section {
            margin-bottom: 35px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #6b300a;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: #c89b52;
            font-size: 22px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #8f4a14;
            margin-bottom: 8px;
        }

        .required {
            color: #e74c3c;
        }

        .form-control, .form-select {
            border: 2px solid #e6dcc8;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            color: #6b300a;
            font-family: 'Fredoka', sans-serif;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #c89b52;
            box-shadow: 0 0 0 3px rgba(200, 155, 82, 0.1);
            outline: none;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* IMAGE UPLOAD */
        .image-upload-container {
            border: 3px dashed #c89b52;
            border-radius: 16px;
            padding: 40px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #faf7f2;
        }

        .image-upload-container:hover {
            border-color: #8f4a14;
            background: #f9f4e9;
        }

        .image-upload-container.has-image {
            border-style: solid;
            padding: 0;
            overflow: hidden;
        }

        .upload-icon {
            font-size: 48px;
            color: #c89b52;
            margin-bottom: 15px;
        }

        .upload-text {
            font-size: 16px;
            font-weight: 600;
            color: #8f4a14;
            margin-bottom: 5px;
        }

        .upload-subtext {
            font-size: 13px;
            color: #b08261;
        }

        .preview-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 13px;
        }

        .remove-image {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-image:hover {
            background: #e74c3c;
            color: #fff;
            transform: scale(1.1);
        }

        /* VIDEO OPTIONS */
        .video-options {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .video-option-btn {
            flex: 1;
            padding: 15px;
            border: 2px solid #e6dcc8;
            border-radius: 12px;
            background: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 600;
            color: #8f4a14;
        }

        .video-option-btn:hover {
            border-color: #c89b52;
            background: #faf7f2;
        }

        .video-option-btn.active {
            border-color: #c89b52;
            background: #c89b52;
            color: #fff;
        }

        .video-option-btn i {
            font-size: 20px;
        }

        .video-input-container {
            display: none;
        }

        .video-input-container.active {
            display: block;
        }

        /* INGREDIENTS & INSTRUCTIONS */
        .input-group-item {
            display: flex;
            gap: 10px;
            margin-bottom: 12px;
            align-items: center;
        }

        .input-group-item input {
            flex: 1;
        }

        .btn-remove-item {
            background: transparent;
            border: 2px solid #e74c3c;
            color: #e74c3c;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-remove-item:hover {
            background: #e74c3c;
            color: #fff;
        }

        .btn-add-item {
            background: transparent;
            border: 2px dashed #c89b52;
            color: #c89b52;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
        }

        .btn-add-item:hover {
            border-style: solid;
            background: #c89b52;
            color: #fff;
        }

        /* TIME & SERVINGS */
        .input-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* SUBMIT BUTTONS */
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #f0e6d6;
        }

        .btn-submit {
        background: #c89b52; 
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 15px 50px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(200, 155, 82, 0.3);
    }

    .btn-submit:hover {
        background: #a85a1a; /* Darker on hover */
        transform: translateY(-3px);
        box-shadow: 0 6px 25px rgba(200, 155, 82, 0.5);
    }

        .btn-cancel {
            background: transparent;
            color: #8f4a14;
            border: 2px solid #8f4a14;
            border-radius: 50px;
            padding: 15px 50px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #8f4a14;
            color: #fff;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            body {
                padding: 20px 10px;
            }

            .back-button {
                top: 15px;
                left: 15px;
                width: 40px;
                height: 40px;
            }

            .create-form-container {
                padding: 30px 20px;
            }

            .create-title {
                font-size: 36px;
            }

            .input-row {
                grid-template-columns: 1fr;
            }

            .video-options {
                flex-direction: column;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-submit, .btn-cancel {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- BACK BUTTON -->
    <button class="back-button" onclick="goBack()">
        <i class="bi bi-arrow-left"></i>
    </button>

    <!-- CREATE RECIPE SECTION -->
    <section class="create-section">
        <div class="container">
            <h1 class="create-title">Create Your Recipe</h1>
            <p class="create-subtitle">Share your delicious creation with the community!</p>

            <div class="create-form-container">
                <form id="createRecipeForm" enctype="multipart/form-data">
                    
                    <!-- BASIC INFO -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="bi bi-info-circle"></i>
                            Basic Information
                        </h3>

                        <div class="mb-3">
                            <label class="form-label">Recipe Title <span class="required">*</span></label>
                            <input list="recipe-title" class="form-control" name="title" placeholder="e.g., Chocolate Chip Cookies" required>
                        </div>

                        <datalist id="recipe-title">
                            <option value="Apple Cinnamon Galette">
                            <option value="Blueberry Lemon Parfait">
                            <option value="Chocolate Lava Cake">
                            <option value="Dulce de Leche Flan">
                            <option value="Espresso Tiramisu">
                            <option value="Frozen Strawberry Mousse">
                            <option value="Ginger Pear Crisp">
                            <option value="Honey Walnut Baklava">
                            <option value="Italian Panna Cotta">
                            <option value="Japanese Matcha Mochi">
                        </datalist>

                        <div class="mb-3">
                            <label class="form-label">Category <span class="required">*</span></label>
                            <select class="form-select" name="category" required>
                                <option value="">Select a category</option>
                                <option value="cakes">Cakes & Cupcakes</option>
                                <option value="cookies">Cookies & Bars</option>
                                <option value="frozen">Frozen Desserts</option>
                                <option value="pies">Pies & Tarts</option>
                                <option value="custards">Custards & Puddings</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description <span class="required">*</span></label>
                            <textarea class="form-control" name="description" placeholder="Brief description of your recipe..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Visibility <span class="required">*</span></label>
                            <select class="form-select" name="visibility" required>
                                <option value="">Select visibility</option>
                                <option value="public">Public - Everyone can see</option>
                                <option value="followers">Followers Only - Only your followers can see</option>
                                <option value="private">Private - Only you can see</option>
                            </select>
                        </div>

                        <div class="input-row">
                            <div>
                                <label class="form-label">Cooking Time (minutes) <span class="required">*</span></label>
                                <input type="number" oninput="if(this.value > 1440) this.value = 1440;" min="1" class="form-control" name="time" placeholder="e.g., 45" required>
                            </div>
                            <div>
                                <label class="form-label">Servings <span class="required">*</span></label>
                                <input type="number" oninput="if(this.value > 99) this.value = 99;" min="1" class="form-control" name="servings" placeholder="e.g., 12" required>
                            </div>
                        </div>
                    </div>

                    <!-- THUMBNAIL IMAGE -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="bi bi-image"></i>
                            Recipe Thumbnail <span class="required">*</span>
                        </h3>

                        <div class="image-upload-container" id="thumbnailUpload" onclick="document.getElementById('thumbnailInput').click()">
                            <div id="uploadPlaceholder">
                                <i class="bi bi-cloud-upload upload-icon"></i>
                                <div class="upload-text">Click to upload thumbnail</div>
                                <div class="upload-subtext">PNG, JPG up to 5MB</div>
                            </div>
                            <div id="imagePreview" style="display: none; position: relative;">
                                <img id="previewImg" class="preview-image" src="" alt="Preview">
                                <button type="button" class="remove-image" onclick="removeImage(event)">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                        <input type="file" id="thumbnailInput" name="thumbnail" accept="image/*" style="display: none;" onchange="previewImage(event)" required>
                    </div>

                    <!-- VIDEO SECTION -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="bi bi-camera-video"></i>
                            Recipe Video (Optional)
                        </h3>

                        <div class="video-options">
                            <button type="button" class="video-option-btn" data-option="none" onclick="selectVideoOption('none')">
                                <i class="bi bi-x-circle"></i>
                                No Video
                            </button>
                            <button type="button" class="video-option-btn" data-option="upload" onclick="selectVideoOption('upload')">
                                <i class="bi bi-upload"></i>
                                Upload Video
                            </button>
                            <button type="button" class="video-option-btn" data-option="youtube" onclick="selectVideoOption('youtube')">
                                <i class="bi bi-youtube"></i>
                                YouTube Link
                            </button>
                        </div>

                        <div id="uploadVideoContainer" class="video-input-container">
                            <label class="form-label">Upload Video File</label>
                            <input type="file" class="form-control" name="video_file" accept="video/*">
                            <small class="text-muted">Max 50MB</small>
                        </div>

                        <div id="youtubeContainer" class="video-input-container">
                            <label class="form-label">YouTube Video URL</label>
                            <input type="url" class="form-control" name="youtube_url" placeholder="https://youtube.com/watch?v=...">
                        </div>
                    </div>

                    <!-- INGREDIENTS -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="bi bi-list-ul"></i>
                            Ingredients <span class="required">*</span>
                        </h3>

                        <div id="ingredientsList">
                            <div class="input-group-item">
                                <input list="ingredient-list" class="form-control" name="ingredients[]" placeholder="e.g., 2 cups all-purpose flour" required>
                                <!-- <button type="button" class="btn-remove-item" onclick="removeItem(this)" style="visibility: hidden;">
                                    <i class="bi bi-trash"></i>
                                </button> -->
                            </div>
                        </div>

                        <datalist id="ingredient-list">
                            <option value="1 cup sugar">
                            <option value="2 cups all-purpose flour">
                            <option value="1/2 cup unsalted butter, softened">
                            <option value="2 large eggs">
                            <option value="1 tsp vanilla extract">
                            <option value="1/2 tsp baking soda">
                            <option value="1/4 tsp salt">
                            <option value="1 cup chocolate chips">
                            <option value="1/2 cup milk">
                            <option value="1 tbsp olive oil">
                        </datalist>

                        <button type="button" class="btn-add-item" onclick="addIngredient()">
                            <i class="bi bi-plus-circle"></i>
                            Add Ingredient
                        </button>
                    </div>

                    <!-- INSTRUCTIONS -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="bi bi-list-ol"></i>
                            Instructions <span class="required">*</span>
                        </h3>

                        <div id="instructionsList">
                            <div class="input-group-item">
                                <input list="instruction-list" class="form-control" name="instructions[]" placeholder="Step 1: Preheat oven to 350°F" required>
                                <!-- <button type="button" class="btn-remove-item" onclick="removeItem(this)" style="visibility: hidden;">
                                    <i class="bi bi-trash"></i>
                                </button> -->
                            </div>
                        </div>

                        <datalist id="instruction-list">
                            <option value="Preheat oven to 350°F">
                            <option value="Mix dry ingredients together">
                            <option value="Cream butter and sugar">
                            <option value="Add eggs one at a time">
                            <option value="Fold in wet and dry ingredients">
                            <option value="Pour batter into prepared pan">
                            <option value="Bake for 25-30 minutes">
                            <option value="Let cool before frosting">
                            <option value="Prepare frosting while cake cools">
                            <option value="Decorate as desired">
                        </datalist>

                        <button type="button" class="btn-add-item" onclick="addInstruction()">
                            <i class="bi bi-plus-circle"></i>
                            Add Step
                        </button>
                    </div>

                    <!-- FORM ACTIONS -->
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="cancelForm()">Cancel</button>
                        <button type="submit" class="btn-submit">Publish Recipe</button>
                    </div>

                </form>
            </div>
        </div>
    </section>

    <script src="toast-notifications.js" defer></script>
    <script>
        // Back button
        function goBack() {
            window.history.back();
        }

        // Image preview
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('uploadPlaceholder').style.display = 'none';
                    document.getElementById('imagePreview').style.display = 'block';
                    document.getElementById('thumbnailUpload').classList.add('has-image');
                }
                reader.readAsDataURL(file);
            }
        }

        function removeImage(event) {
            event.stopPropagation();
            document.getElementById('thumbnailInput').value = '';
            document.getElementById('uploadPlaceholder').style.display = 'block';
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('thumbnailUpload').classList.remove('has-image');
        }

        // Video option selection
        let currentVideoOption = 'none';

        function selectVideoOption(option) {
            document.querySelectorAll('.video-option-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            document.querySelector(`[data-option="${option}"]`).classList.add('active');

            document.querySelectorAll('.video-input-container').forEach(container => {
                container.classList.remove('active');
            });

            if (option === 'upload') {
                document.getElementById('uploadVideoContainer').classList.add('active');
            } else if (option === 'youtube') {
                document.getElementById('youtubeContainer').classList.add('active');
            }

            currentVideoOption = option;
        }

        selectVideoOption('none');

        // Add ingredient
        function addIngredient() {
            const container = document.getElementById('ingredientsList');
            const newItem = document.createElement('div');
            newItem.className = 'input-group-item';
            newItem.innerHTML = `
                <input list="ingredient-list" class="form-control" name="ingredients[]" placeholder="..." required>
                <button type="button" class="btn-remove-item" onclick="removeItem(this)">
                    <i class="bi bi-trash"></i>
                </button>
            `;
            container.appendChild(newItem);
            newItem.querySelector('input').focus(); 
        }

        // Add instruction
        function addInstruction() {
            const container = document.getElementById('instructionsList');
            const stepNumber = container.children.length + 1;
            const newItem = document.createElement('div');
            newItem.className = 'input-group-item';
            newItem.innerHTML = `
                <input list="instruction-list" class="form-control" name="instructions[]" placeholder="Step ${stepNumber}: ..." required>
                <button type="button" class="btn-remove-item" onclick="removeItem(this)">
                    <i class="bi bi-trash"></i>
                </button>
            `;
            container.appendChild(newItem);
            newItem.querySelector('input').focus(); 
        }

        // Remove item
        function removeItem(button) {
            button.parentElement.remove();
        }

        // Cancel form
        function cancelForm() {
            if (confirm('Are you sure you want to cancel? All unsaved changes will be lost.')) {
                window.history.back();
            }
        }

       // Form submission
        document.getElementById('createRecipeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);

            const loadingToast = showLoading('Publishing recipe...', 'Please wait');
            
            // Add video option to form data
            formData.append('video_option', currentVideoOption);
            
            // Show loading message
            const submitBtn = this.querySelector('.btn-submit');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Publishing...';
            submitBtn.disabled = true;
            
            fetch('submit-recipe.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                setTimeout(() => {
                    loadingToast.close();
                }, 1500);
                
                setTimeout(() => {
                    if (data.success) {
                        // Show success toast
                        showSuccess('Recipe created successfully! 🎉');
                        
                        setTimeout(() => {
                    window.location.href = 'YourCreation.php';
                        }, 1500);
                    } else {
                        // Show error toast
                        showError(data.message || 'Failed to publish recipe');
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }
                }, 1500);
            })
            .catch(error => {
                loadingToast.close();
                console.error('Error:', error);

                alter('An error occurred while creating the recipe.');
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });

    </script>

</body>
</html>