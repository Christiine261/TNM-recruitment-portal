<?php
session_start();

// Check if the user is logged in
/* if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
} */

// Include your database connection file
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    $full_name = $_POST['full_name'] ?? '';
    $skills = $_POST['skills'] ?? '';
    $education = $_POST['education'] ?? '';
    $work_experience = $_POST['work_experience'] ?? '';
    $project_name = $_POST['project_name'] ?? '';
    $project_description = $_POST['project_description'] ?? '';
    $files = $_FILES['files'] ?? null;

    // Print debug information
    echo '<pre>';
    print_r($files);
    echo '</pre>';

    // Check if the file was uploaded successfully
    if ($files && isset($files['error']) && $files['error'] === 0) {
        // Upload files
        $FileName = $files["name"] ?? '';
        $fileTempName = $files["tmp_name"] ?? '';
        $TargetDir = "uploads/documents/";
        $fileTargetFile = $TargetDir . $FileName;

        // Print additional debug information
        echo "File Name: $FileName<br>";
        echo "Temporary File Name: $fileTempName<br>";

        if (move_uploaded_file($fileTempName, $fileTargetFile)) {
            // Insert portfolio data into the database
            $query = "INSERT INTO portfolios (user_id, full_name, skills, education, work_experience, project_name, project_description, files) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = mysqli_prepare($conn, $query);
            
            mysqli_stmt_bind_param($stmt, 'isssssss', $user_id, $full_name, $skills, $education, $work_experience, $project_name, $project_description, $fileTargetFile);
            
            if (mysqli_stmt_execute($stmt)) {
                // Success
                header('Location: view_portfolio.php');
                exit();
            } else {
                // Error
                echo "Error: " . mysqli_stmt_error($stmt);
            }
            
            mysqli_stmt_close($stmt);

        } else {
            echo "File failed to upload";
        }
    } else {
        // Print error code for further debugging
        echo "File Upload Error Code: " . ($files['error'] ?? 'Unknown error');
        switch ($files['error'] ?? null) {
            case 1:
                echo " - The uploaded file exceeds the upload_max_filesize directive in php.ini";
                break;
            case 2:
                echo " - The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case 3:
                echo " - The uploaded file was only partially uploaded";
                break;
            case 4:
                echo " - No file was uploaded";
                break;
            case 6:
                echo " - Missing a temporary folder";
                break;
            case 7:
                echo " - Failed to write file to disk";
                break;
            case 8:
                echo " - A PHP extension stopped the file upload";
                break;
        }
    }
}
?>