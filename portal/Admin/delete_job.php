<!DOCTYPE html>
<html>
<head>
    <title>Delete job post</title>
    <style type="text/css">
        
        /* Style the confirmation prompt container */
.confirmation-prompt {
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
    border: 2px solid #007bff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    font-family: Arial, sans-serif;
    text-align: center;
}

/* Style the "Yes" and "No" links */
.confirmation-prompt a {
    color: #007bff;
    text-decoration: none;
    padding: 10px 20px;
    border: 1px solid #007bff;
    border-radius: 5px;
    font-size: 16px;
    margin: 10px;
    display: inline-block;
    transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
}

.confirmation-prompt a:hover {
    background-color: #0056b3;
    color: #fff;
}

    </style>
</head>
<body>

    <?php
// Include your database connection code or configuration here
require_once("../db.php"); // Adjust the path as needed

// Check if a job ID is provided in the query string
if (isset($_GET["id"])) {
    $job_id = $_GET["id"];

    // Check if the user has confirmed the deletion
    if (isset($_GET["confirm"]) && $_GET["confirm"] === "true") {
        // Delete the job post from the database
        $query = "DELETE FROM jobs WHERE job_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $job_id);

        if ($stmt->execute()) {
            // Job post deleted successfully, redirect to view_jobs.php or another appropriate page
            header("Location: view_jobs.php"); // Adjust the redirection URL
            exit();
        } else {
            echo "Error deleting job post: " . $conn->error;
        }
    } else {
        // Display a confirmation prompt
       // Display a styled confirmation prompt
echo '<div class="confirmation-prompt">';
echo "Are you sure you want to delete this job post?";
echo '<a href="delete_job.php?id=' . $job_id . '&confirm=true">Yes, delete</a>';
echo ' | <a href="view_jobs.php">No, cancel</a>';
echo '</div>';

    }
} else {
    echo "Job ID not provided.";
    exit();
}

// Close the database connection
$conn->close();
?>


</body>
</html>



