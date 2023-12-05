<?php
/* $hostname = "localhost";
$username = "root";
$dbname = "tnm_portal";
$password = "";
$usertable = "jobs";
$columnname = "job_title";

mysql_connect($hostname, $username, $password) OR die ("Unable to connect");
mysql_select_db($dbname);
$query="select * from $usertable";
$result=mysql_query($query); */

/* $hostname = "localhost";
$username = "root";
$dbname = "tnm_portal";
$password = "";
$usertable = "jobs";
$columnname = "job_title";

// Create connection
$conn = new mysqli($hostname, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the database
$query = "SELECT * FROM $usertable";
$result = $conn->query($query);

// Check for query success
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Process the result (e.g., fetch rows)
while ($row = $result->fetch_assoc()) {
    // Process each row as needed
    // Example: echo $row['job_title'];
}
s
// Close the connection
$conn->close();

 */
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


      

      <a href="register_form.php" class="btn btn-dark">Logout</a>


    </div>
  </header><!-- End Header -->

  <main id="main" data-aos="fade-in">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs">
      <div class="container">
        <h2>Jobs Application Form</h2>
        <p>Apply Jobs of your Choice</p>
      </div>
    </div><!-- End Breadcrumbs -->

    <div>
       <form action="" method="post" enctype="multipart/form-data">

                <div class="form_container">
                    <div class="form_control">
                        <label for="first_name">Fullname</label>
                        <input type="text" id="fullname" name="fullname" placeholder="Enter fullname.." required>
                    </div>


                    <div class="form_control">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter Email.." required>
                    </div>


                    <div class="textarea_control">
                        <label for="address">Address</label>
                        <textarea id="addres" name="addres" placeholder="Enter address.." row="4" cols="50" required></textarea>  
                    </div>

                    <div class="form_control">
                        <label for="city">Referees</label>
                        <input type="text" id="referees" name="referees" placeholder="Enter referees.." required>
                    </div>

                    
                    <div class="form_control">
                        <label for="upload">Upload Your CV</label>
                        <input type="file" id="upload_CV" name="upload_CV"  accept=".pdf,.doc,.docx"required>
                    </div>

                    <div class="textarea_control">
                    <label for="cover_letter">Cover Letter</label>
                    <input type="file" id="cover_letter" name="cover_letter" accept=".pdf,.doc,.docx" required>
                    </div>


                    <div class="button_container">
                        <button type="submit">Apply Now</button>
                    </div>
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

</body>

</html>

<?php

include_once("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
}

?>