
<?php
session_start();
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
    $action = $_POST['action'];
    $bookId = $_POST['bookId'];
    $username = $_SESSION['username'];

    if ($action == "extendBorrow") {
        // Extend the borrow by a week
        $extendQuery = "UPDATE book_information SET date = DATE_ADD(date, INTERVAL 7 DAY) WHERE id = $bookId AND username = '$username'";
        $resultExtend = mysqli_query($conn, $extendQuery);

        if ($resultExtend) {
            echo "Borrow extended successfully!";
        } else {
            echo "Error extending borrow. Please try again.";
        }
    } elseif ($action == "returnBook") {
        // Return the book
        $returnQuery = "UPDATE book_information SET book_state = 0, username = NULL, date = NULL WHERE id = $bookId AND username = '$username'";
        $resultReturn = mysqli_query($conn, $returnQuery);

        if ($resultReturn) {
            echo "Book returned successfully!";
        } else {
            echo "Error returning the book. Please try again.";
        }
    } else {
        // Invalid action
        echo "Invalid action.";
    }

    mysqli_close($conn);
    exit();
} else {
    // Invalid request
    echo "Invalid request.";
    exit();
}
?>
