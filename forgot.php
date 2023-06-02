<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Check if the email exists in the database
    $stmt = $link->prepare("SELECT id FROM user WHERE Email_id = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // Generate a random token
        $token = bin2hex(random_bytes(32));

        // Store the token in the database for the user
        $stmt = $link->prepare("UPDATE user SET reset_token = ? WHERE Email_id = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        // Send the password reset email
        $resetLink = "http://example.com/reset_password.php?email=" . urlencode($email) . "&token=" . urlencode($token);

        // Use PHPMailer to send the email
        require 'PHPMailer/PHPMailer.php';
        require 'PHPMailer/SMTP.php';
        require 'PHPMailer/Exception.php';

        $mail = new PHPMailer(true);
        $mail->CharSet = "utf-8";
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->Username = "arshgangani18@gmail.com";
        $mail->Password = "xvxkourlzfqwzytc";
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->isHTML(true);
        $mail->setFrom('arshgangani18@gmail.com', 'Arsh');
        $mail->addAddress($email);
        $mail->Subject = 'Reset Password';
        $mail->Body = 'Click on the link below to reset your password: <a href="' . $resetLink . '">' . $resetLink . '</a>';

        try {
            if ($mail->send()) {
                echo "Check your email for the password reset link.";
            } else {
                echo "Unable to send the password reset email. Please try again later.";
            }
        } catch (Exception $e) {
            echo "An error occurred: " . $e->getMessage();
        }
    } else {
        echo "Email not found.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
</head>

<body>
    <h1>Forgot Password</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Reset Password</button>
    </form>
</body>

</html>
