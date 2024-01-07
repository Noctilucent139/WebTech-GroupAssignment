
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

// Check if the form is submitted for adding a new book
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data
    $newBookName = mysqli_real_escape_string($conn, $_POST['book_name']);
    $newBookPage = mysqli_real_escape_string($conn, $_POST['book_page']);
    $newBookDetail = mysqli_real_escape_string($conn, $_POST['book_detail']);
    $newBookState = mysqli_real_escape_string($conn, $_POST['book_state']);
    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);

    // Check if the Book State is "Borrowed"
    if ($newBookState == 1) {
        // Validate and insert new book into the database
        $insertSql = "INSERT INTO book_information (book_name, book_page, book_detail, book_state, username)
                      VALUES ('$newBookName', '$newBookPage', '$newBookDetail', '$newBookState', '$newUsername')";

        if (mysqli_query($conn, $insertSql)) {
            // Book added successfully
            header("Location: admin_manage_books.php");
            exit();
        } else {
            // Error adding new book
            $errorMessage = "Error adding new book: " . mysqli_error($conn);
        }
    } else {
        // Validate and insert new book into the database without username
        $insertSql = "INSERT INTO book_information (book_name, book_page, book_detail, book_state)
                      VALUES ('$newBookName', '$newBookPage', '$newBookDetail', '$newBookState')";

        if (mysqli_query($conn, $insertSql)) {
            // Book added successfully
            header("Location: admin_manage_books.php");
            exit();
        } else {
            // Error adding new book
            $errorMessage = "Error adding new book: " . mysqli_error($conn);
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
    <title>Add Book</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_admin.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>Add Book</h1>
        <p>Enter the details to add a new book.</p>
    </header>

    <!-- Main Content Section -->
    <main>
        <section id="Section">
            <h2>Add Book</h2>
            <div class="form-container">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <table id="table">
                        <tr>
                            <td><label for="book_name">Book Name:</label></td>
                            <td><input type="text" id="book_name" name="book_name" required></td>
                        </tr>
                        <tr>
                            <td><label for="book_page">Book Page:</label></td>
                            <td><input type="text" id="book_page" name="book_page" required></td>
                        </tr>
                        <tr>
                            <td><label for="book_detail">Book Detail:</label></td>
                            <td><textarea id="text" name="book_detail" required></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="book_state">Book State:</label></td>
                            <td>
                                <select id="book_state" name="book_state" required>
                                    <option value="0">In the library</option>
                                    <option value="1">Borrowed</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="usernameRow" style="display:none;">
                            <td><label for="username">Username:</label></td>
                            <td><input type="text" id="username" name="username"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" value="Add Book"></td>
                        </tr>
                    </table>

                    <!-- Go Back Button -->
                    <a href="admin_manage_books.php" class="back-button">Go Back</a>

                </form>
            </div>
        </section>
    </main>

    <script>
        // Function to toggle the visibility of the username input based on the selected book state
        document.getElementById('book_state').addEventListener('change', function () {
            var usernameRow = document.getElementById('usernameRow');
            usernameRow.style.display = this.value == 1 ? 'table-row' : 'none';
        });
    </script>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
