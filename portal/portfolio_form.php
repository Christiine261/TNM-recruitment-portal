
<?php
session_start();

var_dump($_SESSION);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
include('db.php');

// Fetch user details to pre-fill full_name
$query = "SELECT full_name FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result) {
    $userDetails = mysqli_fetch_assoc($result);
    $loggedInUserFullName = isset($userDetails['full_name']) ? $userDetails['full_name'] : '';
} else {
    // Handle the case when fetching user details fails
    $loggedInUserFullName = '';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escape and sanitize user inputs
    function sanitizeInput($input) {
        global $conn;
        return mysqli_real_escape_string($conn, $_POST[$input]);
    }

    // Basic Personal Information
    $full_name = is_array($_POST['full_name']) ? '' : sanitizeInput('full_name');
    $phone = sanitizeInput('phone');
    $street_address = sanitizeInput('street_address');
    $country = sanitizeInput('country');
    $dob = sanitizeInput('dob');
    $gender = sanitizeInput('gender');

    // Education
    $degree = sanitizeInput('degree');
    $field_of_study = sanitizeInput('field_of_study');
    $graduation_year = sanitizeInput('graduation_year');
    $educational_institution = sanitizeInput('educational_institution');

    // Work Experience
    $job_title = sanitizeInput('job_title');
    $company = sanitizeInput('company');
    $years_of_experience = sanitizeInput('years_of_experience');
    $industry = sanitizeInput('industry');

    // Professional Certifications
    $certifications = sanitizeInput('certifications');

    // Additional Skills
    $skills = implode(', ', $_POST['skills']);

    // Work Links
    $work_links = [];
    $work_links = isset($_POST['project_urls']) ? $_POST['project_urls'] : [];
    foreach ($work_links as $key => $work_title) {
        $work_links[] = [
            'work_title' => sanitizeInput('work_titles')[$key],
            'work_doc' => $_FILES['work_docs']['name'][$key],
            'work_image' => $_FILES['work_images']['name'][$key],
            'work_video' => $_FILES['work_videos']['name'][$key],
            //'project_url' => sanitizeInput('project_urls')[$key],
            'project_url' => isset($_POST['project_urls'][$key]) ? sanitizeInput('project_urls')[$key] : '',

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

    $query = "INSERT INTO user_profile (user_id, full_name, phone, street_address, country, dob, gender, degree, field_of_study, graduation_year, educational_institution, job_title, company, years_of_experience, industry, certifications, skills, p_references, work_docs, work_image, work_video, project_url) 
              VALUES ('$user_id', '$full_name', '$phone', '$street_address', '$country', '$dob', '$gender', '$degree', '$field_of_study', '$graduation_year', '$educational_institution', '$job_title', '$company', '$years_of_experience', '$industry', '$certifications', '$skills', '$p_references', '{$uploadedFiles['work_docs'][$key]}', '{$uploadedFiles['work_images'][$key]}', '{$uploadedFiles['work_videos'][$key]}', '{$work_links[$key]}')";

    if (mysqli_query($conn, $query)) {
        header('Location: success.php');
        exit();
    } else  {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
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
       

        <form method="post" action="" id="profile-form" enctype="multipart/form-data">
            <div id="basic-info">
                <h3>basic personal Information</h3>
                <label for="full-name">Full Name:</label>
                <input type="text" name="full_name" id="full-name" value="<?php echo $loggedInUserFullName; ?>" required>


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
                        <input type="url" name="project_url[]" id="project-url" placeholder="Enter project URL">

                        <button type="button" onclick="removeWorkLinkEntry(this)">Remove Work Link</button>
                    </div>
                </div>
                <button type="button" onclick="addWorkLinkEntry()">Add Work Link</button>

                <!-- References -->
                <h3>References:</h3>
                <label for="p_references">Professional References:</label>
                <input type="text" name="p_references" id="p_references">
            </div>

    

            <button type="submit">Create  Portfolio</button>
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