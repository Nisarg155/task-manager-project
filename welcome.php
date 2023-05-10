<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !==true)
{
    header("location: login.php");
}



$session_id = $_SESSION['id'];


?>
<!DOCTYPE html>
<html>

<head>
    <title>To-Do List</title>
    <link rel="stylesheet" href="welcome.css"> 
</head>

<body>
<div class="navbar">
    <nav>
      <a href="register.php">Register</a>
      <a href="login.php">Login</a>
      <a href="logout.php">logout</a>
      <div class="topright">
      <a href=""><?php echo "Welcome ". $_SESSION['id']?></a>
      </div>
    </nav>
  </div>
    <div class="todo-container">
        <h1>To-Do List</h1>
        <input type="text" id="new-task" placeholder="Add a new task...">
        <button class="buttons" id="add-btn">Add</button>
        <ul id="todo-list"></ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="welcome.js"></script>
</body>

</html>