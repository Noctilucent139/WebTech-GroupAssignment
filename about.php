<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Online Library</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation Bar -->
    <?php include 'topnav_index.php';?>

    <!-- Header Section -->
    <header class="header">
        <h1>About Our Online Library</h1>
        <p>Discover the story behind our vast collection of books and resources.</p>
    </header>

    <!-- Main Content Section -->
    <main>
        <section id="aboutSection">
            <h2>Our Mission</h2>
            <p>
                Established in 2024, our online library aims to provide easy access to a wide
                range of books and resources to readers and researchers around the globe. Our
                mission is to support lifelong learning and foster a love of reading in people
                of all ages.
            </p>

            <h2>Our Collection</h2>
            <p>
                From classic literature to contemporary bestsellers, our expansive collection
                includes over 100 titles across various genres and subjects. We continuously
                update our library to include the latest publications and scholarly works.
            </p>

            <h2>Our Team</h2>
            <p>
                Our dedicated team of librarians and support staff are passionate about books
                and committed to providing an exceptional online experience for our members.
                They curate our collection, guide readers, and are always eager to help with
                any inquiries.
            </p>

            <h2>Community and Events</h2>
            <p>
                We believe in the power of community and regularly host online events like
                author talks, book clubs, and workshops. These events are great opportunities
                for our members to connect and learn from each other.
            </p>

            <h2>Contact Us</h2>
            <p>
                Have questions or need assistance? Contact our support team at onlinelib@gmail.com
                or follow us on social media to stay updated with the latest news and events.
            </p>
        </section>
    </main>

    <!-- Footer Section -->
    <?php include 'footer.php';?>

</body>

</html>
