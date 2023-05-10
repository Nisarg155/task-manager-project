<?php

// Database configuration
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "login";

// Create database connection
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get tasks from the database
$sql = "SELECT task_id, task, date, task_status FROM user_task WHERE id = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $_SESSION['id'], $task_status);
$task_status = 0; // get only the tasks with task_status = 0
$stmt->execute();
$result = $stmt->get_result();

// Fetch tasks and create an array of tasks
$tasks = array();
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

// Convert the tasks array to JSON and return
echo json_encode($tasks);

// Close database connection
$stmt->close();
$conn->close();

?>