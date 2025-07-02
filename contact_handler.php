<?php
// This script processes the contact form submission.

// --- CONFIGURATION ---
// Set the recipient email address.
// IMPORTANT: This is where the form submissions will be sent.
$recipient_email = "adeseghacyril@gmail.com"; // Replace with your email address

// Set the email subject for received messages.
$subject = "New Contact Form Submission from Cold Sylos Website";

// Set the URL for the "Thank You" page.
$thank_you_page_url = "thank-you.html"; // You should create this page.

// --- SCRIPT LOGIC ---

// Check if the form was submitted using the POST method.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Sanitize and retrieve form data
    // The filter_var function helps prevent malicious code injection.
    $firstName = isset($_POST['firstName']) ? filter_var(strip_tags(trim($_POST['firstName'])), FILTER_SANITIZE_STRING) : 'Not provided';
    $lastName = isset($_POST['lastName']) ? filter_var(strip_tags(trim($_POST['lastName'])), FILTER_SANITIZE_STRING) : 'Not provided';
    $phone = isset($_POST['phone']) ? filter_var(strip_tags(trim($_POST['phone'])), FILTER_SANITIZE_STRING) : 'Not provided';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $serviceType = isset($_POST['serviceType']) ? filter_var(strip_tags(trim($_POST['serviceType'])), FILTER_SANITIZE_STRING) : 'Not provided';
    $message = isset($_POST['message']) ? filter_var(strip_tags(trim($_POST['message'])), FILTER_SANITIZE_STRING) : 'Not provided';

    // 2. Validate required fields
    if (empty($firstName) || empty($lastName) || empty($phone) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
        // If validation fails, send an error response and stop the script.
        http_response_code(400);
        echo "There was a problem with your submission. Please complete all fields and try again.";
        exit;
    }

    // 3. Construct the email body
    // This is the content that will be in the email you receive.
    $email_content = "You have received a new message from your website contact form.\n\n";
    $email_content .= "Here are the details:\n\n";
    $email_content .= "First Name: $firstName\n";
    $email_content .= "Last Name: $lastName\n";
    $email_content .= "Phone: $phone\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Service Type: $serviceType\n\n";
    $email_content .= "Message:\n$message\n";

    // 4. Construct the email headers
    // This tells the email client who the email is from.
    $email_headers = "From: $firstName $lastName <$email>";

    // 5. Send the email
    // The mail() function is a built-in PHP function.
    // Note: For this to work, your web server must be configured to send emails.
    if (mail($recipient_email, $subject, $email_content, $email_headers)) {
        // If the email is sent successfully, redirect to the thank you page.
        header("Location: " . $thank_you_page_url);
        exit;
    } else {
        // If the email fails to send, return a server error.
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }

} else {
    // If the script is accessed directly without a POST request, show an error.
    http_response_code(403);
    echo "There was a problem with your submission. Please try again.";
}
?>
