
<?php
session_start();
include("config.php");

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch borrowed books for the logged-in user
$sql = "SELECT id, book_name, date FROM book_information WHERE username = '$username' AND book_state = 1";
$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Return Books</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_user.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>User Return Books</h1>
        <p>View and manage your borrowed books.</p>
    </header>

    <!-- Borrowed Books Section -->
    <table id="table">
        <tr>
            <th>ID</th>
            <th>Book Name</th>
            <th>Date Borrowed</th>
            <th>Action</th>
        </tr>

        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["book_name"] . "</td>";
                echo "<td>" . $row["date"] . "</td>";
                echo '<td>';

                // Extend burrow duration, not yet implemented
                // echo '<button onclick="extendBorrow(' . $row["id"] . ')">Extend Borrow</button>';
                // echo ' | ';
                echo '<button onclick="returnBook(' . $row["id"] . ')">Return Book</button>';
                echo '</td>';
                echo "</tr>" . "\n\t\t";
            }
        } else {
            echo '<tr><td colspan="4">No borrowed books.</td></tr>';
        }
        ?>
        
    </table>

    <!-- JavaScript for Extend Borrow and Return Book -->
    <script>
        function extendBorrow(bookId) {
            // Perform an asynchronous request to extend the borrow
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Display the result of extending the borrow
                    alert(this.responseText);
                    // Reload the page to update the book list
                    location.reload();
                }
            };
            xhttp.open("POST", "user_return_books_process.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("action=extendBorrow&bookId=" + bookId);
        }

        function returnBook(bookId) {
            // Perform an asynchronous request to return the book
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Display the result of returning the book
                    alert(this.responseText);
                    // Reload the page to update the book list
                    location.reload();
                }
            };
            xhttp.open("POST", "user_return_books_process.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("action=returnBook&bookId=" + bookId);
        }
    </script>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
