
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
    <title>Manage Books</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_admin.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>Manage Books</h1>
        <p>Explore and manage the books available in the online library.</p>
    </header>

    <!-- Main Content Section -->
    <table id="table">
        <tr>
            <th>No</th>
            <th>Book Name</th>
            <th>Book Page</th>
            <th>Book Detail</th>
            <th>Book State</th>
            <th>Username</th>
            <th>Action</th>
        </tr>

        <?php
        // Display book table data
        $sql = "SELECT * FROM book_information";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $numrow = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $numrow . "</td><td>" . $row["book_name"] . "</td><td>" . $row["book_page"] . "</td>";
                echo "<td>" . $row["book_detail"] . "</td><td>" . $row["book_state"] . "</td><td>" . $row["username"] . "</td>";
                echo '<td> <a href="admin_manage_books_edit.php?id=' . $row["id"] . '">Edit</a>&nbsp;|&nbsp;';
                echo '<a href="admin_manage_books_delete.php?id=' . $row["id"] .'" onClick="return confirm(\'Delete?\');">Delete</a> </td>';
                echo "</tr>" . "\n\t\t";
                $numrow++;
            }

        } else {
            echo '<tr><td colspan="7">0 results</td></tr>';
        }

        mysqli_close($conn);
        ?>
        
    </table>

    <!-- Add Book Button -->
    <a href="admin_manage_books_add.php" class="add-button">Add Book</a>

    <!-- Style this later idk -->
    <p>IMPORTANT!! For Book State, 0 means it is in the library, 1 means someone borrow then and 2 means it pending borrow.</p>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
