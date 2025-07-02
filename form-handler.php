<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $firstName = htmlspecialchars(trim($_POST["first_name"]));
    $lastName = htmlspecialchars(trim($_POST["last_name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $serviceType = htmlspecialchars(trim($_POST["service_type"]));
    $message = htmlspecialchars(trim($_POST["message"]));
    $saveInfo = isset($_POST["saveinfo"]) ? "Yes" : "No";

    // Email settings
    $to = "info@coldsylos.com"; // Replace with your email
    $subject = "New Contact Form Submission from Cold Sylos";
    $headers = "From: Cold Sylos Website <no-reply@coldsylos.com>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $emailBody = "You received a new message:\n\n";
    $emailBody .= "Name: $firstName $lastName\n";
    $emailBody .= "Email: $email\n";
    $emailBody .= "Service Type: $serviceType\n";
    $emailBody .= "Message:\n$message\n\n";
    $emailBody .= "Save Info: $saveInfo\n";

    // Send the email
    if (mail($to, $subject, $emailBody, $headers)) {
        echo "Thank you for contacting us! We'll get back to you soon.";
    } else {
        echo "Oops! Something went wrong. Please try again.";
    }
} else {
    // If someone accesses this page directly
    header("Location: 404.html");
    exit;
}
