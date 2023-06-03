<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
}



$session_id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="welcome.css">
</head>

<body>
    <div class="navbar" >
        <nav>
            <a href="logout.php">logout</a>
            <a href="contact.html">Contact us</a>
            <div class="topright">
                <a href="logindetails.php"><img src="images/user.png" style="height:30px"></a>
                <a href="logindetails.php"><?php echo "Welcome " . $_SESSION['username'] ?></a>
            </div>
        </nav>
    </div>
    <div class="todo-container">
        <h1 style="color:white;">To-Do List</h1>
        <input type="text" id="new-task" placeholder="Add a new task...">
        <button class="buttons" id="add-btn">Add</button>
        <ul id="todo-list"></ul>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="welcome.js"></script>
</body>



<style>
    body{
        background-image: url(images/welcome.jpg);
        background-size:cover;
        margin: 0px;
        padding: 0px;

    }
    .navbar{
        background-color: #333;
        padding: 15px;
        font-size: 20px;
    }


    .topright {
	
	top: 15px;
	right: 16px;
	font-size: 20px;
}

    .buttons {
	padding: 10px 20px;
	background-color: #008cba;
	color: #fff;
	border: none;
	border-radius: 20px;
	font-size: 18px;
	cursor: pointer;
}
    ul {
	list-style: none;
	padding: 0;
}


li {
	display: flex;
	align-items: center;
	justify-content: space-between;
	font-size: 20px;
	padding: 10px;
	border-radius: 20px;
	background-color: #1D267D; 
	margin-bottom: 10px;
    color: white;
}

li input[type="checkbox"] {
	margin-right: 10px;
}

li.completed {
	background-color: #0C134F;
}
li.completed span{
    text-decoration: line-through;
}



.delete-btn {
	background-color: #f44336;
	color: #fff;
	border: none;
	padding: 5px 10px;
	border-radius: 20px;
	font-size: 16px;
	cursor: pointer;
}
</style>
</html>