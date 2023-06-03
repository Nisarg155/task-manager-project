<?php

session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST')
{



// Retrieve the user's ID from the session
$username = $_POST['username'];

// Database connection
$link = mysqli_connect("localhost", "root", "", "login");

// Error variables
$error = "";
$err1 = $err2 = $err3 = $err4 = "";
$err1_class = $err2_class = $err3_class = "";

// Check if the connection is successful
if (!$link) {
    $error = "Unable to connect to the database.";
} else {
    // Prepare and execute SELECT query to retrieve user data
    $sql = "SELECT token,password FROM user WHERE username = ?";
    $stmt = mysqli_prepare($link, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($result);

        // Retrieve password, username, and token from the fetched data
        $password = $data['password'];
        $token1 = $data['token'];
    } else {
        $error = "Unable to prepare the statement.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_POST['token'];

    // Check for empty username and token
    if (empty(trim($username))) {
        $err4 = "Username can't be empty";
        $err4_class = "bg-warning";
    }

    if (empty(trim($token))) {
        $err1 = "Token can't be empty";
        $err1_class = "bg-warning";
    }

    // Check for empty new password
    if (empty(trim($new_password))) {
        $err2 = "New password can't be empty";
        $err2_class = "bg-warning";
    }

    // Check for empty confirm password
    if (empty(trim($confirm_password))) {
        $err3 = "Confirm password can't be empty";
        $err3_class = "bg-warning";
    } elseif ($new_password !== $confirm_password) {
        $err3 = "Confirm password doesn't match";
        $err3_class = "bg-warning";
    }

    // Check if the provided token matches the stored token
    if (strcmp($token1,$token)) {
        $err1 = "Token doesn't match";
        $err1_class = "bg-warning";
    }

    // If no errors occurred, update the password
    if (empty($err1) && empty($err2) && empty($err3)) {
        $link = mysqli_connect("localhost", "root", "", "login");
        if (!$link) {
            $error = "Unable to connect to the database.";
        } else {
            // Prepare and execute UPDATE query to update the password
            $sql = "UPDATE user SET password = ? WHERE username = ?";
            $stmt = mysqli_prepare($link, $sql);
            if ($stmt) {
                $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "ss", $param_password, $username);
                if (mysqli_stmt_execute($stmt)) {
                    // Password updated successfully
                    // Redirect or display a success message
                    header("Location: login.php");
                    exit();
                } else {
                    $error = "Unable to execute the statement.";
                }
            } else {
                $error = "Unable to prepare the statement.";
            }

            mysqli_stmt_close($stmt);
            mysqli_close($link);
        }
    }
}

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="forgot.css">
</head>

<body style="background-image: url(images/login.jpg); color:white;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="welcome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="account-details">
            <form action="" method="POST">
                <div class="account-info">
                    <label style="margin-left: -170px;" id="info-label" for="username">Username</label>
                    <input style="margin-bottom:5px;" id="username" name="username" type="text" class="info_input" placeholder="Enter username">
                    <small id="err4" class="<?php echo $err4_class ?? ''; ?>"><?php echo $err4 ?? ''; ?></small>

                    <label style="margin-left: -200px;" id="info-label" for="token">Token</label>
                    <input style="margin-bottom:5px;" id="token" name="token" type="text" class="info_input" placeholder="Enter token">
                    <small id="err1" class="<?php echo $err1_class ?? ''; ?>"><?php echo $err1 ?? ''; ?></small>

                    <label style="margin-left: -140px;" id="info-label" for="new_password">New Password</label>
                    <input style="margin-bottom:5px;" id="new_password" name="new_password" type="password" class="info_input" placeholder="New Password">
                    <small id="err2" class="<?php echo $err2_class ?? ''; ?>"><?php echo $err2 ?? ''; ?></small>

                    <label style="margin-left:-80px;" id="info-label" for="confirm_password">Confirm New Password</label>
                    <input id="confirm_password" name="confirm_password" type="password" class="info_input" placeholder="Confirm Password">
                    <small id="err3" class="<?php echo $err3_class ?? ''; ?>"><?php echo $err3 ?? ''; ?></small><br>

                    <button id="update_button" class="update_button">Reset</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
