<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $highestEducation = $_POST['highest_education'];
    $address = $_POST['address'];
    $additionalInfo = $_POST['message'];

    // Establish connection to the database
    $servername = "127.0.0.1";
    $username = "depa6723_deparconsulting";
    $password = "Prashant.1";
    $dbname = "depa6723_deparconsulting";

    // Create a new mysqli connection with error handling
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind the INSERT statement
    $stmt = $conn->prepare("INSERT INTO applicantdata (full_name, email, phone, highest_education, address, additional_info, resume_filename) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    // Check if the statement is prepared successfully
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("sssssss", $fullName, $email, $phone, $highestEducation, $address, $additionalInfo, $resumeFileName);

    // Handle file upload separately
    $uploadDirectory = "uploads/";

    // Check if a file was uploaded
    if (isset($_FILES["resume"])) {
        $uploadedFileName = $_FILES["resume"]["name"];
        $targetFile = $uploadDirectory . basename($uploadedFileName);

        // Set the resume filename for the database
        $resumeFileName = $uploadedFileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["resume"]["tmp_name"], $targetFile)) {
            // File uploaded successfully, execute the database insert
            if ($stmt->execute()) {
                echo "Thank you. Application submitted successfully. The file " . $uploadedFileName . " has been sent.";
            } else {
                echo "Error inserting data into the database: " . $stmt->error;
            }
        } else {
            // Error uploading file
            echo "Error uploading file.";
        }
    } else {
        // No file uploaded
        echo "No file uploaded.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
