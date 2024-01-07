
<?php
session_start();
include("config.php");
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
            <th>Action</th>
        </tr>

        <?php
        // Display book table data
        $sql = "SELECT id, book_name FROM book_information";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td><td>" . $row["book_name"] . "</td>";
                echo '<td><a href="add_to_list.php?id=' . $row["id"] . '">Add to List</a>&nbsp;|&nbsp;';
                echo '<a href="book_detail.php?id=' . $row["id"] . '">View Details</a></td>';
                echo "</tr>" . "\n\t\t";
            }
        } else {
            echo '<tr><td colspan="3">0 results</td></tr>';
        }

        mysqli_close($conn);
        ?>
        
    </table>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
