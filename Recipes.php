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
    </style>
</head>

<body>

    <!--navbar-->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container d-flex align-items-center">

            <!-- LOGO -->
            <a class="navbar-brand me-auto" href="#">
                <img src="Asset/Logo.png" alt="Sweet Creation Logo" width="120" height="110">
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
    </script>

</body>
</html>
