<?php
// activate.php
require_once('db.php'); // Include your database connection

$email = $_GET['email'];
$activationToken = $_GET['token'];

// Update user's activation status in the database
$stmt = $pdo->prepare("UPDATE users SET is_active = 1 WHERE email = ? AND activation_token = ?");
$stmt->execute([$email, $activationToken]);

echo "Account activated successfully!";
?>
