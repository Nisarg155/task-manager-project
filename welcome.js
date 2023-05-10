const newTaskInput = document.getElementById("new-task");
const addBtn = document.getElementById("add-btn");
const todoList = document.getElementById("todo-list");

function addTask() {
    const newTaskText = newTaskInput.value;

    if (newTaskText === "") {
        return;
    }

    
    const newTask = document.createElement("li");
    const checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.addEventListener("change", completeTask);

    const text = document.createElement("span");
    text.innerText = newTaskText;

    const deleteBtn = document.createElement("button");
    deleteBtn.innerText = "Delete";
    deleteBtn.classList.add("delete-btn");
    deleteBtn.addEventListener("click", deleteTask);

    newTask.appendChild(checkbox);
    newTask.appendChild(text);
    newTask.appendChild(deleteBtn);
    todoList.appendChild(newTask);
    
    newTaskInput.value = "";
}

function completeTask(event) {
    const checkbox = event.target;
    const task = checkbox.parentElement;

    if (checkbox.checked) {
        task.classList.add("completed");
    } else {
        task.classList.remove("completed");
    }
}

function deleteTask(event) {
    const deleteBtn = event.target;
    const task = deleteBtn.parentElement;
    task.remove();
}

addBtn.addEventListener("click", addTask);