
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
    $userId = mysqli_real_escape_string($conn, $_GET['id']);

    // Check the user state of the user to be deleted
    $checkUserStateSql = "SELECT user_state FROM user_information WHERE id = '$userId'";
    $checkUserStateResult = mysqli_query($conn, $checkUserStateSql);

    if ($checkUserStateResult) {
        $userStateRow = mysqli_fetch_assoc($checkUserStateResult);
        $userStateToDelete = $userStateRow['user_state'];

        // Check the total number of users with user_state 1 (admin)
        $countAdminSql = "SELECT COUNT(*) FROM user_information WHERE user_state = '1'";
        $countAdminResult = mysqli_query($conn, $countAdminSql);

        if ($countAdminResult) {
            $adminCountRow = mysqli_fetch_row($countAdminResult);
            $totalAdmins = $adminCountRow[0];

            // Prevent deletion if the user to be deleted is the last admin
            if ($userStateToDelete == 1 && $totalAdmins == 1) {
                echo "Unable to delete the last admin";
                exit();
            }

            // Delete the user from the database
            $deleteQuery = "DELETE FROM user_information WHERE id = '$userId'";
            $result = mysqli_query($conn, $deleteQuery);

            if ($result) {
                // Redirect 
                header("Location: admin_manage_users.php");
                exit();
            } else {
                // Handle the error (e.g., display an error message)
                echo "Error deleting record: " . mysqli_error($conn);
            }
        } else {
            echo "Error counting admins: " . mysqli_error($conn);
        }
    } else {
        echo "Error checking user state: " . mysqli_error($conn);
    }
} else {
    // If 'id' parameter is not set, redirect
    header("Location: admin_manage_users.php");
    exit();
}

mysqli_close($conn);
?>
