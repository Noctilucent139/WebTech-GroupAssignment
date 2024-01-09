
<?php
session_start();

// Check if the username is set in the session
if (isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
} else {
    // Redirect to login page or handle as needed
    header("Location: auth_login.php");
    exit();
}

include("config.php");

// Check if the form is submitted for adding a new user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data
    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
    $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['password']);
    $newUserState = mysqli_real_escape_string($conn, $_POST['user_state']);

    // Check if the username already exists
    $checkUsernameSql = "SELECT COUNT(*) FROM user_information WHERE username = '$newUsername'";
    $result = mysqli_query($conn, $checkUsernameSql);
    $row = mysqli_fetch_row($result);
    $usernameExists = $row[0];

    if ($usernameExists > 0) {
        // Username already exists, show error message
        $errorMessage = "Username '$newUsername' already exists. Please choose a different username.";
    } else {
        // Insert new user into the database
        $insertSql = "INSERT INTO user_information (username, email, password, user_state)
                      VALUES ('$newUsername', '$newEmail', '$newPassword', '$newUserState')";

        if (mysqli_query($conn, $insertSql)) {
            // User added successfully
            header("Location: admin_manage_users.php");
            exit();
        } else {
            // Error adding new user
            $errorMessage = "Error adding new user: " . mysqli_error($conn);
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
    <title>Add User</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_admin.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>Add User</h1>
        <p>Enter the details to add a new user.</p>
    </header>

    <!-- Main Content Section -->
    <main>
        <section id="Section">
            <h2>Add User</h2>
            <div class="form-container">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <table id="table">
                        <tr>
                            <td><label for="username">Username:</label></td>
                            <td><input type="text" id="username" name="username" required></td>
                        </tr>
                        <tr>
                            <td><label for="email">Email:</label></td>
                            <td><input type="email" id="email" name="email" required></td>
                        </tr>
                        <tr>
                            <td><label for="password">Password:</label></td>
                            <td><input type="password" id="password" name="password" required></td>
                        </tr>
                        <tr>
                            <td><label for="user_state">User State:</label></td>
                            <td>
                                <select id="user_state" name="user_state" required>
                                    <option value="0">Normal User</option>
                                    <option value="1">Admin User</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><input type="submit" value="Add User"></td>
                        </tr>
                    </table>

                    <!-- Go Back Button -->
                    <a href="admin_manage_users.php" class="back-button">Go Back</a>

                </form>
            </div>
        </section>
    </main>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
