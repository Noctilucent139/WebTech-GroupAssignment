
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

// Fetch the number of books borrowed
$bookQuery = "SELECT COUNT(*) as num_books FROM book_information WHERE username = '$username' AND book_state = 1";
$bookResult = mysqli_query($conn, $bookQuery);
$numBooks = 0;

if ($bookResult && mysqli_num_rows($bookResult) > 0) {
    $rowBooks = mysqli_fetch_assoc($bookResult);
    $numBooks = $rowBooks['num_books'];
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_user.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>User Profile</h1>
        <p>View and edit your profile details.</p>
    </header>

    <!-- User Profile Section -->
    <table id="table">
        <tr>
            <!-- Profile Picture Cell. Improve later -->
            <th>Profile Picture</th>
            <th>Username</th>
            <th>Fullname</th>
            <th>Email</th>
            <th>Password</th>
            <th>Books Borrowed</th>
        </tr>

        <?php
        if ($userResult && mysqli_num_rows($userResult) > 0) {
            $rowUser = mysqli_fetch_assoc($userResult);
            echo "<tr>";
            echo "<td class='profile-picture'>";
            echo "<img src='assets/profile_picture_placeholder.jpg' alt='Profile Picture'>";
            echo "</td>";
            echo "<td>" . $rowUser["username"] . "</td>";
            echo "<td>" . $rowUser["fullname"] . "</td>";
            echo "<td>" . $rowUser["email"] . "</td>";
            echo "<td>" . $rowUser["password"] . "</td>";
            echo "<td>" . $numBooks . "</td>";
            echo "</tr>";
        } else {
            echo '<tr><td colspan="6">User not found.</td></tr>';
        }
        ?>
        
    </table>

    <!-- Edit Profile Button -->
    <button onclick="editProfile()" class="add-button">Edit Profile</button>

    <!-- JavaScript for Edit Profile -->
    <script>
        function editProfile() {
            // Redirect to user_profile_edit.php
            window.location.href = "user_profile_edit.php";
        }
    </script>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
