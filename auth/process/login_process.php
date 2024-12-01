<?php
session_start();
include "../../includes/db_connect.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, email, password_hash FROM userlogin WHERE email = ?");
    if ($stmt === false) {
        http_response_code(500);
        echo json_encode(["error" => "Error preparing the query."]);
        exit();
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

            echo json_encode(["success" => "Login successful.", "redirect" => "/user/profile.php?user_id=" . $row['id']]);
        } else {
            http_response_code(401);
            echo json_encode(["error" => "Invalid password."]);
        }
    } else {
        http_response_code(404);
        echo json_encode(["error" => "No account found with this email."]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request method."]);
}
?>
