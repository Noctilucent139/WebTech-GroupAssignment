<?php
include("config.php");

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = sanitize($_POST['fullname']);
    $email = sanitize($_POST['email']);
    $username = sanitize($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($password !== $confirm_password) {
        echo '<script>alert("Passwords do not match"); window.location.href = "auth_register.php";</script>';
        exit();
    }

    if (!isValidEmail($email)) {
        echo '<script>alert("Invalid email format"); window.location.href = "auth_register.php";</script>';
        exit();
    }


    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($stmt = $conn->prepare("INSERT INTO user_information (fullname, email, username, password, user_state) VALUES (?, ?, ?, ?, 0)")) {
        $stmt->bind_param("ssss", $fullname, $email, $username, $hashedPassword);
        if ($stmt->execute()) {
            header("Location: dashboard_user.php");
            exit();
        } else {
            echo '<script>alert("An error occurred. Please try again later."); window.location.href = "auth_register.php";</script>';
        }
        $stmt->close();
    } else {

    }

    $mysqli_close($conn);
}
?>
