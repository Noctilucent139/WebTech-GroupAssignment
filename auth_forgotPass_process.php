
<?php
include("config.php");
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input values from the form
    $email = sanitize($_POST['email']);

    // Query to check if the email exists
    $checkEmailQuery = "SELECT * FROM user_information WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmailQuery);

    if (!$result) {
        // Print SQL query error
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    // Check if a row with the given email exists
    if (mysqli_num_rows($result) > 0) {
        // Email exists in the database
        $row = mysqli_fetch_assoc($result);

        // Update password to "password"
        $updatePasswordQuery = "UPDATE user_information SET password = 'password' WHERE email = '$email'";
        $updateResult = mysqli_query($conn, $updatePasswordQuery);

        if (!$updateResult) {
            // Print update query error
            echo "Error updating password: " . mysqli_error($conn);
            exit();
        }

        echo "Password updated successfully! New Password : password";
    } else {
        // Email not found in the database
        echo "Email not found in our records.";
    }

    mysqli_close($conn);
}
?>
