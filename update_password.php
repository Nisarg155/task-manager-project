<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $email = $_GET["email"];
    $token = $_GET["token"];

    // Validate email and token
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-f0-9]{32}$/', $token)) {
        echo "Invalid email or token.";
        exit;
    }

    // Check if the email and token exist in the database
    $stmt = $link->prepare("SELECT id FROM user WHERE Email_id = ? AND token = ?");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Display the password reset form
        echo <<<HTML
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>
</head>

<body>
    <h1>Reset Password</h1>
    <form action="reset_password.php" method="post">
        <input type="hidden" name="email" value="$email">
        <input type="hidden" name="token" value="$token">
        <label for="password">New Password:</label>
        <input type="password" name="password" required>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required>
        <button type="submit">Reset</button>
    </form>
</body>

</html>
HTML;
    } else {
        echo "Invalid email or token.";
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $token = $_POST["token"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validate email and token
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[a-f0-9]{32}$/', $token)) {
        echo "Invalid email or token.";
        exit;
    }

    // Validate password
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit;
    }

    // Hash the new password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update the password in the database
    $stmt = $link->prepare("UPDATE user SET Password = ? WHERE Email_id = ? AND token = ?");
    $stmt->bind_param("sss", $hashed_password, $email, $token);
    $stmt->execute();

    if ($stmt->affected_rows == 1) {
        echo "Password reset successfully. You can now login with your new password.";
    } else {
        echo "Password reset failed. Please try again.";
    }
}
?>
