<?php
session_start();

// if (isset($_SESSION['username'])) {
//     if ($_SESSION['username'] == $_POST['username']) {
//         header('location:welcome.php');
//         exit;
//     }
// }
require_once "config.php";

$username = $password = "";
$err1 = $err2 = "";
$captcha_err = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $captcha = $_POST['captcha'];
    if (empty(trim($_POST['username']))) {
        $err1 = "Username can't be empty";
        $err1_class = "bg-warning"; 
    }
    if (empty(trim($_POST['password']))) {
        $err2 = "Password can't be empty";
        $err2_class = "bg-warning"; 
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
    }

    if(isset($password) && isset($username))
    {
        if(empty($captcha))
        {
            $captcha_err = "Captcha can't be empty";
            $err3_class = "bg-warning";
        }
        else if($captcha !== $_SESSION['CAPTCHA_CODE'])
        {
            $captcha_err = "Invalid Captcha";
            $err3_class = "bg-warning";
        }
    }
    if (empty($err1) && empty($err2) && empty($captcha_err)) {
        $sql = "SELECT id, username, password FROM user WHERE (username = ? OR Email_id = ?)";
        $stmt = mysqli_prepare($link, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'ss', $param_username, $param_username);
            $param_username = $_POST['username'];
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;
                            header('location: welcome.php');
                        } else {
                            $err2 = "Password doesn't match";
                            $err2_class = "bg-warning"; 
                        }
                    }
                } else {
                    $err1 = "Username not found"; 
                    $err1_class = "bg-warning"; 
                }
            }
        }
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="register.css">
    <title>Login Page</title>
</head>

<body style="background-image: url(images/login.jpg); color:white;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="login.php">Login Page</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="welcome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">Contact us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <style>
        .login_form {
            text-align: center;
            display: inline;
        }
    </style>
    <div class="container">
        <h1>Please Login here:</h1>
        <form class="login_form" action="" method="post">
            <div class="form-group col-md-5">
                <label for="exampleInputusername">Username</label>
                <input type="username" name="username" class="form-control" id="exampleInputusername" aria-describedby="emailHelp" placeholder="Enter username or Email">
                <small id="err1" class="<?php echo $err1_class ?? '' ?>"><?php echo $err1 ?? '' ?></small>
            </div>
            <div class="form-group col-md-5">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                <small id="err2" class="<?php echo $err2_class ?? '' ?>"><?php echo $err2 ?? '' ?></small>
            </div>
            <br>
            <br>
            <br>

            <div class="form-group col-md-5">
                <label for="captcha">Enter Captcha</label>
                <input type="text" name="captcha" id="captcha" class="form-control" placeholder="captcha">
                <small id="err3" class="<?php echo $err3_class ?? '' ?>"><?php echo $captcha_err ?? '' ?></small>
                
            </div>
            <br>
            <div class="form-group col-md-5" >
                <label for="captcha-code">Captcha Code</label>
                <img src="captcha.php" name="captcha-code" id="captcha-code">
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
            &nbsp;&nbsp;
        <input type="reset" id="reset" onclick="resetcaptcha()" class="btn btn-primary">
        &nbsp;
        <a href="forgot.php" class="btn btn-primary ">Forgot Password</a>
        </form>
    </div>
    <script>
        function resetcaptcha() {
            var captchaImage = document.getElementById('captcha-code');
            captchaImage.src = 'captcha.php';
        }
    </script>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
   

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>