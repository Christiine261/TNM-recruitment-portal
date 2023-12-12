<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
include('db.php');

// Fetch user's portfolio data from the database
$query = "SELECT * FROM user_profile WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result) {
    $portfolio = mysqli_fetch_assoc($result);
} else {
    // Handle the error
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Portfolio</title>
    <link href="css/user-profile.css" rel="stylesheet">
</head>
<body>

<div class="profile-container">
    <!-- Display portfolio data here -->
    <h2>Your Portfolio</h2>
    
    <p><strong>Full Name:</strong> <?php echo $portfolio['full_name']; ?></p>
    <p><strong>Phone Number:</strong> <?php echo $portfolio['phone']; ?></p>
    <p><strong>ADDRESS:</strong> <?php echo $portfolio['street_address']; ?></p>
    <p><strong>Country:</strong> <?php echo $portfolio['country']; ?></p>
    <p><strong>Date_Of_Birth:</strong> <?php echo $portfolio['dob']; ?></p>
    <p><strong>Gender:</strong> <?php echo $portfolio['gender']; ?></p>
    <p><strong>Degree:</strong> <?php echo $portfolio['degree']; ?></p>
    <p><strong>Field_Of_Study:</strong> <?php echo $portfolio['field_of_study']; ?></p>
    <p><strong>Graduation Year:</strong> <?php echo $portfolio['graduation_year']; ?></p>
    <p><strong>Institution:</strong> <?php echo $portfolio['educational_institution']; ?></p>
    <p><strong>Job Title:</strong> <?php echo $portfolio['job_title']; ?></p>
    <p><strong>Companies:</strong> <?php echo $portfolio['company']; ?></p>
    <p><strong>Year Of Experience:</strong> <?php echo $portfolio['years_of_experience']; ?></p>
    <p><strong>Industry:</strong> <?php echo $portfolio['industry']; ?></p>
    <p><strong>Certifications:</strong> <?php echo $portfolio['certifications']; ?></p>
    <p><strong>Skills:</strong> <?php echo $portfolio['skills']; ?></p>
    <p><strong>Work Titles:</strong> <?php echo $portfolio['work_titles']; ?></p>
    <p><strong>Project Documents:</strong> <?php echo $portfolio['work_docs']; ?></p>
    <p><strong>Project Images:</strong> <?php echo $portfolio['work_image']; ?></p>
    <p><strong>Project Videos:</strong> <?php echo $portfolio['work_video']; ?></p>
    <p><strong>Project URl:</strong> <?php echo $portfolio['project_url']; ?></p>
    <p><strong>References:</strong> <?php echo $portfolio['p_references']; ?></p>

    <!-- Edit button that redirects to the edit_portfolio.php page -->
    <a href="edit_portfolio.php">Edit Portfolio</a>

    <!-- Delete button that triggers a confirmation dialog -->
    <button onclick="confirmDelete()">Delete Portfolio</button>

    <script>
        function confirmDelete() {
            if (confirm("Are you sure you want to delete your portfolio?")) {
                window.location.href = 'delete_portfolio.php'; // Redirect to delete_portfolio.php
            }
        }
    </script>
</div>

</body>
</html>
