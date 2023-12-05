<?php
session_start();
include_once("db.php");

// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $phone_number = $_POST["phone_number"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $nationality = $_POST["nationality"];
    $profile_picture = $_POST["profile_picture"];
    
    // SQL query to insert user data into the database
    $sql = "INSERT INTO users (firstname, lastname, phone_number, gender, dob, email, password, nationality, profile_picture) VALUES ('$firstname', '$lastname', '$phone_number', '$gender', '$dob', '$email', '$password', '$nationality', '$profile_picture')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful, redirect to login form
        header("Location: signin.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error();
    }
}

// Close the connection
$conn->close();
?>
