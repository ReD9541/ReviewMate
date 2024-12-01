<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once '../../includes/db_connect.php';

header('Content-Type: application/json');

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
        http_response_code(400);
        echo json_encode(["error" => "Please fill in all required fields."]);
        exit();
    }

    $check_query = "SELECT * FROM userlogin WHERE username = ? OR email = ?";
    if ($stmt = mysqli_prepare($conn, $check_query)) {
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_close($stmt);
            http_response_code(409);
            echo json_encode(["error" => "Username or email already exists."]);
            exit();
        }
        mysqli_stmt_close($stmt);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Database error: Unable to prepare statement."]);
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
            throw new Exception("Unable to prepare statement for userlogin.");
        }

        $insert_userinfo = "INSERT INTO userinfo (login_id, fname, lname, country, address, bio) VALUES (?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($conn, $insert_userinfo)) {
            mysqli_stmt_bind_param($stmt, "isssss", $login_id, $fname, $lname, $country, $address, $bio);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            throw new Exception("Unable to prepare statement for userinfo.");
        }

        mysqli_commit($conn);

        echo json_encode(["success" => "Registration successful. Please log in."]);
        exit();
    } catch (Exception $e) {
        mysqli_rollback($conn);
        error_log($e->getMessage());

        http_response_code(500);
        echo json_encode(["error" => "An error occurred during registration. Please try again."]);
        exit();
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Invalid request method."]);
}
?>
