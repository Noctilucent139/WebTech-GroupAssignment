<?php
session_start();
// Database credentials
include("config.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect post data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO contact_form_submissions (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute the prepared statement
    if ($stmt->execute()) {
      echo '<script>alert("Message sent!"); window.location.href = "contact_us.php";</script>';
      exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
