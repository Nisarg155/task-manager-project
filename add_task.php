<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)
{
    header("location: login.php");
}

$session_id = $_SESSION['id'];

if(isset($_POST['task']) && !empty($_POST['task'])) {
    $task = $_POST['task'];
    $date = date('Y-m-d H:i:s');
    $status = 0; // Set default status to incomplete

    // Connect to database
    $conn = mysqli_connect("localhost", "root", "", "login");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and execute SQL statement to insert new task
    $sql = "INSERT INTO user_task (id, task, date, task_status) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $session_id, $task, $date, $status);
    mysqli_stmt_execute($stmt);

    // Get the ID of the newly inserted task
    $task_id = mysqli_insert_id($conn);

    // Close the database connection
    mysqli_close($conn);

    // Return the new task as JSON
    $new_task = array(
        "id" => $task_id,
        "text" => $task,
        "status" => $status
    );
    echo json_encode($new_task);
}
