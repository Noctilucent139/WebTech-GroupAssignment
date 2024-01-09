
<?php
include("config.php");

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input values from the form
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    /*  
        Changed the logic so the password would not be hashed for easier demonstration. 
        Comment the other half and use this one if not working.
        Will be implemented in the future if got time.
        

    // Prepare a statement for checking the username ()
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

    */

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
