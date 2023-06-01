<?php

session_start();

$id = $_SESSION['id'];


$username = $email = "";
$link = mysqli_connect("localhost", "root", "", "login");
$error = "";
$err1 = $err2 = "";

if ($link) {
    $sql = "SELECT * FROM user WHERE id = ?";
    $stmt = mysqli_prepare($link, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if ($stmt) {
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);
            $data = mysqli_fetch_assoc($result);
            $username = $data['username'];
            $email = $data['Email_id'];
            $password = $data['password'];
        } else {
            $error = "unable to bind parametre";
        }
    } else {
        $error = "unable to prepare parametre";
    }
}



if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(empty(trim($_POST['username'])))
    {
        $err1 = "USERNAME can't be empty ";
        $err1_class = "bg-warning";
    }
    elseif($_POST['username'] === $username){

    }
    else{
        $sql = "SELECT id FROM user WHERE username = ?";
        $stmt = mysqli_prepare($link,$sql);

        if($stmt)
        {
            mysqli_stmt_bind_param($stmt,"s",$param_username);
            $param_username = trim($_POST['username']);
            if(mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $err1 = "username already exist!!!! ";
                    $err1_class = "bg-warning";
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                $error  = "unable to execute the query";
            }
        }
        else{
            $error = "unable to prepare statment ";
        }


    }
    if(empty(trim($_POST['Email'])))
    {
        $err2 = "Email can'T be empty ";
        $err2_class = "bg-warning";
    }
    elseif($_POST['Email'] === $email){

    }
    else{
        $sql = "SELECT id FROM user WHERE Email_id = ?";
        $stmt = mysqli_prepare($link,$sql);

        if($stmt)
        {
            mysqli_stmt_bind_param($stmt,"s",$param_email);
            $param_email = $_POST['Email'];
            if(mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $err2 = "Email already taken !!!!!";
                    $err2_class = "bg-warning";
                }
                else{
                    $email = $_POST['Email'];
                }
            }
            else{
                $error = "unable to execute the query";
            }

        }
        else{
            $error = "unable to prepare statement ";
        }
    }

    if(empty($err1) && empty($err2))
    {

        
        $sql = "UPDATE user SET Email_id = ? ,  username = ?  WHERE id = ?";
        $stmt = mysqli_prepare($link,$sql);

        if($stmt)
        {
            mysqli_stmt_bind_param($stmt,"ssi",$email,$username,$id);
            if($stmt)
            {
                if(!mysqli_stmt_execute($stmt))
                {
                    $error = "unable to execute the query";
                }
                else{
                    $_SESSION['username'] = $username;
                }
                
            }
            else{
                $error = "unable to bind parametre";
            }
        }
        else{
            $error = "unable to prepare the query";
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
    <title>Login Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="logindetails.css">
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
        <div class="account-details">
            <div class="account-profile">

            </div>
            <form action="" method="POST">

                <div class="account-info">
                    <lable id="info-lable" for="username">Username</lable>
                    <input id="username" name="username" type="text" class="info_input" value="<?php echo $username ?>">
                    <small id="err1" class="<?php echo $err1_class ?? '' ?>"><?php echo $err1 ?? '' ?></small>
                    <br>
                    <lable id="info-lable" for="Email">Email Id</lable>
                    <input id="Email" name="Email" type="email" class="info_input" value="<?php echo $email ?>">
                    <small id="err2" class="<?php echo $err2_class ?? '' ?>"><?php echo $err2 ?? '' ?></small><br>
                    <button id="update_button">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>