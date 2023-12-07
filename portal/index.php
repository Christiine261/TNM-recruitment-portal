<?php
/* session_start();

// Check if the user is not logged in, and redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
 */
// You can fetch additional user information from the database if needed
// For example, if you have user details like name in the database:
// $user_id = $_SESSION['user_id'];
// $user_info = fetchUserInfoFromDatabase($user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TNM JOB RECRUITMENT PORTAL</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/log.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

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
  <link href="css/job_apply.css" rel="stylesheet">


</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

       <a href="index.php" class="logo me-auto"><img src="assets/img/tnm-logo.png" alt="my image" class="img-fluid"></a>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <?php 
          $currentPage = 'home';
          include_once("navbar.php");
          ?>
              <?php
                // Check for user authentication
                session_start();
                
                if (isset($_SESSION['user_email'])) {
                    // User is logged in
                    $user_email = $_SESSION['user_email'];
                    echo '<li class="dropdown">';
                    echo '    <a href="#" class="dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $user_email . '</a>';
                    echo '    <div class="dropdown-menu" aria-labelledby="userDropdown">';
                    echo '        <a class="dropdown-item" href="portfolio_page.php">View/edit Profile</a>';
                    echo '        <a class="dropdown-item" href="logout.php">Logout</a>';
                    echo '    </div>';
                    echo '</li>';
                } else {
                    // User is not logged in
                    echo '<a href="login.php" class="login-btn"><i class="bi bi-person"></i> Login</a>';
                }
              ?>

      </nav><!-- .navbar -->

      
 
    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex justify-content-center align-items-center">
    <div class="container position-relative" data-aos="zoom-in" data-aos-delay="100">
      <h1>Welcome to TNM ,<br>Recruitment Portal</h1>
      <h2>Where talent meets opportunity</h2>
      <a href="jobs.php" class="btn-get-started">Apply now</a>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <?php include_once("about_section.php") ?>

    
<section id="popular-courses" class="courses">
  <div class="container" data-aos="fade-up">
    <div class="section-title">
      <h2>Jobs</h2>
      <p>Available Jobs</p>
    </div>
  </div>

  <?php
  require_once("db.php");

  // Fetch job data from the database
  $query = "SELECT job_id, job_title, deadline_date FROM jobs";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    echo '<div class="container">'; // Container for the table
    echo '<table class="job-table">'; // Add a class for styling

    // Table header
    echo '<thead>';
    echo '<tr>';
    echo '<th><h3>Job Title</h3></th>';
    echo '<th><h3>Deadline</h3></th>';
    echo '<th><h3>Job description</h3></th>';
    echo '</tr>';
    echo '</thead>';

    // Table body
    echo '<tbody>';

    // Loop through each row and display job information
    //<p><strong>Deadline:</strong></p
    while ($row = $result->fetch_assoc()) {
      echo '<tr>';
      echo '<td><h4>' . $row['job_title'] . '</h4></td>';
      echo '<td><p>' . $row['deadline_date'] . '</p></td>';
      echo '<td><p><a href="jobs.php?id=' . $row['job_id'] . '">View</a></p></td>';
      echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>'; // Close the container for the table
  } else {
    echo "No job posts found.";
  }

  $conn->close();
  ?>
</section>



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