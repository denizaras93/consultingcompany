<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $to = "recruiting@deparconsulting.info"; // Change this to the actual email address
    $subject = "New Form Submission";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    $mailBody = "Name: $name\n";
    $mailBody .= "Email: $email\n";
    $mailBody .= "Message:\n$message";

    // Send the email
    mail($to, $subject, $mailBody, $headers);

    // Redirect back to the thank you page or any other page
    header("Location: thank_you.html");
    exit();
}
?>
