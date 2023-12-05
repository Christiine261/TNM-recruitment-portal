<?php
session_start();

include("../db.php");

if (!isset($_SESSION["user_id"])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php"); // Replace with the actual login page
    exit();
}

$user_id = $_SESSION["user_id"];

// Create a database connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check for a connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute an SQL query to fetch user profile information
$stmt = $conn->prepare("SELECT name, image_path, contact_number FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $imagePath, $contactNumber);
$stmt->fetch();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>User Profile</title>
    <!-- Include your CSS and other styles here -->
</head>
<body>
    <h2>User Profile</h2>
    <p>Welcome, <?php echo $name; ?></p>
    <img src="<?php echo $imagePath; ?>" alt="User Image">
    <p>Contact Number: <?php echo $contactNumber; ?></p>
</body>
</html>
