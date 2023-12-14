<?php
// job_details.php

require_once("db.php");

// Check if the job ID is provided in the URL
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>job details</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/log.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="css/home_apply.css" rel="stylesheet">
</head>
<body>
    <header>
    <nav>
        <a href="jobs.php">View All Jobs</a>
    </nav>
    </header>
    <main>
        <div id = "job_description">
    <?php
        if (isset($_GET['id'])) {
            $job_id = $_GET['id'];
        
            // Fetch job details from the database based on the job ID
            $query = "SELECT * FROM jobs WHERE job_id = $job_id";
            $result = $conn->query($query);
        
            if ($result->num_rows > 0) {
                $job_details = $result->fetch_assoc();
        
                // Display job details as bullet points
                echo '<div id = "job_header">
                        <h2>' . $job_details['job_title'] . '</h2></div>';
                echo '<p> TNM invites suitably qualified candidates to fill the position of <strong>' . $job_details['job_title'] . '</strong></P>';
                echo '<p> <strong>Position overview</strong> </p>';
                echo '<p>' . $job_details['job_description'] . '</p>';
                echo '<p><strong> Qualifications, experience and desired skills </strong></p>';
                echo '<ul>';
        
                // Explode job description into bullet points based on newline character
                $job_qualifications_lines = explode("\n", $job_details['qualifications']);
                foreach ($job_qualifications_lines as $line) {
                    echo '<li>' . trim($line) . '</li>';
                }
        
                echo '</ul>';

                echo '<p><strong> Key responsibilities</strong></p>';


                echo '<ul>';
        
                // Explode job description into bullet points based on newline character
                $job_respo_lines = explode("\n", $job_details['responsibilities']);
                foreach ($job_respo_lines as $line) {
                    echo '<li>' . trim($line) . '</li>';
                }
        
                echo '</ul>';
            } else {
                echo "Job not found.";
            }
        
            $conn->close();
        } else {
            echo "Invalid request. Job ID not provided.";
        }
    ?>

        </div>
        <div id="apply_now">
            <a class="apply-btn" href="apply_job.php?id=<?php echo $job_id; ?>">Apply Now</a>
        </div>
    </main>
</body>
</html>