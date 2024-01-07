
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_index.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>Welcome to Online Library</h1>
        <p>Log in to access a vast collection of books and resources for your academic journey.</p>
    </header>

    <!-- Main Content Section -->
    <main>
        <section id="loginSection">
        <h2>Login</h2>
        <!-- Login Form -->
        <form action="auth_login_process.php" method="post">
            <table>
                <tr>
                    <td><label for="username">Username:</label></td>
                    <td><input type="text" id="username" name="username" required></td>
                </tr>
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="password" id="password" name="password" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Login"></td>
                </tr>
            </table>
        </form>

        <p><a href="auth_forgotPass.php">Forgot your password?</a></p>
        <p><a href="auth_register.php">Do not have account? Create here!</a></p>
        </section>
    </main>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
