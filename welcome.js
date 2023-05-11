const newTaskInput = document.getElementById("new-task");
const addBtn = document.getElementById("add-btn");
const todoList = document.getElementById("todo-list");
const sessionID  = "<?php echo $session_id; ?>";

function fetchTasks() {
    // Send an AJAX request to get the tasks from the database
    $.get("get_task.php", function(data) {
        if (data) {
            const tasks = JSON.parse(data);
            tasks.forEach(function(task) {
                const newTask = createTaskElement(task.id, task.text, task.status);
                todoList.appendChild(newTask);
            });
        }
    });
}

// Call the fetchTasks function to display tasks on page load or refresh
fetchTasks();


function addTask() {
    const newTaskText = newTaskInput.value;

    if (newTaskText === "") {
        return;
    }

    
    // Send an AJAX request to add the task to the database
    $.post("add_task.php", { task: newTaskText , sessionID:sessionID }, function(data) {
        const task = JSON.parse(data);
        const newTask = createTaskElement(task.id, task.text, task.status);
        todoList.appendChild(newTask);
            newTaskInput.value = "";
    });
}

function completeTask(event) {
    const checkbox = event.target;
    const task = checkbox.parentElement;
    const id = task.getAttribute("data-id");
    const status = checkbox.checked ? 1 : 0;

    // Send an AJAX request to update the task in the database
    $.post("update_task.php", { id: id, status: status }, function(data) {
        console.log(data);
    });
    
    if (checkbox.checked) {
        task.classList.add("completed");
    } else {
        task.classList.remove("completed");
    }
}

function deleteTask(event) {
    const deleteBtn = event.target;
    const task = deleteBtn.parentElement;
    const id = task.getAttribute("data-id");

    // Send an AJAX request to delete the task from the database
    $.post("delete_task.php", { id: id }, function(data) {
        console.log(data);
    });
    
    task.remove();
}

function createTaskElement(id, text, status) {
    const newTask = document.createElement("li");
    newTask.setAttribute("data-id", id);
    
    const checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.addEventListener("change", completeTask);
    if (status == 1) {
        checkbox.checked = true;
        newTask.classList.add("completed");
    }

    const taskText = document.createElement("span");
    taskText.innerText = text;

    const deleteBtn = document.createElement("button");
    deleteBtn.innerText = "Delete";
    deleteBtn.classList.add("delete-btn");
    deleteBtn.addEventListener("click", deleteTask);

    newTask.appendChild(checkbox);
    newTask.appendChild(taskText);
    newTask.appendChild(deleteBtn);

    return newTask;
}

addBtn.addEventListener("click", addTask);
