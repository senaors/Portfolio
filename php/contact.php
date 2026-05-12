<?php
// php/contact.php — Saves contact message to DB
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

require_once __DIR__ . '/db.php';

// Sanitize inputs
function clean(string $val): string {
    return htmlspecialchars(trim($val), ENT_QUOTES, 'UTF-8');
}

$fname   = clean($_POST['fname']   ?? '');
$lname   = clean($_POST['lname']   ?? '');
$email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$subject = clean($_POST['subject'] ?? '');
$message = clean($_POST['message'] ?? '');

// Server-side validation
$errors = [];
if (empty($fname))   $errors[] = 'First name is required.';
if (empty($lname))   $errors[] = 'Last name is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
if (empty($subject)) $errors[] = 'Subject is required.';
if (strlen($message) < 10) $errors[] = 'Message must be at least 10 characters.';

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

$db = getDB();
$stmt = $db->prepare(
    "INSERT INTO contacts (first_name, last_name, email, subject, message, created_at)
     VALUES (?, ?, ?, ?, ?, NOW())"
);
$stmt->bind_param('sssss', $fname, $lname, $email, $subject, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Message sent! I\'ll get back to you soon.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Could not save your message. Please try again.']);
}

$stmt->close();
