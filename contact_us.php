<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_index.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>Contact Us</h1>
        <p>Reach out for inquiries, support, or feedback. We're here to help!</p>
    </header>

    <!-- Main Content Section -->
    <main>
        <section id="contactSection">
        <h2>Get in touch with us!</h2>
        <!-- Contact Form -->
        <form action="contact_us_process.php" method="post">
            <table>
                <tr>
                    <td><label for="name">Name:</label></td>
                    <td><input type="text" id="name" name="name" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" id="email" name="email" required></td>
                </tr>
                <tr>
                    <td><label for="message">Message:</label></td>
                    <td><textarea id="message" name="message" required></textarea></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Send Message"></td>
                </tr>
            </table>
        </form>
        </section>
    </main>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
