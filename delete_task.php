<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

if (isset($_POST['id'])) {
    $task_id = $_POST['id'];
    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "login");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and execute the SQL statement to delete the task
    $sql = "DELETE FROM user_task WHERE  task_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $task_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "Task deleted successfully";
        } else {
            echo "Error deleting task: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error in prepared statement: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
