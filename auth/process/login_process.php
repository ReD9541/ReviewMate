<?php
session_start();
include "../../includes/db_connect.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if $conn is defined
    if (!isset($conn)) {
        die("Database connection failed.");
    }

    // Retrieve and sanitize inputs
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, email, password_hash FROM userlogin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password with the correct field
        if (password_verify($password, $row['password_hash'])) {
            // Store user info in session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];

            // Redirect to the profile page with the user ID as a URL parameter
            header("Location: /reviewmate/user/profile.php?user_id=" . $row['id']);
            exit();
        } else {
            // Incorrect password
            echo "<script>alert('Invalid password.');window.location.href='/reviewmate/auth/page/login.php';</script>";
        }
    } else {
        // No user found with this email
        echo "<script>alert('No account found with this email.');window.location.href='/reviewmate/auth/page/login.php';</script>";    }    

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
