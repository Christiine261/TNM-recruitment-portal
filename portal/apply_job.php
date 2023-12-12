<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or handle the case where the user is not logged in
    header("Location: login.php");
    exit();
}
?>
<?php
// Check if the job ID parameter is set in the URL
if (isset($_GET['jobId'])) {
    // Get the job ID from the URL
    $job_id = $_GET['jobId'];

    // Now you can use $job_id in your code
    echo "Job ID: $job_id";
} else {
    // Handle the case when the job ID is not provided in the URL
    echo "Job ID not found in the URL.";
}
include_once("db.php");
$user_id = $_SESSION['user_id'];
$query = "SELECT email FROM users WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result) {
    $userDetails = mysqli_fetch_assoc($result);
    $loggedInUserEmail = isset($userDetails['email']) ? $userDetails['email'] : '';
} else {
    // Handle the case when fetching user details fails
    $loggedInUserEmail = '';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Job Application</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/log.png" rel="icon">
  <link href="assets/img/log.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
   <link rel="stylesheet" href="css/jobstyle.css">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <a href="index.php" class="logo me-auto"><img src="assets/img/tnm-logo.png" alt="" class="img-fluid"></a>

      <?php
      $currentPage = 'jobs.php'; 
      include_once("navbar.php");
      ?>


    </div>
  </header><!-- End Header -->

  <main id="main" data-aos="fade-in">
     <!-- ======= Breadcrumbs ======= -->
     <div class="breadcrumbs" data-aos="fade-in">
      <div class="container">
        <h2>Applications</h2>
        <p>Job application form</p>
      </div>
    </div><!-- End Breadcrumbs -->


    <div>
        
        <form id="manual-application-form" method="post" action = "" enctype="multipart/form-data">
                <input type="hidden" name="jobId" value="<?php echo $job_id; ?>">
                        <div class="form_control">
                            <label for="first_name">Fullname</label>
                            <input type="text" id="fullname" name="fullname" placeholder="Enter fullname.." value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : ''; ?>" required>
                        </div>


                        <div class="form_control">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter Email.." value="<?php echo $loggedInUserEmail; ?>" required>
                        </div>


                        <div class="textarea_control">
                            <label for="address">Physical address</label>
                            <textarea id="addres" name="address" placeholder="Enter address.." row="4" cols="50" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>" required></textarea>  
                        </div>

                        <div class="form_control">
                            <label for="city">Referees</label>
                            <input type="text" id="referees" name="referees" placeholder="Enter referees.." value="<?php echo isset($_POST['referees']) ? htmlspecialchars($_POST['referees']) : ''; ?>" required>
                        </div>

                        
                        <div class="form_control">
                            <p style="color: gray; font-size: 12px;"> Please make sure your CV is a PDF, DOC, or DOCX file and contains the word "CV" or "resume" in the filename. </p>
                            <label for="upload">Upload Your CV</label>
                            <input type="file" id="upload_CV" name="upload_CV"  accept=".pdf,.doc,.docx"required>
                        </div>

                        <div class="form_control">
                        <p style="color: gray; font-size: 12px;"> Please make sure your cover letter is a PDF, DOC, or DOCX file and contains the word "CV" or "resume" in the filename. </p>
                            <label for="cover_letter">Cover Letter</label>
                            <input type="file" id="cover_letter" name="cover_letter" accept=".pdf,.doc,.docx" required>
                        </div>
                        
            <input type="submit" value="Submit">
        </form>
    </div>


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include_once("footer.php"); ?>


  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="jobs.js"></script>


</body>

</html>

<?php

include_once("db.php");



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $job_id = $_POST["jobId"];
    $checkSql = "SELECT * FROM job_applications WHERE user_id = '$user_id' AND job_id = '$job_id'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('You have already applied for this job.');</script>";
    } else {
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $referees = $_POST["referees"];

        // Create the "uploads" folder if it doesn't exist
        $CVuploadsFolder = "uploads/CVs";
        $CLuploadsFolder = "uploads/CLs";

        // Upload CV file
        $cvFileName = $_FILES["upload_CV"]["name"];
        $cvFilePath = "$CVuploadsFolder/$cvFileName";

        $allowedCvExtensions = array("pdf", "doc", "docx");
        $cvFileExtension = strtolower(pathinfo($cvFileName, PATHINFO_EXTENSION));
        $cvFileNameLower = strtolower($cvFileName);

        // Check if the CV file passes validation
        if (!in_array($cvFileExtension, $allowedCvExtensions) || (strpos($cvFileNameLower, 'cv') === false && strpos($cvFileNameLower, 'resume') === false)) {
            echo "<script>alert('Invalid CV file. Please make sure the file contains the word \"CV\" or \"resume\" in the filename.');</script>";
        } else {
            // Move uploaded CV file
            move_uploaded_file($_FILES["upload_CV"]["tmp_name"], $cvFilePath);

            // Upload Cover Letter file
            $coverLetterFileName = $_FILES["cover_letter"]["name"];
            $coverLetterFilePath = "$CLuploadsFolder/$coverLetterFileName";

            $allowedCoverLetterExtensions = array("pdf", "doc", "docx");
            $coverLetterFileExtension = strtolower(pathinfo($coverLetterFileName, PATHINFO_EXTENSION));
            $coverLetterFileNameLower = strtolower($coverLetterFileName);

            // Check if the cover letter file passes validation
            if (!in_array($coverLetterFileExtension, $allowedCoverLetterExtensions) || strpos($coverLetterFileNameLower, 'cover letter') === false) {
                echo "<script>alert('Invalid cover letter file. Please make sure the file contains the phrase \"cover letter\" in the filename.');</script>";
            } else {
                // Move uploaded cover letter file
                move_uploaded_file($_FILES["cover_letter"]["tmp_name"], $coverLetterFilePath);

                // Insert data into the database
                $sql = "INSERT INTO job_applications (user_id, job_id, fullname, email, `address`, referees, cv_file_path, cover_letter_file_path)
                VALUES ('$user_id', '$job_id', '$fullname', '$email', '$address', '$referees', '$cvFilePath', '$coverLetterFilePath')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Application submitted successfully!');</script>";
                } else {
                    echo "<script>alert('Application failed. Error: " . $sql . "<br>" . $conn->error . "');</script>";
                }
            }
        }
    }
}



$conn->close();


/* if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $job_title = $_POST["job_title"];
    $address = $_POST["addres"];
    $referees = $_POST["referees"];

    // Check if the required fields are not empty
    if (empty($fullname) || empty($email) || empty($job_title) || empty($address) || empty($referees)) {
        die("Please fill in all required fields.");
    }

    // Upload CV
    $cvFileName = $_FILES["upload_CV"]["name"];
    $cvTempName = $_FILES["upload_CV"]["tmp_name"];
    $cvTargetDir = "uploads/";
    $cvTargetFile = $cvTargetDir . $cvFileName;

    // Upload cover letter
    $coverLetterFileName = $_FILES["cover_letter"]["name"];
    $coverLetterTempName = $_FILES["cover_letter"]["tmp_name"];
    $coverLetterTargetDir = "uploads/cover_letter/";
    $coverLetterTargetFile = $coverLetterTargetDir . $coverLetterFileName;

    // Move uploaded files to the target directory
    if (move_uploaded_file($cvTempName, $cvTargetFile) && move_uploaded_file($coverLetterTempName, $coverLetterTargetFile)) {
        // Insert data into the database
        $sql = "INSERT INTO applications_received (fullname, email, job_title, addres, referees, upload_CV, cover_letter) 
                VALUES ('$fullname', '$email', '$job_title', '$address', '$referees', '$cvFileName', '$coverLetterFileName')";

        if (mysqli_query($conn, $sql)) {
            echo "Application submitted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "File upload failed.";
    }

    mysqli_close($conn);
} */

?>