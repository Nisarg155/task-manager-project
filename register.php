<?php

require_once "config.php";

$Email_id = $username = $password  = $confirm_password = "";
$Email_id_err = $username_err = $password_err  = $confirm_password_err = $phone_no_err = $country_err = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST')    //todo CHECK THE USERNAME
{

    //* CHECK EMAIL
    if (empty(trim($_POST['Email_id']))) {
        $Email_id_err = "Email can't be empty ";
        $Email_id_class = "bg-warning";
    } else {
        $sql = "SELECT id FROM user WHERE Email_id = ? ";
        $stmt = mysqli_prepare($link, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_Email_id);
            $param_Email_id = trim($_POST['Email_id']);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $Email_id_err = "Email is already taken";
                    $Email_id_class = "bg-warning";
                } else {
                    $Email_id = trim($_POST['Email_id']);
                }
            } else {
                echo "oops something went wrong";
            }
        } else {
            echo "oops something went wrong";
        }
        mysqli_stmt_close($stmt);
    }





    // * CHECK IF USERNAME IS EMPTY
    if (empty(trim($_POST['username']))) {
        $username_err = "Username can't be blank";
        $username_class = "bg-warning";
    } else {
        $sql = "SELECT id FROM user WHERE username = ?";
        $stmt = mysqli_prepare($link, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // * SET THE VALUE OF PARAMETER USERNAME
            $param_username = trim($_POST['username']);

            //* execute the code

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This Username is already taken";
                    $username_class = "bg-warning";
                } else {
                    $username = trim($_POST['username']);
                }
            }
        } else {
            echo "something went wrong";
        }
        mysqli_stmt_close($stmt);
    }

    // to validate phone number
    $phoneNumber = $_POST['phone_no'];
    $pattern = '/^\d{10}$/';
    if (empty(trim($phoneNumber))) {
        $phone_no_err = "phone no can't be empty";
        $phone_no_err_class = "bg-warning";
    } else if (!preg_match($pattern, $phoneNumber)) {
        $phone_no_err = "Invalid phone number";
        $phone_no_err_class = "bg-warning";
    }

    // to validate country
    $selectedCountry = $_POST['country'];

    if ($selectedCountry === '') {
        // User has not selected any country
        $country_err = "Please select a country.";
        $country_err_class = 'bg-warning';
    }

    if (empty(trim($_POST['password'])))     //todo  CHECK THE PASSWORD
    {
        $password_err = "please enter password";
        $password_err_class = "bg-warning";
    } else if (strlen(trim($_POST['password'])) < 8) {

        $password_err = "password must be greater then length of 8";
        $password_err_class = "bg-warning";
    } else {
        $password = trim($_POST['password']);
    }


    if (trim($_POST['password']) != trim($_POST['confirm_password'])) //TODO CHECK CONFIRM PASSWORD
    {
        $confirm_password_err = "PASSWORD does't match..";
        $confirm_password_err_class = "bg-warning";
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($Email_id_err)) {
        $sql = "INSERT INTO user (username,password,Email_id) VALUES (?,?,?)";
        $stmt = mysqli_prepare($link, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_Email_id);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_Email_id = $Email_id;
            if (mysqli_stmt_execute($stmt)) {
                if((empty($phone_no_err)) && (empty($country_err)))
                header("location: login.php");
            } else {
                echo "something went wrong ...cannot redirect!!";
            }
        }
        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
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
    <title>Register Page</title>
</head>

<body style="background-image: url(images/login.jpg); color:white;">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="register.php">Register Page</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Register Yourself</h1>
        <form action="" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" id="inputEmail4" name="Email_id" placeholder="Email">
                    <small id="Email_id" class="<?php echo $Email_id_class ?? '' ?>"><?php echo $Email_id_err ?? '' ?></small>
                </div>
            </div>
            <br>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="username">User Name</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="username">
                    <small id="username" class="<?php echo $username_class ?? '' ?>"><?php echo $username_err ?? '' ?></small>
                </div>
            </div>
            <br>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="phone-number">Phone Number</label>
                    <input type="tel" class="form-control" name="phone_no" id="phone-number" placeholder="+91">
                    <small id="phone_no" class="<?php echo $phone_no_err_class ?? '' ?>"><?php echo $phone_no_err ?? '' ?></small>
                </div>
                <br>
                <div class="form-group col-md-4">
                    <label for="country">Country:</label><br>
                    <select name="country" >
                        <option value="">None</option>
                        <?php
                        // Array of countries
                        $countries = array(
                            "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia",
                            "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium",
                            "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria",
                            "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia", "Cameroon", "Canada", "Central African Republic", "Chad",
                            "Chile", "China", "Colombia", "Comoros", "Congo", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czechia",
                            "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador",
                            "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini", "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia",
                            "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti",
                            "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica",
                            "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, North", "Korea, South", "Kosovo", "Kuwait",
                            "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania",
                            "Luxembourg", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania",
                            "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique",
                            "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua", "Niger", "Nigeria",
                            "North Macedonia", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru",
                            "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia",
                            "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal",
                            "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia",
                            "South Africa", "South Sudan",
                        );

                        // Generate options for each country
                        foreach ($countries as $country) {
                            echo "<option value=\"$country\">$country</option>";
                        }
                        ?>
                    </select><br>
                    <small id="country" class="<?php echo $country_err_class ?? '' ?>"><?php echo $country_err ?? '' ?></small>
                </div>
            </div>
            <br>
            <div class="form-group col-md-6">
                <label for="inputPassword">Password</label>
                <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password">
                <small id="password" class="<?php echo $password_err_class ?? '' ?>"><?php echo $password_err ?? '' ?></small>
            </div>
            <br>
            <div class="form-group col-md-6">
                <label for="inputPassword4">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" id="inputPassword4" placeholder="Confirm Password">
                <small id="password" class="<?php echo $confirm_password_err_class ?? '' ?>"><?php echo $confirm_password_err ?? '' ?></small>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Sign up</button>
        </form>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>