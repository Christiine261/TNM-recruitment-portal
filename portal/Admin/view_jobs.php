<?php
// Database connection parameters

require_once("../db.php");

// Fetch job data from the database
$query = "SELECT job_id, job_title, job_description, qualifications, responsibilities, deadline_date FROM jobs";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>View Jobs</title>
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

  <!-- Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
    
    <!-- Add your CSS link here -->
    <link href="assets/css/view_jobs.css" rel="stylesheet">
</head>

<body>

    <?php
    //header
     require_once("header.php");
    ?>

    <?php

    // side bar
    require_once("sidebar.php");
    ?>

 <main id="main" class="main">

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="job-post">';
        echo "<h2>{$row['job_title']}</h2>";

        echo "<p><strong>Description</strong></p>";
        $job_description = explode("\n", $row['job_description']);
        echo "<ul>";
         foreach($job_description as $description) {
             echo "<li> {$description} </li>";
         }
         echo "</ul>";

        echo "<p><strong>Qualification:</strong></p>";
        $qualifications = explode("\n", $row['qualifications']);
        echo "<ul>";
         foreach($qualifications as $qualification) {
             echo "<li> {$qualification} </li>";
         }
         echo "</ul>";


         echo "<p><strong>Responsibilities:</strong></p>";
         $responsibilities = explode("\n", $row['responsibilities']);
         echo "<ul>";
          foreach($responsibilities as $responsibility) {
              echo "<li> {$responsibility} </li>";
          }
          echo "</ul>";
 

       /*  echo "<p><strong>Responsibilities:</strong></p>";
       $responsibilities = explode("\n", $row['responsibilities']);
       echo "<ul>";
        foreach($responsibilities as $responsibility) {
            echo "<li> {$responsibility} </li>";

        }
        echo "</ul>";
 */
        echo "<p><strong>Deadline:</strong></p>";
        echo "<p>{$row['deadline_date']}</p>";
        echo '<p><a href="edit_job.php?id=' . $row['job_id'] . '">Edit</a> | <a href="delete_job.php?id=' . $row['job_id'] . '">Delete</a></p>';
        echo '</div>';
    }
} else {
    echo "No job posts found.";
}

$conn->close();
?>

 </main>

 <?php
 //footer
  require_once("footer.php");
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
