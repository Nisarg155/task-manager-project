<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
}

if (isset($_POST['task'])) {
    $task = $_POST['task'];
    $host = "your_host";
    $username = "your_username";
    $password = "your_password";
    $database = "your_";

    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO tasks (task_name) VALUES ('$task')";
    mysqli_query($conn, $sql);
}
?>
