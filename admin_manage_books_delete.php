
<?php
session_start();

include("config.php");

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: auth_login.php");
    exit();
}

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Sanitize the input to prevent SQL injection
    $activityId = mysqli_real_escape_string($conn, $_GET['id']);

    // Delete the activity from the database
    $deleteQuery = "DELETE FROM book_information WHERE id = '$activityId'";
    $result = mysqli_query($conn, $deleteQuery);

    if ($result) {
        // Redirect 
        header("Location: admin_manage_bookss.php");
        exit();
    } else {
        // Handle the error (e.g., display an error message)
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // If 'id' parameter is not set, redirect
    header("Location: admin_manage_books.php");
    exit();
}

mysqli_close($conn);
?>
