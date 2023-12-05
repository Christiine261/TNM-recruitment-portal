<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Jobs Available</title>
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
  <link href="css/job_apply.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <a href="index.php" class="logo me-auto"><img src="assets/img/tnm-logo.png" alt="" class="img-fluid"></a>
      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
        <?php 
        $currentPage = 'jobs';
        include_once("navbar.php");?>
          

          <?php
                // Check for user authentication
                session_start();
                
                if (isset($_SESSION['user_email'])) {
                    // User is logged in
                    $user_email = $_SESSION['user_email'];
                    echo '<li class="dropdown">';
                    echo '    <a href="#" class="dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $user_email . '</a>';
                    echo '    <div class="dropdown-menu" aria-labelledby="userDropdown">';
                    echo '        <a class="dropdown-item" href="#">View/Edit Profile</a>';
                    echo '        <a class="dropdown-item" href="logout.php">Logout</a>';
                    echo '    </div>';
                    echo '</li>';
                } else {
                    // User is not logged in
                    echo '<a href="login.php" class="get-started-btn">Login</a> ';
                }
          ?>
      </nav>

    </div>
  </header><!-- End Header -->

  
  <!-- Main Content Section -->
  <main id="main" data-aos="fade-in">
    <!-- Breadcrumbs and container_jobs div -->
    <div class="breadcrumbs" data-aos="fade-in">
      <div class="container">
        <h2>Jobs</h2>
        <p>Available jobs</p>
      </div>
    </div><!-- End Breadcrumbs -->
    <div class="container_jobs">
      <!-- Section displaying all available jobs -->
      <section id="all-jobs" class="job-section">
        <?php
          require_once("db.php");

          // Fetch and display all available jobs
          $query = "SELECT job_id, job_title, deadline_date FROM jobs";
          $result = $conn->query($query);
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '<div class="job-post" data-job-id="' . $row['job_id'] . '">';
              echo "<h4>{$row['job_title']}</h4>";
              echo "<p>Deadline:</p>";
              echo "<p>{$row['deadline_date']}</p>";
              echo "<hr>";
              echo '</div>';
            }
          } else {
            echo "No job posts found.";
          }
          $conn->close();
        ?>
      </section>

      <!-- Section displaying job details and apply button -->
      <section id="job-details" class="job-section hidden">
      <button id="close-button">&#10006;</button>
      
        <div id="job-details-content">
          <!-- Job details will be dynamically populated here -->
        </div>
        <button id="apply-button">Apply now</button>
       
      </section>
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
  <script src="jobs.js" defer></script>

  <!-- app pop up -->
<div id="overlay"></div>

<div id="apply-options-popup" class="popup">
  <div class="popup-content">
    <button id="close-button-popup" class="close-button">&#10006;</button>
    <button id="apply-manually">Apply Manually</button>
    <form id="manual-application-form" style="display: none;">
                    <div class="form_control">
                        <label for="first_name">Fullname</label>
                        <input type="text" id="fullname" name="fullname" placeholder="Enter fullname.." required>
                    </div>


                    <div class="form_control">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter Email.." required>
                    </div>


                    <div class="textarea_control">
                        <label for="address">Physical address</label>
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
      <input type="submit" value="Submit">
    </form>

    <button id="apply-with-cv">Apply with CV</button>
    <button id="use-previous-application">Use Previous Application</button>
  </div>
</div>


</body>

</html>