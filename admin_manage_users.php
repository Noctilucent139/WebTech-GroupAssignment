
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_admin.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>Manage Users</h1>
        <p>Explore and manage user accounts in the online library.</p>
    </header>

    <!-- Main Content Section -->
    <table id="table">
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Email</th>
            <th>Password</th>
            <th>User State</th>
            <th>Books in Possession</th>
            <th>Action</th>
        </tr>

        <?php
        // Display user table data with Books in Possession count
        $sql = "SELECT u.*, COUNT(b.id) AS booksInPossession 
                FROM user_information u 
                LEFT JOIN book_information b ON u.username = b.username
                GROUP BY u.id";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $numrow = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $numrow . "</td><td>" . $row["username"] . "</td><td>" . $row["email"] . "</td><td>" . $row["password"] . "</td>";
                echo "<td>" . $row["user_state"] . "</td><td>" . $row["booksInPossession"] . "</td>";
                echo '<td> <a href="admin_manage_users_edit.php?id=' . $row["id"] . '">Edit</a>&nbsp;|&nbsp;';
                echo '<a href="admin_manage_users_delete.php?id=' . $row["id"] .'" onClick="return confirm(\'Delete?\');">Delete</a> </td>';
                echo "</tr>" . "\n\t\t";
                $numrow++;
            }

        } else {
            echo '<tr><td colspan="7">0 results</td></tr>';
        }

        mysqli_close($conn);
        ?>
        
    </table>

    <!-- Add User Button -->
    <a href="admin_manage_users_add.php" class="add-button">Add User</a>

    <!-- Style this later idk -->
    <section id="userSection">
        <p>User State 1 designates an administrative account with elevated privileges.</p>
        <p>User State 0 represents a standard user account with regular privileges.</p>
    </section>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
