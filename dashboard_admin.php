
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
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_admin.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>Welcome to the Admin Dashboard</h1>
        <p>Manage and oversee the online library resources.</p>
    </header>

    <!-- Main Content Section -->
    <main>
        <section id="adminSection">
            <!-- Admin-specific content -->
            <p>Welcome to the Admin Dashboard. As an admin, you have the following capabilities:</p>

            <!-- Admin Navigation Links -->
            <div class="admin-links">
                <a href="admin_manage_users.php">
                    <img src="../assets/user_icon.png" alt="User Icon">
                    <p>Manage Users: View, edit, and manage user accounts.</p>
                </a>
                <a href="admin_manage_books.php">
                    <img src="../assets/book_icon.png" alt="Book Icon">
                    <p>Manage Books: Add, edit, and remove books from the library.</p>
                </a>
            </div>

            <p>Explore the links above to perform administrative tasks and ensure the smooth operation of the online library.</p>
        </section>
    </main>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
