<?php
// code to send contact to both client and the owner
if(isset($_POST['submit'])) {
  $mailto = "logahstankey@gmail.com"; //owner email address
  $from = $_POST['email']; // client address
  $name = $_POST['name']; 
  $subject = $_POST['subject'];
  $subject2 = "Your message sent successfully"; // this is for the client 
  $message = "Client Name: " . $name . " wrote the following" . "\n\n" . $_POST['message'];
  $message2 = "Dear " . $name . "\n\n" . "Thank you for contacting us! We'll get back to you shortly.";
  $headers = "From: " . $from; // user entered email address
  $headers2 = "From: " . $mailto; // will be received by the client
  $result = mail($mailto, $subject, $message, $headers); // send email to website owner
  $result2 = mail($from, $subject2, $message2, $headers2); // send email to the user

  if($result) {
    echo '<script type="text/javascript">alert("Message was sent successfully, we will contact you shortly!");</script>';
  } else {
    echo '<script type="text/javascript">alert("Submission failed, try again later.");</script>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Contact</title>
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

  <!-- =======================================================
  * Template Name: Mentor - v4.9.1
  * Template URL: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

     <!--  <h1 class="logo me-auto"><a href="index.html">Mentor</a></h1> -->
      <!-- Uncomment below if you prefer to use an image logo -->
      <a href="index.php" class="logo me-auto"><img src="assets/img/tnm-logo.png" alt="" class="img-fluid"></a>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
        <?php 
        $currentPage = 'contact';
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
                    echo '<a href="login.php" class="login-btn"><i class="bi bi-person"></i> Login</a>';
                }
            ?>
        </nav>
    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs" data-aos="fade-in">
      <div class="container">
        <h2>Contact Us</h2>
        <p></p>
      </div>
    </div><!-- End Breadcrumbs -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div data-aos="fade-up">
       <!--  <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen></iframe> -->
        <iframe style="border:0; width: 100%; height: 350px;"  src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d15357.388462821757!2d35.0072431!3d-15.7856407!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2smw!4v1691359285622!5m2!1sen!2smw" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

      </div>

      <div class="container" data-aos="fade-up">

        <div class="row mt-5">

          <div class="col-lg-4">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Location:</h4>
                <p>5th floor, livingstone Towers, Glyn Jones Road, P.O Box 3039, Blantyre, Malawi</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>info@example.com</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p>+265 888 800 800 </p>
              </div>

            </div>

          </div>

          <div class="col-lg-8 mt-5 mt-lg-0">

            <!-- <form action="" method="post" role="form" class="php-email-form"> -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" role="form" class="php-email-form">

              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit" name="submit">Send Message</button></div>
            </form>

          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

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