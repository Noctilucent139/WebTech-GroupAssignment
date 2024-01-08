<?php
include("config.php");

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']); // Note: Sanitization is okay for now, but consider removing it for password

    // Prepare a statement for checking the username
    $stmt = $conn->prepare("SELECT * FROM user_information WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        // Check if a row with the given username exists
        if ($row = $result->fetch_assoc()) {
            // Verify the entered password against the hashed password
            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['username'] = $username;

                // Check user_state and redirect accordingly
                if ($row['user_state'] == 0) {
                    header("Location: dashboard_user.php");
                } elseif ($row['user_state'] == 1) {
                    header("Location: dashboard_admin.php");
                } else {
                    echo '<script>alert("Invalid User State"); window.location.href = "auth_login.php";</script>';
                }
            } else {
                echo '<script>alert("Incorrect Password"); window.location.href = "auth_login.php";</script>';
            }
        } else {
            echo '<script>alert("Invalid User"); window.location.href = "auth_login.php";</script>';
        }
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
