<?php

// Simple contact form handler: stores message and emails it to Akhilesh

$conn = new mysqli(
    'sql305.epizy.com',
    'epiz_31926538',
    'm4uJ5Vo3y3Oo',
    'epiz_31926538_regform'
);

if ($conn->connect_error) {
    http_response_code(500);
    echo "Database connection failed";
    exit;
}

// Get and sanitize input
$name = isset($_REQUEST["fullname"]) ? trim($_REQUEST["fullname"]) : "";
$email = isset($_REQUEST["email"]) ? trim($_REQUEST["email"]) : "";
$message = isset($_REQUEST["message"]) ? trim($_REQUEST["message"]) : "";

if ($name === "" || $email === "" || $message === "") {
    http_response_code(400);
    echo "All fields are required.";
    exit;
}

// Store in database
$stmt = $conn->prepare("INSERT INTO tdata(name, email, message) VALUES (?, ?, ?)");

if ($stmt) {
    $stmt->bind_param("sss", $name, $email, $message);
    $stmt->execute();
    $stmt->close();
}

// Send email to Akhilesh
$to = "akhileshdasari2004@gmail.com";
$subject = "New message from portfolio contact form";
$body = "You have received a new message from your portfolio site:\n\n"
      . "Name: " . $name . "\n"
      . "Email: " . $email . "\n\n"
      . "Message:\n" . $message . "\n";

$headers = "From: noreply@yourdomain.com\r\n";
$headers .= "Reply-To: " . $email . "\r\n";

@mail($to, $subject, $body, $headers);

echo "Message sent";

$conn->close();

?>