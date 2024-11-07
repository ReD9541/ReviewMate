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
    <link rel="stylesheet" href="/ReviewMate/assets/css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        /* Additional styling for better navigation experience */
        .navbar-brand img {
            height: 30px; /* Adjusted height for a smaller logo */
            width: auto;
        }
        
        .navbar .nav > li > a {
            font-weight: bold;
            color: #333;
        }
        
        .navbar .nav > li.active > a, .navbar .nav > li > a:hover {
            background-color: #e7e7e7;
            color: #0056b3;
        }
        
        .navbar .nav > li > a:focus {
            outline: none;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Logo and link to homepage -->
        <a class="navbar-brand" href="/ReviewMate/index.php">
            <img src="/ReviewMate/assets/images/logo/logo.png" alt="ReviewMate Logo">
        </a>

        <!-- Right-side navigation -->
        <ul class="nav navbar-nav navbar-right">
            <?php if (isset($_SESSION['id'])): ?>
                <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
                    <a class="nav-link" href="/ReviewMate/user/profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/ReviewMate/auth/process/logout.php">Logout</a>
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
</nav>

<!-- jQuery and Bootstrap JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.min.js"></script>