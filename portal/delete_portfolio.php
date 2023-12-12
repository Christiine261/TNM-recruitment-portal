<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
include('db.php');

// Check if the user has an existing portfolio
$query = "SELECT * FROM user_profile WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result) {
    $portfolio = mysqli_fetch_assoc($result);

    if ($portfolio) {
        // Delete the user's portfolio
        $deleteQuery = "DELETE FROM user_profile WHERE user_id = '$user_id'";

        if (mysqli_query($conn, $deleteQuery)) {
            // Redirect to a success page or any other desired location
            echo "Delete successful";
            exit();
        } else {
            // Handle the error
            echo "Error deleting portfolio: " . mysqli_error($conn);
        }
    } else {
        // Redirect to a page indicating that the user doesn't have a portfolio
        echo "No portfolio found";
        exit();
    }
} else {
    // Handle the error
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
