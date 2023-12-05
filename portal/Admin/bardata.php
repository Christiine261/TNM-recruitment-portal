<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "tnm_portal";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT jobs.job_title, COUNT(applications_received.application_id) as application_count
          FROM jobs
          LEFT JOIN applications_received ON jobs.job_title = applications_received.job_title
          GROUP BY jobs.job_title";
$result = $conn->query($query);

$data = array();
$data[] = ['Job Title', 'Applications Received'];

while ($row = $result->fetch_assoc()) {
    $data[] = [$row['job_title'], (int)$row['application_count']];
}

echo json_encode($data, JSON_NUMERIC_CHECK);

$conn->close();
?>
