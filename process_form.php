<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize inputs
    $first_name   = htmlspecialchars(trim($_POST['first_name']));
    $last_name    = htmlspecialchars(trim($_POST['last_name']));
    $phone        = htmlspecialchars(trim($_POST['phone']));
    $email        = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $service_type = htmlspecialchars(trim($_POST['service_type']));
    $message      = htmlspecialchars(trim($_POST['message']));

    // Validate required fields
    if (!$first_name || !$last_name || !$phone || !$email || !$service_type || !$message) {
        echo "Please fill in all fields.";
        exit;
    }

    // Email settings
    $to = "adeseghacyril@gmail.com"; // Change this to your desired recipient
    $subject = "New Contact Form Message from Cold Sylos Website";
    $body = "You received a new message:\n\n" .
            "First Name: $first_name\n" .
            "Last Name: $last_name\n" .
            "Phone: $phone\n" .
            "Email: $email\n" .
            "Service Type: $service_type\n" .
            "Message:\n$message";

    $headers = "From: Cold Sylos Website <no-reply@coldsylos.com>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo "Your message has been sent successfully.";
    } else {
        echo "There was a problem sending your message. Please try again.";
    }
} else {
    echo "Invalid request.";
}
?>
