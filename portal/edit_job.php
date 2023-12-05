<?php
// Include your database connection code or configuration here
require_once("../db.php"); // Adjust the path as needed

// Check if a job ID is provided in the query string
if (isset($_GET["id"])) {
    $job_id = $_GET["id"];

    // Check if the form is submitted to update the job post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $job_title = $_POST["job_title"];
        $job_description = $_POST["job_description"];
        $qualifications = $_POST["qualifications"];
        $responsibilities = $_POST["responsibilities"];
        $deadline_date = $_POST["deadline_date"];

        // Update the job post in the database
        $query = "UPDATE hr_details SET job_title = ?, job_description = ?, qualifications = ?, responsibilities = ?, deadline_date = ? WHERE job_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssi", $job_title, $job_description, $qualifications, $responsibilities, $deadline_date, $job_id);

        if ($stmt->execute()) {
            // Job post updated successfully, redirect to view_jobs.php or another appropriate page
            header("Location: view_jobs.php"); // Adjust the redirection URL
            exit();
        } else {
            echo "Error updating job post: " . $conn->error;
        }
    }

    // Fetch the job post data for editing
    $query = "SELECT * FROM hr_details WHERE job_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Job post not found.";
        exit();
    }
} else {
    echo "Job ID not provided.";
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Edit Job Post</title>
    
    <!-- Add your CSS link here -->
    <link href="assets/css/edit_job.css" rel="stylesheet">
</head>
<body>
    <h1>Edit Job Post</h1>
    <form method="POST" action="">
        <label for="job_title">Job Title:</label>
        <input type="text" name="job_title" id="job_title" value="<?php echo $row['job_title']; ?>" required>

        <label for="job_description">Job Description:</label>
        <textarea name="job_description" id="job_description" required><?php echo $row['job_description']; ?></textarea>

        <label for="qualifications">Qualifications:</label>
        <textarea name="qualifications" id="qualifications" required><?php echo $row['qualifications']; ?></textarea>

        <label for="responsibilities">Responsibilities:</label>
        <textarea name="responsibilities" id="responsibilities" required><?php echo $row['responsibilities']; ?></textarea>

        <label for="deadline_date">Deadline Date:</label>
        <input type="date" name="deadline_date" id="deadline_date" value="<?php echo $row['deadline_date']; ?>" required>

        <input type="submit" value="Update Job Post">
    </form>
</body>
</html>
