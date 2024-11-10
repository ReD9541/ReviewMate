<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once '../../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = $_POST['password']; 
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $fname = trim(mysqli_real_escape_string($conn, $_POST['fname']));
    $lname = trim(mysqli_real_escape_string($conn, $_POST['lname']));
    $country = isset($_POST['country']) ? trim(mysqli_real_escape_string($conn, $_POST['country'])) : null;
    $address = isset($_POST['address']) ? trim(mysqli_real_escape_string($conn, $_POST['address'])) : null;
    $bio = isset($_POST['bio']) ? trim(mysqli_real_escape_string($conn, $_POST['bio'])) : null;

    if (empty($username) || empty($email) || empty($password) || empty($fname) || empty($lname)) {
        $_SESSION['error'] = "Please fill in all required fields.";
        header("Location: /ReviewMate/auth/page/register.php");
        exit();
    }

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

    mysqli_begin_transaction($conn);

    try {
        $insert_userlogin = "INSERT INTO userlogin (username, password_hash, email) VALUES (?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $insert_userlogin)) {
            mysqli_stmt_bind_param($stmt, "sss", $username, $password_hash, $email);
            mysqli_stmt_execute($stmt);
            $login_id = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt);
        } else {
            throw new Exception("Database error: Unable to prepare statement for userlogin.");
        }

        $insert_userinfo = "INSERT INTO userinfo (login_id, fname, lname, country, address, bio) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $insert_userinfo)) {
            mysqli_stmt_bind_param($stmt, "isssss", $login_id, $fname, $lname, $country, $address, $bio);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            throw new Exception("Database error: Unable to prepare statement for userinfo.");
        }

        mysqli_commit($conn);

        $_SESSION['success'] = "Registration successful. Please log in.";
        header("Location: /ReviewMate/auth/page/login.php");
        exit();
    } catch (Exception $e) {
        mysqli_rollback($conn);
        error_log($e->getMessage());

        $_SESSION['error'] = "An error occurred during registration. Please try again.";
        header("Location: /ReviewMate/auth/page/register.php");
        exit();
    }
} else {
    header("Location: /ReviewMate/auth/page/register.php");
    exit();
}
