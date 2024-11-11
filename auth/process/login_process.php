<?php
session_start();
include "../../includes/db_connect.php"; 
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, email, password_hash FROM userlogin WHERE email = ?");
    if ($stmt === false) {
        die("Error preparing the query: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['username'] = $row['username'];

            header("Location: /ReviewMate/user/profile.php?user_id=" . $row['id']);
            exit();
        } else {
            echo "<script>alert('Invalid password.');window.location.href='../auth/page/login.php';</script>";
        }
    } else {
        echo "<script>alert('No account found with this email.');window.location.href='../auth/page/login.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
