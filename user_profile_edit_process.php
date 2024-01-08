
<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
    $newFullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['password']);

    // Update user information in the database
    $updateQuery = "UPDATE user_information SET username='$newUsername', fullname='$newFullname', email='$newEmail', password='$newPassword' WHERE username='{$_SESSION['username']}'";

    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        // Update successful
        $_SESSION['username'] = $newUsername; // Update session username if it was changed
        header("Location: user_profile.php"); // Redirect to the user profile page
        exit();
    } else {
        // Update failed
        echo "Error updating user information: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    // Redirect if the form is not submitted using POST
    header("Location: user_profile_edit.php");
    exit();
}
?>
