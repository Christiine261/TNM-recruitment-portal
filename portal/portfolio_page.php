<?php
session_start();

// Include your database connection
include_once("db.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect unauthenticated users to the login page
    header('Location: login.php');
    exit();
}

// Fetch user data from the database
$user_id = $_SESSION['user_id'];

// Use a prepared statement to prevent SQL injection
$query = "SELECT user_profile.*, users.email
          FROM user_profile
          JOIN users ON user_profile.user_id = users.user_id
          WHERE user_profile.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $userData = $result->fetch_assoc();
} else {
    // Handle database error
    die("Database error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Add your CSS styles here -->
</head>
<body>

    <h2>User Profile</h2>

    <p>Email: <?php 

    echo $userData['email']; ?></p>

<p>id: <?php 

echo $userData['user_id']; ?></p>
    <!-- Display other profile details -->
    <h3>Basic Personal Information</h3>
    <p>First Name: <?php echo $userData['first_name']; ?></p>
    <p>Middle Name: <?php echo $userData['middle_name']; ?></p>
    <p>Last Name: <?php echo $userData['last_name']; ?></p>
    <p>Phone Number: <?php echo $userData['phone']; ?></p>
    <p>Physical Address: <?php echo $userData['street_address']; ?></p>
    <p>Country: <?php echo $userData['country']; ?></p>
    <p>Date of Birth: <?php echo $userData['dob']; ?></p>
    <p>Gender: <?php echo $userData['gender']; ?></p>

    <h3>Education</h3>
    <p>Highest Degree Attained: <?php echo $userData['degree']; ?></p>
    <p>Field of Study: <?php echo $userData['field_of_study']; ?></p>
    <p>Graduation Year: <?php echo $userData['graduation_year']; ?></p>
    <p>Educational Institution: <?php echo $userData['educational_institution']; ?></p>

    <h3>Work Experience</h3>
    <p>Job Title: <?php echo $userData['job_title']; ?></p>
    <p>Company/Organization: <?php echo $userData['company']; ?></p>
    <p>Years of Experience: <?php echo $userData['years_of_experience']; ?></p>
    <p>Industry: <?php echo $userData['industry']; ?></p>

    <h3>Professional Certifications</h3>
    <p>Certifications: <?php echo $userData['certifications']; ?></p>

    <h3>Skills</h3>
    <?php
        $skills = explode(', ', $userData['skills']);
        foreach ($skills as $skill) {
            echo "<p>Skill: $skill</p>";
        }
    ?>

    <h3>Work Links</h3>
    <?php
        $workTitles = explode(', ', $userData['work_titles']);
        $workDocs = explode(', ', $userData['work_docs']);
        $workImages = explode(', ', $userData['work_images']);
        $workVideos = explode(', ', $userData['work_videos']);
        $projectURLs = explode(', ', $userData['project_urls']);

        for ($i = 0; $i < count($workTitles); $i++) {
            echo "<h4>Work Entry $i</h4>";
            echo "<p>Work Title: $workTitles[$i]</p>";
            echo "<p>Document: $workDocs[$i]</p>";
            echo "<p>Image: $workImages[$i]</p>";
            echo "<p>Video: $workVideos[$i]</p>";
            echo "<p>Project URL: $projectURLs[$i]</p>";
        }
    ?>

    <h3>References</h3>
    <p>Professional References: <?php echo $userData['p_references']; ?></p>

    <p><a href="portfolio_form.php">Edit Profile</a></p>

</body>
</html>
