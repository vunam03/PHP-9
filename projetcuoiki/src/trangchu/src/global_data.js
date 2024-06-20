import { v4 as uuidv4 } from "uuid";
import { eventManager } from "./managers/eventManager";
import { todoManager } from "./managers/todoManager";

export const projectsList = {};
export const projectsContainer = document.querySelector(".projects");
export const projectTitleElement = document.getElementById(
  "currentProjectTitle"
);
export const todoContainer = document.querySelector(".todos");

const todoItemTemplate = document.getElementById("todoItemTemplate");
const projectItemTemplate = document.getElementById("projectTemplate");

export function resetElements(elements) {
  elements.forEach((element) => {
    element.value = "";
  });
}

export function createTodoItem(props) {
  let todoItem = {
    id: props.id,
    title: props.title,
    dueDate: props.dueDate,
    priority: props.priority,
    desc: props.desc,
    done: false,
  };

  return todoItem;
}

export function createDOMTodoItem(props) {
  let item = todoItemTemplate.content.firstElementChild.cloneNode(true);
  item.setAttribute("data-id", props.id);
  item.classList.add(props.priority);
  item.querySelector(".todoItem_title").textContent = props.title;
  if (props.done === true) {
    item.classList.add("done");
  }

  item.querySelector(".showTodoDetailsBtn").addEventListener("click", (e) => {
    let itemID = e.target.closest(".todoItem").dataset.id;
    todoManager.showTodoDetails(itemID);
  });
  return item;
}

export function resetTodosContainer() {
  document.getElementById("currentProjectTitle").textContent = "";
  while (todoContainer.firstElementChild) {
    todoContainer.removeChild(todoContainer.lastElementChild);
  }
}

export function createProjectItem(_title) {
  let projectID = uuidv4();
  let projectItem = {
    id: projectID,
    title: _title,
    todos: {},
  };

  return projectItem;
}

export function createDOMProjectItem(props) {
  let item = projectItemTemplate.content.firstElementChild.cloneNode(true);
  item.querySelector(".projectTitle").textContent = props.title;
  item.dataset.id = props.id;

  item.addEventListener("click", () => {
    eventManager.triggerEvent("projectItemClicked", [props.id]);
  });

  item.addEventListener("input", (e) => {
    let updatedTitle = e.target.textContent;
    eventManager.triggerEvent("projectItemTitleUpdated", [
      props.id,
      updatedTitle,
    ]);
  });

  let deleteProjectBtn = item.querySelector(".deleteProjectItem");
  deleteProjectBtn.addEventListener("click", (e) => {
    eventManager.triggerEvent("projectItemDeleted", [props.id]);

    e.stopPropagation();
  });

  return item;
}
