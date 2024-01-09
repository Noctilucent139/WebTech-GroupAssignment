
<?php
include("config.php");

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/*  Use the other one if not working. 
    Run into a problem when hashing the password.
    Changed to not use hashed password.
    Will be implemented in the future if got time.

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

    // Close database connection
    mysqli_close($conn);
}

*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input values from the registration form
    $fullname = sanitize($_POST['fullname']);
    $email = sanitize($_POST['email']);
    $username = sanitize($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo '<script>alert("Passwords do not match"); window.location.href = "auth_register.php";</script>';
        exit();
    }

    // Hash the password before storing it
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Query to insert user data into the database (change the $password to $hashedPassword for safely implementation)
    $insertUserQuery = "INSERT INTO user_information (fullname, email, username, password, user_state) VALUES ('$fullname', '$email', '$username', '$password', 0)";

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
