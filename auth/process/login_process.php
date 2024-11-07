<?php
session_start();
include "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize inputs
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, email, password FROM userlogin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Store user info in session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];

            // Redirect to the profile page with the user ID as a URL parameter
            header("Location: profile.php?user_id=" . $row['id']);
            exit();
        } else {
            // Incorrect password
            echo "<script>alert('Invalid password.');window.location.href='login.php';</script>";
        }
    } else {
        // No user found with this email
        echo "<script>alert('No account found with this email.');window.location.href='login.php';</script>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
