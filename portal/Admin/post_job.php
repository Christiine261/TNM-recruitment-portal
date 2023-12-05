<?php
include_once("../db.php");

// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["job_title"];
    $description = $_POST["job_description"];
    $qualifications = $_POST["qualifications"];
    $responsibilities = $_POST["responsibilities"];
    $deadline = $_POST["deadline_date"];

    $delimiter="|||";
    $responsibilities=str_replace("\n", $delimiter, $responsibilities);
    $responsibilityList=explode($delimiter, $responsibilities);
    $responsibilityList=array_filter(array_map('trim',$responsibilityList));

    // SQL query to post a job into the database
    $sql = "INSERT INTO jobs (job_title, job_description, qualifications, responsibilities, deadline_date) VALUES ('$title', '$description', '$qualifications', '$responsibilities', '$deadline')";

    if ($conn->query($sql) === TRUE) {
        echo "Job Posted Successfully .....";
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Job Posting page</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
   <link href="assets/img/log.png" rel="icon">
  <link href="assets/img/log.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!--  Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
 <?php
 include_once("header.php");
 ?>

  <!-- ======= Sidebar ======= -->
  <?php
  include_once("sidebar.php");
  ?>

  <main id="main" class="main">

        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Job Posting Form</h5>

              <form class="row g-3" action="" method="post">
                <div class="col-12">
                  <label for="job_title" class="form-label">Job Title</label>
                  <input type="text" class="form-control" id="job_title" name="job_title">
                </div>

                <div class="col-12">
                  <label for="description" class="form-label">Description</label>
                  <textarea class="form-control" id="job_description" name="job_description"></textarea>
                </div>

                <div class="col-12">
                  <label for="qualifications" class="form-label">Qualifications</label>
                  <textarea class="form-control" id="qualifications" name="qualifications"></textarea>
                </div>
                
                <div class="col-12">
                  <label for="responsibilities" class="form-label">Responsibilities</label>
                  <textarea class="form-control" id="responsibilities" name="responsibilities"></textarea>
                </div>

                <div class="col-12">
                  <label for="date">Deadline</label>
                  <input value="2023-24-05" type="date" id="deadline" name="deadline_date" class="form-control">
                    </div>
                  <button type="submit" class="btn btn-success">Post Job</button>
                  
              </form>


            </div>
          </div>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php
  include_once("footer.php");
  ?>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>