<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ReviewMate</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <!-- Custom CSS -->
    <style>
        /* Navbar brand logo */
        .navbar-brand img {
            height: 40px;
            width: auto;
        }

        /* Navbar links */
        .navbar-nav .nav-link {
            font-weight: bold;
            color: #333;
        }

        /* Active and hover states */
        .navbar-nav .nav-item.active .nav-link,
        .navbar-nav .nav-link:hover {
            background-color: #e7e7e7;
            color: #0056b3;
        }

        /* Remove focus outline */
        .navbar-nav .nav-link:focus {
            outline: none;
        }

        /* Ensure body takes full height */
        html, body {
            height: 100%;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!-- Logo and link to homepage -->
        <a class="navbar-brand" href="/ReviewMate/index.php">
            <img src="/ReviewMate/assets/images/logo/logo.png" alt="ReviewMate Logo">
        </a>

        <!-- Toggle button for mobile view -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION['id'])): ?>
                    <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
                        <a class="nav-link" href="/ReviewMate/user/profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ReviewMate/auth/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>">
                        <a class="nav-link" href="/ReviewMate/auth/page/login.php">Login</a>
                    </li>
                    <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : ''; ?>">
                        <a class="nav-link" href="/ReviewMate/auth/page/register.php">Sign Up</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


