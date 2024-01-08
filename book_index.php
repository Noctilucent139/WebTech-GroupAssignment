
<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['checkAvailability'])) {
        $bookId = $_POST['bookId'];

        // Check availability before borrowing
        $availabilityCheck = "SELECT book_state FROM book_information WHERE id = $bookId";
        $resultCheck = mysqli_query($conn, $availabilityCheck);

        if ($resultCheck && mysqli_num_rows($resultCheck) > 0) {
            $rowCheck = mysqli_fetch_assoc($resultCheck);

            if ($rowCheck['book_state'] == 0) {
                // Book is available
                echo "Book is available for borrowing.";
            } else {
                // Book is not available
                echo "The book is not available for borrowing.";
            }
        } else {
            // Error in checking availability
            echo "Error checking the availability of the book.";
        }

        mysqli_close($conn);
    }

    if (isset($_POST['borrowBook'])) {
        $bookId = $_POST['bookId'];
        $username = $_SESSION['username'];

        // Check availability before borrowing
        $availabilityCheck = "SELECT book_state FROM book_information WHERE id = $bookId";
        $resultCheck = mysqli_query($conn, $availabilityCheck);

        if ($resultCheck && mysqli_num_rows($resultCheck) > 0) {
            $rowCheck = mysqli_fetch_assoc($resultCheck);

            if ($rowCheck['book_state'] == 0) {
                // Book is available, proceed to borrow
                $borrowQuery = "UPDATE book_information SET book_state = 1, username = '$username', date = NOW() WHERE id = $bookId";
                $resultBorrow = mysqli_query($conn, $borrowQuery);

                if ($resultBorrow) {
                    // Successful borrow
                    echo "Book Borrowed successfully!";
                } else {
                    // Error in borrowing
                    echo "Error borrowing the book. Please try again.";
                }
            } else {
                // Book is not available
                echo "The book is not available for borrowing.";
            }
        } else {
            // Error in checking availability
            echo "Error checking the availability of the book.";
        }

        mysqli_close($conn);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Index</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_user.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>Book Index</h1>
        <p>Explore the list of books available in the online library.</p>
    </header>

    <!-- Main Content Section -->
    <table id="table">
        <tr>
            <th>ID</th>
            <th>Book Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>

        <?php
        // Display book table data
        $sql = "SELECT id, book_name, book_detail, book_state FROM book_information";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td><a href='book_details.php?id=" . $row["id"] . "'>" . $row["book_name"] . "</a></td>";
                echo "<td>" . $row["book_detail"] . "</td>";
                echo '<td>';
                echo '<button onclick="checkAvailability(' . $row["id"] . ')">Check Availability</button>';
                echo ' | ';
                echo '<button onclick="borrowBook(' . $row["id"] . ')">Borrow</button>';
                echo '</td>';
                echo "</tr>" . "\n\t\t";
            }
        } else {
            echo '<tr><td colspan="4">0 results</td></tr>';
        }

        mysqli_close($conn);
        ?>
        
    </table>

    <!-- JavaScript for Popup and Borrowing -->
    <script>
        function checkAvailability(bookId) {
            // Perform an asynchronous request to check the availability
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Display the availability status
                    alert(this.responseText);
                }
            };
            xhttp.open("POST", "book_index.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("checkAvailability=true&bookId=" + bookId);
        }

        function borrowBook(bookId) {
            // Perform an asynchronous request to borrow the book
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Display the result of borrowing
                    alert(this.responseText);
                }
            };
            xhttp.open("POST", "book_index.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("borrowBook=true&bookId=" + bookId);
        }
    </script>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
