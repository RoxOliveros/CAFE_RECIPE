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
                            <input type="text" list="recipe-title-list" id="recipeTitle" maxlength="50" class="form-control" name="title" placeholder="e.g., Chocolate Chip Cookies" required>                        
                        </div>

                        <datalist id="recipe-title-list"></datalist>

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
                            <textarea id="recipeDescription" oninput="this.value = this.value.replace(/^[ \n]/g, '')" maxlength="200" class="form-control" name="description" placeholder="Brief description of your recipe..." style="resize: none;" required></textarea>
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
                            <input type="url" oninput="this.value = this.value.replace(/ {2,}/g, ' ').replace(/^ /g, '')" maxlength="75" class="form-control" name="youtube_url" placeholder="https://youtube.com/watch?v=...">
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
                                <input type=text list="ingredient-list" oninput="this.value = this.value.replace(/ {2,}/g, ' ').replace(/^ /g, '')" id="ingredient" maxlength="50" class="form-control" name="ingredients[]" placeholder="e.g., 2 cups all-purpose flour" required>
                                <!-- <button type="button" class="btn-remove-item" onclick="removeItem(this)" style="visibility: hidden;">
                                    <i class="bi bi-trash"></i>
                                </button> -->
                            </div>
                        </div>

                        <datalist id="ingredient-list"></datalist>

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
                                <input type="text" list="instruction-list" oninput="this.value = this.value.replace(/ {2,}/g, ' ').replace(/^ /g, '')" id="instruction" maxlength="50" class="form-control" name="instructions[]" placeholder="Step 1: Preheat oven to 350°F" required>
                                <!-- <button type="button" class="btn-remove-item" onclick="removeItem(this)" style="visibility: hidden;">
                                    <i class="bi bi-trash"></i>
                                </button> -->
                            </div>
                        </div>

                        <datalist id="instruction-list"></datalist>

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
                <input type=text list="ingredient-list" oninput="this.value = this.value.replace(/ {2,}/g, ' ').replace(/^ /g, '')" id="ingredient" maxlength="50" class="form-control" name="ingredients[]" placeholder="..." required>
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
                <input type="text" list="instruction-list" oninput="this.value = this.value.replace(/ {2,}/g, ' ').replace(/^ /g, '')" id="instruction" maxlength="50" class="form-control" name="instructions[]" placeholder="Step ${stepNumber}: ..." required>
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

            const titleInput = document.getElementById('recipeTitle');
            const descriptionInput = document.getElementById('recipeDescription');

            // TITLE VALIDATION
            const titleCheck = validateTitleValue(titleInput.value);
            if (!titleCheck.valid) {
                showError(titleCheck.message, 'Validation Error');
                titleInput.focus();
                return;
            }

            // DESCRIPTION VALIDATION
            const descCheck = validateDescriptionValue(descriptionInput.value);
            if (!descCheck.valid) {
                showError(descCheck.message, 'Validation Error');
                descriptionInput.focus();
                return;
            }         
            
            // INGREDIENT VALIDATION 
            const ingredientInputs = document.querySelectorAll('input[name="ingredients[]"]');
            for (let input of ingredientInputs) {
                const ingredientCheck = validateIngredientValue(input.value);
                if (!ingredientCheck.valid) {
                    showError(ingredientCheck.message, 'Validation Error');
                    input.focus();
                    return;
                }
            }

            // INSTRUCTION VALIDATION (NEW)
            const instructionInputs = document.querySelectorAll('input[name="instructions[]"]');
            for (let input of instructionInputs) {
                const instructionCheck = validateInstructionValue(input.value);
                if (!instructionCheck.valid) {
                    showError(instructionCheck.message, 'Validation Error');
                    input.focus();
                    return;
                }
            }
            
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

        const recipeTitles = [
            // CAKES & CUPCAKES
            "Lemon Chiffon Cake", "Double Chocolate Cake", "Classic Yellow Cake", "Carrot Walnut Cake", 
            "Confetti Birthday Cupcakes", "Mocha Latte Cupcakes", "Marble Bundt Cake", "Red Velvet Cupcakes", 
            "Angel Food Cake", "Hummingbird Cake", "Flourless Chocolate Cake", "Sticky Toffee Pudding",

            // COOKIES & BARS
            "Oatmeal Raisin Cookies", "Peanut Butter Cookies", "Sugar Cookie Bars", "Chocolate Chunk Cookies", 
            "Pistachio Shortbread", "Chewy Ginger Molasses", "Magic Cookie Bars", "Espresso Brownies", "Glazed Donuts",
            "White Chocolate Blondies", "Seven Layer Bars", "Lemon Glaze Bars", "Rocky Road Brownies",

            // PIES & TARTS
            "Dutch Apple Pie", "Blueberry Galette", "Key Lime Pie", "Chocolate Silk Pie", 
            "Fresh Strawberry Tart", "Banana Cream Pie", "Pumpkin Spice Pie", "Pear Frangipane Tart", 
            "Mixed Berry Crostata", "Cherry Lattice Pie", "Lemon Meringue Pie", "Rustic Peach Tart",

            // FROZEN & CUSTARDS
            "Vanilla Bean Gelato", "Mango Sorbet", "Mint Chocolate Chip", "Salted Caramel Swirl", 
            "Vanilla Crème Brûlée", "Chocolate Pot Crème", "Classic Rice Pudding", "Mixed Berry Sorbet", 
            "Strawberry Cheesecake Icecream", "Toasted Coconut Parfait", "Coffee Panna Cotta", "Chocolate Mousse"
        ];
        document.getElementById('recipe-title').addEventListener('input', function() {
            const val = this.value.toLowerCase();

            const dataList = document.getElementById('recipe-title-list');
            dataList.innerHTML = '';

            if (val.length > 0) {
                // Filter options that match and limit to 5
                const filtered = recipeTitles
                    .filter(opt => opt.toLowerCase().includes(val))
                    .slice(0, 5); 

                filtered.forEach(opt => {
                    const option = document.createElement('option');
                    option.value = opt;
                    dataList.appendChild(option);
                });
            }
        });
        
        const commonIngredients = [
            "2 cups of white sugar", "1/2 cup of milk", "1/4 cup of cocoa powder", "1 pinch of cinnamon", 
            "1/4 cup of flour", "1/2 cup of greek yogurt", "100g of dark chocolate", "1/2 teaspoon of salt", 
            "1 cup of chocolate chips", "1/4 cup of butter", "1/2 cup of sour cream", "1 teaspoon of baking soda", 
            "1 cup of butter", "1/4 cup of white sugar", "2 teaspoons of baking powder", "1/4 cup of brown sugar", 
            "2 cups of chocolate chips", "3 large eggs", "1 1/2 cups of flour", "1 teaspoon of baking powder", 
            "1 tablespoon of vanilla", "1/2 cup of butter", "1/4 cup of oil", "1/2 cup of chocolate chips", 
            "1/4 teaspoon of nutmeg", "4 large eggs", "1 cup of flour", "1/2 teaspoon of cinnamon", 
            "1/2 teaspoon of baking powder", "1 teaspoon of salt", "1/2 cup of chopped pecans", "1/4 cup of honey", 
            "1/2 cup of oil", "1/2 teaspoon of vanilla", "200g of dark chocolate", "1 teaspoon of vanilla", 
            "1/4 teaspoon of salt", "canola oil", "1 cup of white sugar", "1/2 cup of white sugar", 
            "1/2 teaspoon of baking soda", "1 drop of vanilla", "1 cup of milk", "1 tablespoon of lemon juice", 
            "1/4 cup of milk", "1/2 cup of flour", "2 cups of flour", "1/2 cup of brown sugar", 
            "1 tablespoon of honey", "1 teaspoon of lemon zest", "1 large egg", "vegetable oil", 
            "3/4 cup of butter", "2 tablespoons of honey", "buttermilk", "coconut oil", 
            "1 egg yolk", "2 egg whites", "whole milk", "1/2 cup of sliced almonds", 
            "packed brown sugar", "1 cup of brown sugar"
        ];
        document.getElementById('ingredientsList').addEventListener('input', function(e) {
            if (e.target && e.target.name === "ingredients[]") {
                const val = e.target.value.toLowerCase();
                const dataList = document.getElementById('ingredient-list');
                
                dataList.innerHTML = ''; 

                if (val.length > 0) {
                    // Filter options that match and limit to 5
                    const filtered = commonIngredients
                        .filter(opt => opt.toLowerCase().includes(val))
                        .slice(0, 5); 

                    filtered.forEach(opt => {
                        const option = document.createElement('option');
                        option.value = opt;
                        dataList.appendChild(option);
                    });
                }
            }
        });
        
        const commonInstructions = [
            "Bake for 15 to 20 minutes", "Preheat oven to 375°F", "Whisk until stiff peaks form", "Beat on medium speed", 
            "Preheat oven to 325°F", "Line the pan with parchment paper", "Cool in the pan for 10 minutes", "Check with a toothpick", 
            "Preheat oven to 400°F", "Sift the cocoa powder", "Dust with powdered sugar", "Cream the butter and sugar", 
            "Fold in the chocolate chips", "Grease the baking dish", "Do not overmix the batter", "Transfer to a wire rack", 
            "Preheat oven to 350°F", "Mix until just combined", "Bake for 45 minutes", "Add eggs one at a time", 
            "Stir until smooth", "Whisk the dry ingredients together", "Beat on high speed", "Bake for 25 to 30 minutes", 
            "Melt in 30 second intervals", "Sift the flour and salt", "Fold in the dry ingredients", "Preheat oven to 300°F", 
            "Chill in the fridge overnight", "Cool completely before frosting", "Butter and flour the cake pan", 
            "Rotate the pan halfway through", "Mix dry ingredients together", "Bake for 10 to 12 minutes", 
            "Drizzle with caramel sauce", "Store in an airtight container", "Beat until light and fluffy", "Fold in the nuts"
        ];
        document.getElementById('instructionsList').addEventListener('input', function(e) {
            if (e.target && e.target.name === "instructions[]") {
                const val = e.target.value.toLowerCase();
                const dataList = document.getElementById('instruction-list');
                
                dataList.innerHTML = ''; 

                if (val.length > 0) {
                    // Filter options that match and limit to 5
                    const filtered = commonInstructions
                        .filter(opt => opt.toLowerCase().includes(val))
                        .slice(0, 5); 

                    filtered.forEach(opt => {
                        const option = document.createElement('option');
                        option.value = opt;
                        dataList.appendChild(option);
                    });
                }
            }
        });

        // validation for title
        function validateTitleValue(value) {
            const trimmed = value.trim();

            if (trimmed.length < 3) {
                return {
                    valid: false,
                    message: 'Title must be at least 3 characters.'
                };
            }

            const titlePattern = /^(?=.*[aeiouAEIOU])[A-Za-z ]{3,}$/;

            if (!titlePattern.test(trimmed)) {
                return {
                    valid: false,
                    message: 'Title must contain real words (letters only).'
                };
            }

            return { valid: true };
        }

        //validation for description
        function validateDescriptionValue(value) {
            const trimmed = value.trim();

            if (trimmed.length < 10) {
                return {
                    valid: false,
                    message: 'Description must be at least 10 characters.'
                };
            }

            if (!/[aeiouAEIOU]/.test(trimmed)) {
                return {
                    valid: false,
                    message: 'Description must contain real words.'
                };
            }

            const descriptionPattern = /^[A-Za-z0-9 ,.'"!?()\-\n]+$/;

            if (!descriptionPattern.test(trimmed)) {
                return {
                    valid: false,
                    message: 'Description contains invalid characters.'
                };
            }

            return { valid: true };
        }

        // validation for ingredients
        function validateIngredientValue(value) {
            const trimmed = value.trim();

            if (trimmed.length < 3) {
                return {
                    valid: false,
                    message: 'Each ingredient must be at least 3 characters.'
                };
            }

            if (!/[aeiouAEIOU]/.test(trimmed)) {
                return {
                    valid: false,
                    message: 'Ingredient must contain real words.'
                };
            }

            const ingredientPattern = /^[A-Za-z0-9 /.'\-]+$/;

            return { valid: true };
        }

        // validation for instructions
        function validateInstructionValue(value) {
            const trimmed = value.trim();

            if (trimmed.length < 3) {
                return {
                    valid: false,
                    message: 'Each instruction must be at least 3 characters.'
                };
            }

            if (!/[aeiouAEIOU]/.test(trimmed)) {
                return {
                    valid: false,
                    message: 'Instruction must contain real words.'
                };
            }

            const instructionPattern = /^[A-Za-z0-9 /.'\-,:!?]+$/;
            return { valid: true };
        }
        
</script>
</body>
</html>