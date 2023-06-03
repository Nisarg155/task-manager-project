<?php

session_start();

$id = $_SESSION['id'];


$password = "";
$link = mysqli_connect("localhost", "root", "", "login");
$error = "";
$err1 = $err2 = $err3 = "";

if ($link) {
    $sql = "SELECT * FROM user WHERE id = ?";
    $stmt = mysqli_prepare($link, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if ($stmt) {
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($result);
            $password = $data['password'];
        } else {
            $error = "unable to bind parametre";
        }
    } else {
        $error = "unable to prepare parametre";
    }
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    if (empty(trim($_POST['current_password']))) {
        $err1 = "Passwort can't be empty ";
        $err1_class = "bg-warning";
    } else {
        $sql = "SELECT password FROM user WHERE id = ?";
        $stmt = mysqli_prepare($link, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            if (mysqli_stmt_execute($stmt)) {
                if (!password_verify($_POST['current_password'], $password)) {
                    $err1 = "Invalid password";
                    $err1_class = "bg-warning";
                }
            } else {
                $error = "unable to execute the query";
            }
        } else {
            $error = "unable to prepare the prepare the parameter";
        }

        mysqli_stmt_close($stmt);

    }



    if (empty(trim($new_password))) {
        $err2 = "New Password can't be empty";
        $err2_class = "bg-warning";
    } elseif (password_verify($new_password, $password)) {
        $err2 = "New Password can't be same as Old";
        $err2_class = "bg-warning";
    }


    if (empty(trim($confirm_password))) {
        $err3 = "Confirm password can't be empty";
        $err3_class = "bg-warning";
    } elseif (password_verify($confirm_password, $password)) {
        $err3 = "Confirm password can't be same as old password";
    }



    if (empty($err1) && empty($err2) && empty($err3)) {
        if ($new_password === $confirm_password) {
            $sql = "UPDATE user  SET password = ?   WHERE id = ?";
            $stmt = mysqli_prepare($link,$sql);
            if($stmt)
            {
                mysqli_stmt_bind_param($stmt,"si",$param_password,$id);
                $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                if(!mysqli_stmt_execute($stmt))
                {
                    $error = "unable to execute the statement ";
                }
            }
            else{
                $error = "unable to prepare statement";
            }
        } else {
            $err2 = $err3 = "Password does not matches";
            $err2_class = $err3_class = "bg-warning";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($link);
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
    <link rel="stylesheet" href="passworddetails.css">
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

            <div class="topright">
                <a href=""><img src="images/user.png" style="height:30px"></a>
                <a href=""><?php echo "Welcome " . $_SESSION['username'] ?></a>
            </div>
        </div>
    </nav>



    <div class="container">
            <form action="" method="POST">

                <div class="account-info">
                    <lable style="margin-left: -80px;" id="info-lable" for="current_password">Current Password</lable>
                    <input style="margin-bottom:5px;" id="current_password" name="current_password" type="text" class="info_input" placeholder="Current Password">
                    <small id="err1" class="<?php echo $err1_class ?? '' ?>"><?php echo $err1 ?? '' ?></small>



                    <lable style="margin-left: -100px;" id="info-lable" for="new_password">New Password</lable>
                    <input style="margin-bottom:5px;" id="new_password" name="new_password" type="text" class="info_input" placeholder="New Password">
                    <small id="err2" class="<?php echo $err2_class ?? '' ?>"><?php echo $err2 ?? '' ?></small>


                    <lable style="margin-left:-20px;" id="info-lable" for="Email">Confirm New Password</lable>
                    <input id="confirm_password" name="confirm_password" type="text" class="info_input" placeholder="Confirm Password">
                    <small id="err2" class="<?php echo $err3_class ?? '' ?>"><?php echo $err3 ?? '' ?></small><br>


                    <button id="update_button" class="update_button">Update</button>

                    <br>
                    <a href="logindetails.php" id="update_profile">Update Profile</a>
                </div>
            </form>
    </div>
</body>

</html>