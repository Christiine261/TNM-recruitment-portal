<?php
// Include your database connection code or configuration here
require_once("../db.php"); // Adjust the path as needed

// Check if a job ID is provided in the query string
if (isset($_GET["id"])) {
    $job_id = $_GET["id"];

    // Check if the form is submitted to update the job post
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $job_title = $_POST["job_title"];
        $job_description = $_POST["job_description"];
        $qualifications = $_POST["qualifications"];
        $responsibilities = $_POST["responsibilities"];
        $deadline_date = $_POST["deadline_date"];

        // Update the job post in the database
        $query = "UPDATE jobs SET job_title = ?, job_description = ?, qualifications = ?, responsibilities = ?, deadline_date = ? WHERE job_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssi", $job_title, $job_description, $qualifications, $responsibilities, $deadline_date, $job_id);

        if ($stmt->execute()) {
            // Job post updated successfully, redirect to view_jobs.php or another appropriate page
            header("Location: view_jobs.php"); // Adjust the redirection URL
            exit();
        } else {
            echo "Error updating job post: " . $conn->error;
        }
    }

    // Fetch the job post data for editing
    $query = "SELECT * FROM jobs WHERE job_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Job post not found.";
        exit();
    }
} else {
    echo "Job ID not provided.";
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TNM ADMIN-AREA</title>
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
    <link href="assets/css/edit_job.css" rel="stylesheet">

    <style type="text/css">
        form {
    max-width: 500px;
    margin: 0 auto;
    padding: 20px;
    border: 2px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
    font-family: Arial, sans-serif;
}

/* Style form labels */
label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

/* Style form input fields */
input[type="text"],
input[type="date"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

/* Style form textarea fields */
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

/* Style the submit button */
input[type="submit"] {
    background-color: green;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}

/* Style the submit button on hover */
input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Center the form heading */
h1 {
    text-align: center;
}
    </style>
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

    <h1>Edit Job Post</h1>
    <form method="POST" action="">
        <label for="job_title">Job Title:</label>
        <input type="text" name="job_title" id="job_title" value="<?php echo $row['job_title']; ?>" required>

        <label for="job_description">Job Description:</label>
        <textarea name="job_description" id="job_description" required><?php echo $row['job_description']; ?></textarea>

        <label for="qualifications">Qualifications:</label>
        <textarea name="qualifications" id="qualifications" required><?php echo $row['qualifications']; ?></textarea>

        <label for="responsibilities">Responsibilities:</label>
        <textarea name="responsibilities" id="responsibilities" required><?php echo $row['responsibilities']; ?></textarea>

        <label for="deadline_date">Deadline Date:</label>
        <input type="date" name="deadline_date" id="deadline_date" value="<?php echo $row['deadline_date']; ?>" required>

        <input type="submit" value="Update Job Post">
    </form>

    </main><!-- End #main -->

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
