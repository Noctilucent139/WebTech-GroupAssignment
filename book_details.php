
<?php
session_start();
include("config.php");

// Ensure that the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $bookId = $_GET['id'];

    // Fetch book details from the database
    $sql = "SELECT id, book_name, book_page, book_detail FROM book_information WHERE id = $bookId";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $bookId = $row["id"];
        $bookName = $row["book_name"];
        $bookPage = $row["book_page"];
        $bookDetail = $row["book_detail"];
    } else {
        // Handle the case when the book with the specified id is not found
        echo "Book not found.";
        exit();
    }
} else {
    // Handle the case when the 'id' parameter is not set in the URL
    echo "Invalid request.";
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Detail</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_user.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>Book Detail</h1>
    </header>

    <!-- Book Details Section -->
    <table id="table">
        <tr>
            <th>ID</th>
            <th>Book Name</th>
            <th>Page</th>
            <th>Detail</th>
        </tr>
        <tr>
            <td><?php echo $bookId; ?></td>
            <td><?php echo $bookName; ?></td>
            <td><?php echo $bookPage; ?></td>
            <td><?php echo $bookDetail; ?></td>
        </tr>
    </table>

    <!-- Go Back Button -->
    <button onclick="goBack()" class="back-button">Go Back</button>

    <!-- JavaScript for Go Back -->
    <script>
        function goBack() {
            window.history.back();
        }
    </script>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
