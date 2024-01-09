
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

// Check if 'id' parameter is set in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $bookId = mysqli_real_escape_string($conn, $_GET['id']);

    // Retrieve book details from the database
    $sql = "SELECT * FROM book_information WHERE id = '$bookId'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $bookName = $row['book_name'];
        $bookPage = $row['book_page'];
        $bookDetail = $row['book_detail'];
        $bookState = $row['book_state'];
        $username = $row['username'];
    } else {
        // Book not found, redirect to the book management page
        header("Location: admin_manage_books.php");
        exit();
    }
} else {
    // 'id' parameter not set, redirect to the book management page
    header("Location: admin_manage_books.php");
    exit();
}

// Check if the form is submitted for updating book information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data
    $newBookName = mysqli_real_escape_string($conn, $_POST['book_name']);
    $newBookPage = mysqli_real_escape_string($conn, $_POST['book_page']);
    $newBookDetail = mysqli_real_escape_string($conn, $_POST['book_detail']);
    $newBookState = mysqli_real_escape_string($conn, $_POST['book_state']);
    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);

    // Update book information in the database
    $updateSql = "UPDATE book_information 
                  SET book_name = '$newBookName', book_page = '$newBookPage', book_detail = '$newBookDetail', 
                      book_state = '$newBookState', username = '$newUsername' 
                  WHERE id = $bookId";

    if (mysqli_query($conn, $updateSql)) {
        // Book information updated successfully
        header("Location: admin_manage_books.php");
        exit();
    } else {
        // Error updating book information
        $errorMessage = "Error updating book information: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_admin.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>Edit Book</h1>
        <p>Modify the details of the selected book.</p>
    </header>

    <!-- Main Content Section -->
    <main>
        <section id="Section">
            <h2>Edit Book</h2>
            <div class="form-container">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $bookId; ?>">
                    <table id="table">
                        <tr>
                            <td><label for="book_name">Book Name:</label></td>
                            <td><input type="text" id="book_name" name="book_name" value="<?php echo $bookName; ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="book_page">Book Page:</label></td>
                            <td><input type="text" id="book_page" name="book_page" value="<?php echo $bookPage; ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="book_detail">Book Detail:</label></td>
                            <td><textarea id="text" name="book_detail" required><?php echo $bookDetail; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="book_state">Book State:</label></td>
                            <td>
                                <select id="book_state" name="book_state" required>
                                    <option value="0" <?php echo $bookState == 0 ? 'selected' : ''; ?>>In the library</option>
                                    <option value="1" <?php echo $bookState == 1 ? 'selected' : ''; ?>>Borrowed</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="usernameRow" style="<?php echo $bookState == 1 ? 'display:table-row;' : 'display:none;'; ?>">
                            <td><label for="username">Username:</label></td>
                            <td><input type="text" id="username" name="username" value="<?php echo $username; ?>"></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="center-align-button"><input type="submit" value="Update Book"></td>
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
