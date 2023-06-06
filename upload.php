<?php

$target_file = "";
$id = $_SESSION['id'];
$err4 = "";
$err4_class = "";
$link = mysqli_connect("localhost", "root", "", "login");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $target_dir = "user_profile/";

    $target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);

    $imageExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed_file_ext = array("jpg", "jpeg", "png");



    if (isset($_POST['upload_button1'])) {
        if (!file_exists($_FILES["fileUpload"]["tmp_name"])) {
            $err4 = "select image to upload.";
            $err4_class = "bg-warning";
        } elseif (!in_array($imageExt, $allowed_file_ext)) {
            $err4 =  "Allowed file formats .jpg , .jpeg and .png";
            $err4_class = "bg-warning";
        } elseif ($_FILES["fileUpload"]["size"] > 2097152) {
            $err4 = "File is too large . File should be less than 2Mb";
            $err4_class = "bg-warning";
        } elseif ($_SESSION['userimage'] === $target_file) {
            $err4 = "File already exists.,";
            $err4_class = "bg-warning";
        } else {
            if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
                $sql = "UPDATE user SET file_path = ? WHERE id = ?";
                $stmt = mysqli_prepare($link, $sql);
                mysqli_stmt_bind_param($stmt, "si", $target_file, $id);
                if (mysqli_stmt_execute($stmt)) {
                    $err4 = "Image uploded sucessful";
                    $err4_class = "bg-warning";
                } else {
                    $err4 = "Image couldn't be uploded";
                    $err4_class = "bg-warning";
                }
            }
        }
    } elseif (isset($_POST['upload_button2'])) {
        if (!file_exists($_FILES["fileUpload"]["tmp_name"])) {
            
        } elseif (!in_array($imageExt, $allowed_file_ext)) {
            $err4 =  "Allowed file formats .jpg , .jpeg and .png";
            $err4_class = "bg-warning";
        } elseif ($_FILES["fileUpload"]["size"] > 2097152) {
            $err4 = "File is too large . File should be less than 2Mb";
            $err4_class = "bg-warning";
        } elseif ($_SESSION['userimage'] === $target_file) {
            $err4 = "File already exists.,";
            $err4_class = "bg-warning";
        } else {
            if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
                $sql = "UPDATE user SET file_path = ? WHERE id = ?";
                $stmt = mysqli_prepare($link, $sql);
                mysqli_stmt_bind_param($stmt, "si", $target_file, $id);
                if (mysqli_stmt_execute($stmt)) {
                    $err4 = "Image uploded sucessful";
                    $err4_class = "bg-warning";
                } else {
                    $err4 = "Image couldn't be uploded";
                    $err4_class = "bg-warning";
                }
            }
        }
    }elseif(isset($_POST['remove_button']))
    {
        if(empty($_SESSION['userimage']))
        {
            $err4 = "First Upload an Image";
            $err4_class = "bg-warning";
        }
        else{
            $sql = "UPDATE user SET file_path = ? WHERE id = ?";
            $stmt = mysqli_prepare($link,$sql);
            mysqli_stmt_bind_param($stmt,"si",$param_userimage,$id);
            $param_userimage = "";
            if(mysqli_stmt_execute($stmt))
            {
                $err4 = "Image Removed ";
                $err4_class = "bg-warning";
            }
            else{
                $err4 = "Error Removing Image";
                $err4_class = "bg-warning";
            }
        }
    }
}
