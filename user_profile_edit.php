
<?php
    session_start();
    include("config.php");

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    $username = $_SESSION['username'];

    // Fetch user details from user_information table
    $userQuery = "SELECT username, fullname, email, password FROM user_information WHERE username = '$username'";
    $userResult = mysqli_query($conn, $userQuery);

    // Check if the query was successful
    if (!$userResult) {
        die("Error fetching user details: " . mysqli_error($conn));
    }

    // Fetch the user details as an associative array
    $rowUser = mysqli_fetch_assoc($userResult);

    // Close the database connection
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_user.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>Edit Profile</h1>
        <p>Edit your profile details.</p>
    </header>

    <!-- Edit Profile Section -->
    <main>
        <section id="Section">
            <h2>Edit Profile</h2>
            <div class="form-container">
                <form action="user_profile_edit_process.php" method="post">
                    <table id="table">
                        <tr>
                            <td><label for="username">Username:</label></td>
                            <td><input type="text" id="username" name="username" value="<?php echo $rowUser['username']; ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="fullname">Fullname:</label></td>
                            <td><input type="text" id="fullname" name="fullname" value="<?php echo $rowUser['fullname']; ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="email">Email:</label></td>
                            <td><input type="email" id="email" name="email" value="<?php echo $rowUser['email']; ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="password">Password:</label></td>
                            <td><input type="password" id="password" name="password" value="<?php echo $rowUser['password']; ?>" required></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="center-align-button"><input type="submit" value="Save Changes"></td>
                        </tr>
                    </table>

                    <!-- Go Back Button -->
                    <a href="user_profile.php" class="back-button">Go Back</a>
                </form>
            </div>
        </section>
    </main>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
