<?php
/* session_start();

// Check if the user is already logged in, and redirect if so
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli('localhost', 'root', '', 'tnm_portal');
    if ($conn->connect_error) {
        die('connection failed :' . $conn->connect_error);
    } else {
        $stmt = $conn->prepare("SELECT* FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt_result = $stmt->get_result();


        if ($stmt_result->num_rows > 0) {
            $data = $stmt_result->fetch_assoc();

            if (password_verify($password, $data['password'])) {
                echo "<script>alert('You are Logged into the system')</script>";

                // Set the user_id in the session
                $_SESSION['user_id'] = $data['user_id'];

                if ($email === 'admin@tnm.co.mw') {
                    // Redirect admin to the admin dashboard
                    echo "<script>window.open('admin/index.php?','_self')</script>";
                } else {
                    // Redirect regular users to the regular dashboard or homepage
                    echo "<script>window.location.href = 'index.php';</script>";
                }
            } else {
                echo "<h2> Invalid Email or Password </h2>";
            }
        } else {
            echo "<h2> Invalid Email or Password </h2>";
        }
    }
} */

?>
<?php
session_start();
include_once("db.php");

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
  $email = $_POST["email"];
  $password = $_POST["password"];

  // Retrieve hashed password from the database based on the provided email
  $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
  $result = $conn->query($checkEmailQuery);

  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $hashed_password = $row['password'];

      // Verify the entered password against the hashed password from the database
      if (password_verify($password, $hashed_password)) {
          // Password is correct, set user session and redirect
          $_SESSION['user_email'] = $email;
          $_SESSION['user_id'] = $row['user_id'];

          // Check if the email is admin's email
          if ($email == 'admin@tnm.co.mw') {
              echo "<script>window.location.href = 'admin/index.php';</script>";
          } else {
              echo "<script>window.location.href = 'index.php';</script>";
          }
      } else {
          // Password verification failed
          echo "Password verification failed. Invalid Email or Password.";
      }
  } else {
      // User with the provided email doesn't exist
      echo "User with this email does not exist.";
  }
}


// Close the connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TNM</title>
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

</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <span class="d-none d-lg-block">User Login</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your email & password to login</p>
                  </div>

                  <form class="row g-3 needs-validation" method="post"  action="" novalidate>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <input type="email" name="email" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your email.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-success w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="medium mb-0">Don't have account? <a href="register_form.php">Create an account</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                
              <a href="https://tnm.co.mw/">TNM</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

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

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>