<?php
// Get the task ID and status from the AJAX request
$id = $_POST["id"];
$status = $_POST["status"];

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "login");

// Update the task in the database
$sql = "UPDATE user_task SET task_status=$status WHERE task_id=$id";
mysqli_query($conn, $sql);

// Close the database connection
mysqli_close($conn);
?>
