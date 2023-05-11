<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];

    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "login");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and execute the SQL statement to get the tasks
    $sql = "SELECT * FROM user_task WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Fetch tasks from the result
    $tasks = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $task = array(
            'id' => $row['task_id'],
            'text' => $row['task'],
            'status' => $row['task_status']
        );
        $tasks[] = $task;
    }

    // Close the statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    // Return the tasks as JSON
    echo json_encode($tasks);
}
?>
