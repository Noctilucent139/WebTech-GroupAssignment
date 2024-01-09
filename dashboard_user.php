
<?php
include("config.php");

// Check if the user is logged in
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: auth_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_user.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>Welcome to Your Dashboard</h1>
        <p>Explore and enjoy the resources available in the online library.</p>
    </header>

    <!-- Main Content Section -->
    <main>
        <section id="userSection">
            <!-- User-specific content -->
            <p>Welcome to your User Dashboard. Here, you can access various features:</p>

            <!-- User Navigation Links -->
            <div class="user-links">
                <a href="book_index.php">
                    <img src="assets/book_icon.png" alt="Book Icon">
                    <p>Book Index: Explore the collection and find your next read.</p>
                </a>
                <a href="user_profile.php">
                    <img src="assets/profile_icon.png" alt="Profile Icon">
                    <p>User Profile: View and manage your profile information.</p>
                </a>
                <a href="user_return_books.php">
                    <img src="assets/return_books_icon.png" alt="Return Books Icon">
                    <p>Return Books: Manage the books you're returning.</p>
                </a>
            </div>

            <p>Make the most of your reading experience!</p>
        </section>
    </main>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
