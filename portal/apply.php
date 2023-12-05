<!DOCTYPE html>
<html>
<head>
    <title>Job Application</title>
</head>
<body>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $resume = $_FILES["resume"]["name"];
    
    // Destination path for uploaded resume
    $uploadPath = "uploads/" . basename($resume);

    // Send email with application details
    $to = "logahstankey@gmail.com";
    $subject = "New Job Application";
    $message = "Name: $name\nEmail: $email\nPhone: $phone\nResume: $resume";
    $headers = "From: $email";

    if (move_uploaded_file($_FILES["resume"]["tmp_name"], $uploadPath) && mail($to, $subject, $message, $headers)) {
        echo "<h1>Application Submitted Successfully</h1>";
        echo "<p>Thank you for submitting your job application. We will review your information and get back to you soon.</p>";
    } else {
        echo "<h1>Error</h1>";
        echo "<p>There was an error processing your application. Please try again later.</p>";
    }
} else {
?>

<h1>Job Application Form</h1>
<form method="post" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" name="name" required><br>
    
    <label for="email">Email:</label>
    <input type="email" name="email" required><br>
    
    <label for="phone">Phone:</label>
    <input type="tel" name="phone" required><br>
    
    <label for="resume">Resume:</label>
    <input type="file" name="resume" accept=".pdf,.doc,.docx" required><br>
    
    <input type="submit" value="Submit Application">
</form>

<?php
}
?>

</body>
</html>
