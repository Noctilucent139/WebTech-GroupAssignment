<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <!-- Navigation Bar -->
    <?php include 'topnav_index.php';?>

    <!-- Main Content -->
    <main>
        <section id="forgotPasswordSection">
            <h2>Forgot Password</h2>
            <p>Please enter your email address. You will receive a link to create a new password via email.</p>

            <!-- Forgot Password Form -->
            <form action="password_reset_process.php" method="post">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <input type="submit" value="Send Reset Link">
            </form>
        </section>
    </main>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>
</html>
