<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tnm_portal";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get job ID from the request
$jobId = isset($_GET['id']) ? $_GET['id'] : null;

if ($jobId) {
    // Fetch job details from the database using the job ID
    $query = "SELECT job_id, job_title, job_description, qualifications, responsibilities, deadline_date FROM jobs WHERE job_id = $jobId";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Output job details as JSON
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Job not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid job ID']);
}

$conn->close();
?>
