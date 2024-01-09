
<?php
session_start();

include("config.php");

// Check if the username is set in the session
if (isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
} else {
    // Redirect to login page or handle as needed
    header("Location: auth_login.php");
    exit();
}

// Check if user ID is provided in the URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Fetch user information for the provided ID
    $sql = "SELECT * FROM user_information WHERE id = $userId";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Check if the user to be modified is the last admin
        if ($row['user_state'] == 1) {
            // Check the total number of users with user_state 1 (admin)
            $countAdminSql = "SELECT COUNT(*) FROM user_information WHERE user_state = '1'";
            $countAdminResult = mysqli_query($conn, $countAdminSql);

            if ($countAdminResult) {
                $adminCountRow = mysqli_fetch_row($countAdminResult);
                $totalAdmins = $adminCountRow[0];

                // Prevent modifying the last admin's user state
                if ($totalAdmins == 1) {
                    echo "Unable to modify the last admin! Create another admin first!";
                    exit();
                }
            } else {
                echo "Error counting admins: " . mysqli_error($conn);
                exit();
            }
        }
    } else {
        // No user found with the provided ID, redirect or handle as needed
        header("Location: admin_manage_users.php");
        exit();
    }
} else {
    // No user ID provided in the URL, redirect or handle as needed
    header("Location: admin_manage_users.php");
    exit();
}

// Check if the form is submitted for updating user information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data
    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
    $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['password']);
    $newUserState = mysqli_real_escape_string($conn, $_POST['user_state']);

    // Check for duplicate username excluding the current user being updated
    $checkDuplicateSql = "SELECT COUNT(*) FROM user_information WHERE username = '$newUsername' AND id != $userId";
    $result = mysqli_query($conn, $checkDuplicateSql);
    $row = mysqli_fetch_row($result);
    $usernameExists = $row[0];

    if ($usernameExists > 0) {
        // Duplicate username detected, show error message
        $errorMessage = "Username '$newUsername' already exists. Please choose a different username.";
    } else {
        // Update user information in the database
        $updateSql = "UPDATE user_information 
                      SET username = '$newUsername', email = '$newEmail', password = '$newPassword', user_state = '$newUserState' 
                      WHERE id = $userId";

        if (mysqli_query($conn, $updateSql)) {
            // User information updated successfully
            header("Location: admin_manage_users.php");
            exit();
        } else {
            // Error updating user information
            $errorMessage = "Error updating user information: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Information</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_admin.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>Edit User Information</h1>
        <p>Modify user details as needed.</p>
    </header>

    <!-- Main Content Section -->
    <main>
        <section id="Section">
            <h2>Edit User</h2>
            <form method="post" action="">
                <table id="table">
                    <tr>
                        <td>Username:</td>
                        <td><input type="text" name="username" value="<?php echo $row['username']; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="email" value="<?php echo $row['email']; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input type="password" name="password" value="<?php echo $row['password']; ?>" required></td>
                    </tr>
                    <tr>
                        <td>User State:</td>
                        <td>
                            <select name="user_state" required>
                                <option value="0" <?php echo ($row['user_state'] == '0') ? 'selected' : ''; ?>>Normal User</option>
                                <option value="1" <?php echo ($row['user_state'] == '1') ? 'selected' : ''; ?>>Admin User</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="center-align-button"><input type="submit" value="Update User"></td>
                    </tr>
                </table>
            </form>

            <a href="admin_manage_users.php" class="back-button">Go Back</a>
        </section>
    </main>

    <?php
    if (isset($errorMessage)) {
        echo "<p class='error-message'>$errorMessage</p>";
    }
    ?>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
