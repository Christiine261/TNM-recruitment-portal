
<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect unauthenticated users to the login page
    header('Location: login.php');
    exit();
}

// Include your database connection
include_once("db.php");

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user_profile WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);

if ($result) {
    $userData = mysqli_fetch_assoc($result);
} else {
    // Handle database error
    die("Database error: " . mysqli_error($conn));
}

// Check if the form is submitted for profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update user data in the database
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $street_address = mysqli_real_escape_string($conn, $_POST['street_address']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    $degree = mysqli_real_escape_string($conn, $_POST['degree']);
    $field_of_study = mysqli_real_escape_string($conn, $_POST['field_of_study']);
    $graduation_year = mysqli_real_escape_string($conn, $_POST['graduation_year']);
    $educational_institution = mysqli_real_escape_string($conn, $_POST['educational_institution']);

    $job_title = mysqli_real_escape_string($conn, $_POST['job_title']);
    $company = mysqli_real_escape_string($conn, $_POST['company']);
    $years_of_experience = mysqli_real_escape_string($conn, $_POST['years_of_experience']);
    $industry = mysqli_real_escape_string($conn, $_POST['industry']);

    $certifications = mysqli_real_escape_string($conn, $_POST['certifications']);

    // Handle other fields as needed...

    // Update the user_profile table
    $updateSql = "UPDATE user_profile SET
        first_name = '$first_name',
        middle_name = '$middle_name',
        last_name = '$last_name',
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
        certifications = '$certifications'
        WHERE user_id = $user_id";

    $updateResult = mysqli_query($conn, $updateSql);

    if ($updateResult) {
        // Redirect to the profile page after update
        header('Location: portfolio_page.php');
        exit();
    } else {
        // Handle update error
        die("Update error: " . mysqli_error($conn));
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User portfolio</title>

    <link href="css/user-profile.css" rel="stylesheet">

</head>
<body>

<div class="profile-container">
       

        <form method="post" action="" id="profile-form">
            <div id="basic-info">
                <h3>basic personal Information</h3>
                <label for="full-name">First Name:</label>
                <input type="text" name="full_name" id="full-name" required>


                <label for="phone">Phone Number:</label>
                <input type="tel" name="phone" id="phone" required>

                <label for="physical-address">Physical Address:</label>
                <input type="text" name="street_address" id="street-address" required>

                <label for="country">Country:</label>
                <input type="text" name="country" id="country" required>

                <!-- Date of Birth -->
                <label for="dob">Date of Birth:</label>
                <input type="date" name="dob" id="dob" required>

                <!-- Gender -->
                <label for="gender">Gender:</label>
                <select name="gender" id="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>


            </div>

            <!-- Education -->
            <div id = "professional-info">
                <h3>Education:</h3>
                <label for="degree">Highest Degree Attained:</label>
                <input type="text" name="degree" id="degree" required>

                <label for="field-of-study">Field of Study:</label>
                <input type="text" name="field_of_study" id="field-of-study" required>

                <label for="graduation-year">Graduation Year:</label>
                <input type="text" name="graduation_year" id="graduation-year" required>

                <label for="educational-institution">Educational Institution:</label>
                <input type="text" name="educational_institution" id="educational-institution" required>

                <!-- Work Experience -->
                <h3>Work Experience:</h3>
                <label for="job-title">Job Title:</label>
                <input type="text" name="job_title" id="job-title" required>

                <label for="company">Company/Organization:</label>
                <input type="text" name="company" id="company" required>

                <label for="years-of-experience">Years of Experience:</label>
                <input type="text" name="years_of_experience" id="years-of-experience" required>

                <label for="industry">Industry:</label>
                <input type="text" name="industry" id="industry" required>

                <!-- Professional Certifications -->
                <h3>Professional Certifications:</h3>
                <label for="certifications">Certifications:</label>
                <input type="text" name="certifications" id="certifications">

                <!-- Additional Skills -->
                <h3>Skills:</h3>
                <div id="skills-container">
                    <div class="skill-entry">
                        <label for="skill">Skill:</label>
                        <input type="text" name="skills[]" id="skill" placeholder="Enter a skill">
                        <button type="button" onclick="removeSkillEntry(this)">Remove Skill</button>
                    </div>
                </div>
                <button type="button" onclick="addSkillEntry()">Add Skill</button>

                <!-- Work Links -->
                <h3>Work Links:</h3>
                <div id="work-links-container">
                    <div class="work-link-entry">
                        <label for="work-title">Work Title:</label>
                        <input type="text" name="work_titles[]" id="work-title" placeholder="Enter work title">

                        <label for="work-doc">Upload Document:</label>
                        <input type="file" name="work_docs[]" id="work-doc" accept=".pdf, .doc, .docx">

                        <label for="work-image">Upload Image:</label>
                        <input type="file" name="work_images[]" id="work-image" accept="image/*">

                        <label for="work-video">Upload Video:</label>
                        <input type="file" name="work_videos[]" id="work-video" accept="video/*">

                        <label for="project-url">Project URL:</label>
                        <input type="url" name="project_urls[]" id="project-url" placeholder="Enter project URL">

                        <button type="button" onclick="removeWorkLinkEntry(this)">Remove Work Link</button>
                    </div>
                </div>
                <button type="button" onclick="addWorkLinkEntry()">Add Work Link</button>

                <!-- References -->
                <h3>References:</h3>
                <label for="p_references">Professional References:</label>
                <input type="text" name="p_references" id="p_references">
            </div>

    

            <button type="submit">Save Changes</button>
        </form>


        <script>
            function addSkillEntry() {
                var skillsContainer = document.getElementById('skills-container');

                var skillEntry = document.createElement('div');
                skillEntry.className = 'skill-entry';

                var skillLabel = document.createElement('label');
                skillLabel.textContent = 'Skill:';
                skillLabel.htmlFor = 'skill';

                var skillInput = document.createElement('input');
                skillInput.type = 'text';
                skillInput.name = 'skills[]';
                skillInput.id = 'skill';
                skillInput.placeholder = 'Enter a skill';

                var removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.textContent = 'Remove Skill';
                removeButton.onclick = function () {
                    removeSkillEntry(skillEntry);
                };

                skillEntry.appendChild(skillLabel);
                skillEntry.appendChild(skillInput);
                skillEntry.appendChild(removeButton);

                skillsContainer.appendChild(skillEntry);
            }

            function removeSkillEntry(entry) {
                var skillsContainer = document.getElementById('skills-container');
                skillsContainer.removeChild(entry);
            }

            function addWorkLinkEntry() {
                var workLinksContainer = document.getElementById('work-links-container');

                var workLinkEntry = document.createElement('div');
                workLinkEntry.className = 'work-link-entry';

                var workTitleLabel = document.createElement('label');
                workTitleLabel.textContent = 'Work Title:';
                workTitleLabel.htmlFor = 'work-title';

                var workTitleInput = document.createElement('input');
                workTitleInput.type = 'text';
                workTitleInput.name = 'work_titles[]';
                workTitleInput.id = 'work-title';
                workTitleInput.placeholder = 'Enter work title';

                var workDocLabel = document.createElement('label');
                workDocLabel.textContent = 'Upload Document:';
                workDocLabel.htmlFor = 'work-doc';

                var workDocInput = document.createElement('input');
                workDocInput.type = 'file';
                workDocInput.name = 'work_docs[]';
                workDocInput.id = 'work-doc';
                workDocInput.accept = '.pdf, .doc, .docx';

                var workImageLabel = document.createElement('label');
                workImageLabel.textContent = 'Upload Image:';
                workImageLabel.htmlFor = 'work-image';

                var workImageInput = document.createElement('input');
                workImageInput.type = 'file';
                workImageInput.name = 'work_images[]';
                workImageInput.id = 'work-image';
                workImageInput.accept = 'image/*';

                var workVideoLabel = document.createElement('label');
                workVideoLabel.textContent = 'Upload Video:';
                workVideoLabel.htmlFor = 'work-video';

                var workVideoInput = document.createElement('input');
                workVideoInput.type = 'file';
                workVideoInput.name = 'work_videos[]';
                workVideoInput.id = 'work-video';
                workVideoInput.accept = 'video/*';

                var projectUrlLabel = document.createElement('label');
                projectUrlLabel.textContent = 'Project URL (Optional):';
                projectUrlLabel.htmlFor = 'project-url';

                var projectUrlInput = document.createElement('input');
                projectUrlInput.type = 'url';
                projectUrlInput.name = 'project_urls[]';
                projectUrlInput.id = 'project-url';
                projectUrlInput.placeholder = 'Enter project URL';

                var removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.textContent = 'Remove Work Link';
                removeButton.onclick = function () {
                    removeWorkLinkEntry(workLinkEntry);
                };

                workLinkEntry.appendChild(workTitleLabel);
                workLinkEntry.appendChild(workTitleInput);
                workLinkEntry.appendChild(workDocLabel);
                workLinkEntry.appendChild(workDocInput);
                workLinkEntry.appendChild(workImageLabel);
                workLinkEntry.appendChild(workImageInput);
                workLinkEntry.appendChild(workVideoLabel);
                workLinkEntry.appendChild(workVideoInput);
                workLinkEntry.appendChild(projectUrlLabel);
                workLinkEntry.appendChild(projectUrlInput);
                workLinkEntry.appendChild(removeButton);

                workLinksContainer.appendChild(workLinkEntry);
            }

            function removeWorkLinkEntry(entry) {
                var workLinksContainer = document.getElementById('work-links-container');
                workLinksContainer.removeChild(entry);
            }
        </script>

    </div>
    
</body>
</html>