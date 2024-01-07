
<?php
include("config.php");

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input values from the registration form
    $fullname = sanitize($_POST['fullname']);
    $email = sanitize($_POST['email']);
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo '<script>alert("Passwords do not match"); window.location.href = "auth_register.php";</script>';
        exit();
    }

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Query to insert user data into the database
    $insertUserQuery = "INSERT INTO user_information (fullname, email, username, password, user_state) VALUES ('$fullname', '$email', '$username', '$hashedPassword', 0)";

    if (mysqli_query($conn, $insertUserQuery)) {
        // Registration successful, redirect to user dashboard
        header("Location: dashboard_user.php");
        exit();
    } else {
        // Handle registration error, show message or redirect as needed
        echo "Error: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>
