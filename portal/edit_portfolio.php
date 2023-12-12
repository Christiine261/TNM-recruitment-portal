<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escape and sanitize user inputs
    function sanitizeInput($input) {
        global $conn;
        return mysqli_real_escape_string($conn, $_POST[$input]);
    }

    // Update user's portfolio data in the database
    $full_name = sanitizeInput('full_name');
    $phone = sanitizeInput('phone');
    $street_address = sanitizeInput('street_address');
    $country = sanitizeInput('country');
    $dob = sanitizeInput('dob');
    $gender = sanitizeInput('gender');
    $degree = sanitizeInput('degree');
    $field_of_study = sanitizeInput('field_of_study');
    $graduation_year = sanitizeInput('graduation_year');
    $educational_institution = sanitizeInput('educational_institution');
    $job_title = sanitizeInput('job_title');
    $company = sanitizeInput('company');
    $years_of_experience = sanitizeInput('years_of_experience');
    $industry = sanitizeInput('industry');
    $certifications = sanitizeInput('certifications');
    $skills = implode(', ', $_POST['skills']);

    // Work Links
    $work_links = [];
    foreach ($_POST['work_titles'] as $key => $work_title) {
        $work_links[] = [
            'work_title' => sanitizeInput('work_titles')[$key],
            'work_doc' => $_FILES['work_docs']['name'][$key],
            'work_image' => $_FILES['work_images']['name'][$key],
            'work_video' => $_FILES['work_videos']['name'][$key],
            'project_url' => sanitizeInput('project_urls')[$key],
        ];
    }

    // References
    $p_references = sanitizeInput('p_references');

    // Directory to store uploaded files
    $uploadDir = 'uploads/portfolios';

    // Create the directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Move and save uploaded files
    $uploadedFiles = [];
    foreach (['work_docs', 'work_images', 'work_videos'] as $fileType) {
        foreach ($_FILES[$fileType]['name'] as $key => $fileName) {
            $filePath = $uploadDir . $fileName;
            move_uploaded_file($_FILES[$fileType]['tmp_name'][$key], $filePath);
            $uploadedFiles[$fileType][$key] = $fileName;
        }
    }

    // Update data in the 'user_profile' table
    $query = "UPDATE user_profile SET
              full_name = '$full_name',
              phone = '$phone',
              street_address = '$street_address',
              country = '$country',
              dob = '$dob',
              gender = '$gender',
              degree = '$degree',
              field_of_study = '$field_of_study',
              graduation_year = '$graduation_year',
              educational_institution = '$educational_institution',
              job_title = '$job_title',
              company = '$company',
              years_of_experience = '$years_of_experience',
              industry = '$industry',
              certifications = '$certifications',
              skills = '$skills',
              p_references = '$p_references',
              work_docs = '{$uploadedFiles['work_docs'][$key]}',
              work_image = '{$uploadedFiles['work_images'][$key]}',
              work_video = '{$uploadedFiles['work_videos'][$key]}',
              project_url = '{$work_links[$key]['project_url']}'
              WHERE user_id = '$user_id'";

    if (mysqli_query($conn, $query)) {
        header('Location: view_portfolio.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
        echo "portfolio not found";
    }

    mysqli_close($conn);
}

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
    <title>Edit Portfolio</title>
    <link href="css/user-profile.css" rel="stylesheet">
</head>
<body>

<div class="profile-container">
    <h2>Edit Your Portfolio</h2>

    <!-- Use the existing form, pre-filling the values from the $portfolio array -->
    <form method="post" action="" id="profile-form" enctype="multipart/form-data">
        
        <label for="full-name">Full Name:</label>
        <input type="text" name="full_name" id="full-name" value="<?php echo $portfolio['full_name']; ?>" required>

        <label for="phone">Phone Number:</label>
                <input type="tel" name="phone" id="phone" value="<?php echo $portfolio['phone']; ?>" required>

                <label for="physical-address">Physical Address:</label>
                <input type="text" name="street_address" id="street-address" value="<?php echo $portfolio['street_address']; ?>" required>

                <label for="country">Country:</label>
                <input type="text" name="country" id="country" value="<?php echo $portfolio['country']; ?>" required>

                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob" id="dob" value="<?php echo $portfolio['dob']; ?>" required>

                <label for="gender">Gender:</label>
                <select name="gender" id="gender" value="<?php echo $portfolio['gender']; ?>" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>

            </div>

            <div id = "professional-info">
                <h3>Education:</h3>
                <label for="degree">Highest Degree Attained:</label>
                <input type="text" name="degree" id="degree" value="<?php echo $portfolio['degree']; ?>" required>

                <label for="field-of-study">Field of Study:</label>
                <input type="text" name="field_of_study" id="field-of-study" value="<?php echo $portfolio['field_of_study']; ?>" required>

                <label for="graduation-year">Graduation Year:</label>
                <input type="text" name="graduation_year" id="graduation-year" value="<?php echo $portfolio['graduation_year']; ?>" required>

                <label for="educational-institution">Educational Institution:</label>
                <input type="text" name="educational_institution" id="educational-institution" value="<?php echo $portfolio['educational_institution']; ?>" required>

                <h3>Work Experience:</h3>
                <label for="job-title">Job Title:</label>
                <input type="text" name="job_title" id="job-title" value="<?php echo $portfolio['job_title']; ?>" required>

                <label for="company">Company/Organization:</label>
                <input type="text" name="company" id="company" value="<?php echo $portfolio['company']; ?>" required>

                <label for="years-of-experience">Years of Experience:</label>
                <input type="text" name="years_of_experience" id="years-of-experience" value="<?php echo $portfolio['years_of_experience']; ?>" required>

                <label for="industry">Industry:</label>
                <input type="text" name="industry" id="industry" value="<?php echo $portfolio['industry']; ?>" required>

                <h3>Professional Certifications:</h3>
                <label for="certifications">Certifications:</label>
                <input type="text" name="certifications" id="certifications" value="<?php echo $portfolio['certifications']; ?>">

                <h3>Skills:</h3>
                <div id="skills-container">
                        <label for="skill">Skill:</label>
                        <input type="text" name="skills[]" id="skill" value="<?php echo $portfolio['skills']; ?>">
                </div>

                <!-- Work Links -->
                <h3>Work Links:</h3>
                <div id="work-links-container">
                    <div class="work-link-entry">
                        <label for="work-title">Work Title:</label>
                        <input type="text" name="work_titles[]" id="work-title" value="<?php echo $portfolio['work_titles']; ?>">

                        <label for="work-doc">Upload Document:</label>
                        <input type="file" name="work_docs[]" id="work-doc" accept=".pdf, .doc, .docx" value="<?php echo $portfolio['work_docs']; ?>">

                        <label for="work-image">Upload Image:</label>
                        <input type="file" name="work_images[]" id="work-image" accept="image/*" value="<?php echo $portfolio['work_images']; ?>">

                        <label for="work-video">Upload Video:</label>
                        <input type="file" name="work_videos[]" id="work-video" accept="video/*" value="<?php echo $portfolio['work_videos']; ?>">

                        <label for="project-url">Project URL:</label>
                        <input type="url" name="project_url[]" id="project-url" placeholder="Enter project URL" value="<?php echo $portfolio['project_url']; ?>">

                    </div>
                </div>

                <!-- References -->
                <h3>References:</h3>
                <label for="p_references">Professional References:</label>
                <input type="text" name="p_references" id="p_references" value="<?php echo $portfolio['p_references']; ?>">
            </div>

        <button type="submit">Update Portfolio</button>
    </form>
</div>

</body>
</html>
