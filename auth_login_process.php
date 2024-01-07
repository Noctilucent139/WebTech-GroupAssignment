
<?php
include("config.php");

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input values from the form
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    // Query to check if the username exists
    $checkUsernameQuery = "SELECT * FROM user_information WHERE username = '$username'";
    $result = mysqli_query($conn, $checkUsernameQuery);

    if ($result) {
        // Check if a row with the given username exists
        if (mysqli_num_rows($result) > 0) {
            // Fetch the user's data
            $row = mysqli_fetch_assoc($result);
            
            // Check if the entered password matches the stored password
            if ($password === $row['password']) {

                session_start();
                $_SESSION['username'] = $username;

                // Check user_state and redirect accordingly
                if ($row['user_state'] == 0) {
                    // Redirect to user dashboard
                    header("Location: dashboard_user.php");
                } elseif ($row['user_state'] == 1) {
                    // Redirect to admin dashboard
                    header("Location: dashboard_admin.php");
                } else {
                    // Invalid user_state, handle as needed
                    echo '<script>alert("Invalid User State"); window.location.href = "auth_login.php";</script>';
                }

                exit();
            } else {
                // Invalid password, show popup and return to the same page
                echo '<script>alert("Incorrect Password"); window.location.href = "auth_login.php";</script>';
            }
        } else {
            // Invalid username, show popup and return to the same page
            echo '<script>alert("Invalid User"); window.location.href = "auth_login.php";</script>';
        }
    } else {
        // Database query error, handle as needed
        echo "Error: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>
