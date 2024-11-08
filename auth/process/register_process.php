<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once '../../includes/db_connect.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form inputs
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = $_POST['password']; 
    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $fname = trim(mysqli_real_escape_string($conn, $_POST['fname']));
    $lname = trim(mysqli_real_escape_string($conn, $_POST['lname']));
    $country = isset($_POST['country']) ? trim(mysqli_real_escape_string($conn, $_POST['country'])) : null;
    $address = isset($_POST['address']) ? trim(mysqli_real_escape_string($conn, $_POST['address'])) : null;
    $bio = isset($_POST['bio']) ? trim(mysqli_real_escape_string($conn, $_POST['bio'])) : null;

    // Validate required fields
    if (empty($username) || empty($email) || empty($password) || empty($fname) || empty($lname)) {
        $_SESSION['error'] = "Please fill in all required fields.";
        header("Location: /ReviewMate/auth/page/register.php");
        exit();
    }

    // Check if username or email already exists
    $check_query = "SELECT * FROM userlogin WHERE username = ? OR email = ?";
    if ($stmt = mysqli_prepare($conn, $check_query)) {
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $_SESSION['error'] = "Username or email already exists.";
            mysqli_stmt_close($stmt);
            header("Location: /ReviewMate/auth/page/register.php");
            exit();
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = "Database error: Unable to prepare statement.";
        header("Location: /ReviewMate/auth/page/register.php");
        exit();
    }

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Insert into userlogin table
        $insert_userlogin = "INSERT INTO userlogin (username, password_hash, email) VALUES (?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $insert_userlogin)) {
            mysqli_stmt_bind_param($stmt, "sss", $username, $password_hash, $email);
            mysqli_stmt_execute($stmt);
            $login_id = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);
        } else {
            throw new Exception("Database error: Unable to prepare statement for userlogin.");
        }

        // Insert into userinfo table
        $insert_userinfo = "INSERT INTO userinfo (login_id, fname, lname, country, address, bio) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $insert_userinfo)) {
            mysqli_stmt_bind_param($stmt, "isssss", $login_id, $fname, $lname, $country, $address, $bio);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            throw new Exception("Database error: Unable to prepare statement for userinfo.");
        }

        // Commit transaction
        mysqli_commit($conn);

        // Registration successful
        $_SESSION['success'] = "Registration successful. Please log in.";
        header("Location: /ReviewMate/auth/page/login.php");
        exit();
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($conn);

        // Log error message (for debugging purposes)
        error_log($e->getMessage());

        $_SESSION['error'] = "An error occurred during registration. Please try again.";
        header("Location: /ReviewMate/auth/page/register.php");
        exit();
    }
} else {
    // If not a POST request, redirect to registration page
    header("Location: /ReviewMate/auth/page/register.php");
    exit();
}
?>