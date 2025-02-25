// Pomodoro Timer 
const startPomodoro = document.getElementById("start-pomodoro");
const stopPomodoro = document.getElementById("stop-pomodoro");
const resetPomodoro = document.getElementById("reset-pomodoro");
const pomodoroTimer = document.getElementById("pomodoro-timer");

let pomodoroTimeLeft = 10; // 25 minutes
let pomodoroInterval = null;
let isPomodoroWorkSession = true;
let pomodoroWorkSessionsCompleted = 0;

const updatePomodoroTimer = () => {
    const minutes = Math.floor(pomodoroTimeLeft / 60);
    const seconds = pomodoroTimeLeft % 60;
    pomodoroTimer.textContent = `${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
};

const startPomodoroTimer = () => {
    pomodoroInterval = setInterval(() => {
        if (pomodoroTimeLeft > 0) {
            pomodoroTimeLeft--;
            updatePomodoroTimer();
        } else {
            clearInterval(pomodoroInterval);
            pomodoroInterval = null;
            pomodoroWorkSessionsCompleted++;
            if (isPomodoroWorkSession) {
                if (pomodoroWorkSessionsCompleted % 4 === 0) {
                    pomodoroTimeLeft = 900; //15 minutes
                } else {
                    pomodoroTimeLeft = 300; // 5 minutes
                }
                isPomodoroWorkSession = false;
                alert("Time for a break!");
            } else {
                isPomodoroWorkSession = true;
                pomodoroTimeLeft = 1500; // 25 minutes
                alert("Back to work!");
            }
            updatePomodoroTimer();

            }
    }, 1000);
        
};


const resetPomodoroTimer = () => {
    clearInterval(pomodoroInterval);
    pomodoroInterval = null;
    pomodoroTimeLeft = 1500;
    isPomodoroWorkSession = true;
    updatePomodoroTimer();
};

// Task Manager 
const taskInput = document.getElementById("task-input");
const addTaskButton = document.getElementById("add-task");
const taskList = document.getElementById("task-list");

let tasks = [];

const addTask = () => {
    const taskText = taskInput.value;
    if (taskText) {
        tasks.push(taskText);
        updateTaskList();
        taskInput.value = "";
    }
};

const updateTaskList = () => {
    taskList.innerHTML = "";
    tasks.forEach((task, index) => {
        const taskItem = document.createElement("li");
        taskItem.textContent = task;

        const deleteButton = document.createElement("button");
        deleteButton.textContent = "Delete";
        deleteButton.onclick = () => deleteTask(index);

        const editButton = document.createElement("button");
        editButton.textContent = "Edit";
        editButton.onclick = () => editTask(index);

        taskItem.appendChild(editButton);
        taskItem.appendChild(deleteButton);
        taskList.appendChild(taskItem);
    });
};

const deleteTask = (index) => {
    tasks.splice(index, 1);
    updateTaskList();
};

const editTask = (index) => {
    const newTask = prompt("Edit task:", tasks[index]);
    if (newTask) {
        tasks[index] = newTask;
        updateTaskList();
    }
};

startPomodoro.addEventListener("click", startPomodoroTimer);
stopPomodoro.addEventListener("click", () => clearInterval(pomodoroInterval));
resetPomodoro.addEventListener("click", resetPomodoroTimer);

addTaskButton.addEventListener("click", addTask);

updatePomodoroTimer();