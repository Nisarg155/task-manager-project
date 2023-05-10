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
    <style>
        /* CSS styles for the page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin-right: 10px;
        }

        .topright {
            float: right;
        }

        .todo-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h1 {
            text-align: center;
        }

        #new-task {
            width: 80%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .buttons {
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        #todo-list {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        .delete-btn {
            padding: 5px 10px;
            background-color: #f44336;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .completed {
            text-decoration: line-through;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <nav>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
            <a href="logout.php">logout</a>
            <div class="topright">
                <a href=""><?php echo "Welcome " . $_SESSION['id'] ?></a>
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
