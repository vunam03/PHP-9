import { v4 as uuidv4 } from "uuid";
import { projectsList, resetElements, createTodoItem } from "../../global_data";
import { todoDisplay } from "./todoDisplay";
import { eventManager } from "../../managers/eventManager";
import { projectManager } from "../../managers/projectManager";
import { todoManager } from "../../managers/todoManager";

// EVENTS
eventManager.registerEvent("todoListModified");

eventManager.registerActionToEvent("todoListModified", (projectID) => {
  eventManager.triggerEvent("projectsListModified");
  const project = projectsList[projectID];
  todoDisplay.load(project);
});

const createTodoItemDialog = document.querySelector(".createTodoItemDialog");
const createTodoForm = createTodoItemDialog.querySelector("form");
const newTodoItem = document.getElementById("newItemBtn");

// CREATE TODO ITEM FORM INPUT FIELDS
let titleInput = createTodoItemDialog.querySelector(".todoItemTitle");
let dueDateInput = createTodoItemDialog.querySelector(".todoItemDueDate");
let priorityInput = createTodoItemDialog.querySelector(".selectItemPriority");
let descInput = createTodoItemDialog.querySelector(".todoItemDescription");

newTodoItem.addEventListener("click", () => {
  createTodoItemDialog.style.display = "flex";
});

createTodoForm.addEventListener("submit", (e) => {
  e.preventDefault();

  let id = uuidv4();
  let title = titleInput.value;
  let dueDate = dueDateInput.value;
  let priority = priorityInput.value;
  let desc = descInput.value;

  const item = createTodoItem({ id, title, dueDate, priority, desc });
  try {
    todoManager.addTodoItem(item, projectManager.getActiveProjectID());
  } catch (error) {
    alert(error);
  }
  resetElements([titleInput, dueDateInput, descInput]);
  createTodoItemDialog.style.display = "none";
});

// EDITING TODOS
const todoItemDetailsDialog = document.querySelector(".todoItemDetailsDialog");
const todoDetailsForm = todoItemDetailsDialog.querySelector("form");

todoItemDetailsDialog.addEventListener("click", () => {
  todoItemDetailsDialog.removeAttribute("data-id");
});

todoDetailsForm.addEventListener("submit", (e) => {
  e.preventDefault();

  let submitter = e.submitter; // BTN THAT TRIGGERED THE SUBMIT EVENT
  let todoItemID = todoItemDetailsDialog.dataset.id;
  let actionType = submitter.dataset.type;
  try {
    if (actionType === "save") {
      let title = todoItemDetailsDialog.querySelector(".todoItemTitle").value;
      let dueDate =
        todoItemDetailsDialog.querySelector(".todoItemDueDate").value;
      let priority = todoItemDetailsDialog.querySelector(
        ".selectItemPriority"
      ).value;
      let desc = todoItemDetailsDialog.querySelector(
        ".todoItemDescription"
      ).value;

      let newData = {
        title,
        dueDate,
        priority,
        desc,
      };

      todoManager.updateTodoItem(todoItemID, newData);
    } else if (actionType === "status") {
      todoManager.toggleTodoItemStatus(todoItemID);
    } else {
      todoManager.removeTodoItem(todoItemID);
    }
    todoItemDetailsDialog.style.display = "none";
  } catch (error) {
    alert(error);
  }
});
