import { projectManager } from "./projectManager";
import { eventManager } from "./eventManager";
import { projectsList } from "../global_data";

const todoItemDetailsDialog = document.querySelector(".todoItemDetailsDialog");

export const getTodoDataFromID = (id) => {
  const activeProjectID = projectManager.getActiveProjectID();
  const todoData = projectsList[activeProjectID].todos[id];
  return todoData;
};

class TodoManager {
  addTodoItem(todoItem, projectID) {
    if (projectID === "") throw "No Projects Available. Create a project";
    if (projectID in projectsList) {
      projectsList[projectID].todos[todoItem.id] = todoItem;
      eventManager.triggerEvent("todoListModified", [projectID]);
      return;
    }
    throw `project with ID - ${projectID} not found`;
  }

  removeTodoItem(todoItemID) {
    let currentProjectID = projectManager.getActiveProjectID();

    if (todoItemID in projectsList[currentProjectID].todos) {
      delete projectsList[currentProjectID].todos[todoItemID];
      eventManager.triggerEvent("todoListModified", [currentProjectID]);
      return;
    }
    throw `todoItem with ID - ${todoItemID} not found`;
  }

  updateTodoItem(todoItemID, newData) {
    let currentProjectID = projectManager.getActiveProjectID();

    if (todoItemID in projectsList[currentProjectID].todos) {
      projectsList[currentProjectID].todos[todoItemID].title = newData.title;
      projectsList[currentProjectID].todos[todoItemID].dueDate =
        newData.dueDate;
      projectsList[currentProjectID].todos[todoItemID].priority =
        newData.priority;
      projectsList[currentProjectID].todos[todoItemID].desc = newData.desc;

      eventManager.triggerEvent("todoListModified", [currentProjectID]);
      return;
    }
    throw `todoItem with ID - ${todoItemID} not found`;
  }

  toggleTodoItemStatus(todoItemID) {
    let currentProjectID = projectManager.getActiveProjectID();

    if (todoItemID in projectsList[currentProjectID].todos) {
      let isTodoItemDone =
        projectsList[currentProjectID].todos[todoItemID].done;
      projectsList[currentProjectID].todos[todoItemID].done = !isTodoItemDone;

      eventManager.triggerEvent("todoListModified", [currentProjectID]);
      return;
    }
    throw `todoItem with ID - ${todoItemID} not found`;
  }

  showTodoDetails(todoItemID) {
    const todoItemData = getTodoDataFromID(todoItemID);

    todoItemDetailsDialog.style.display = "flex";
    todoItemDetailsDialog.dataset.id = todoItemID;

    todoItemDetailsDialog.querySelector(".todoItemTitle").value =
      todoItemData.title;
    todoItemDetailsDialog.querySelector(".todoItemDueDate").value =
      todoItemData.dueDate;
    todoItemDetailsDialog.querySelector(".selectItemPriority").value =
      todoItemData.priority;
    todoItemDetailsDialog.querySelector(".todoItemDescription").value =
      todoItemData.desc;
  }
}

export const todoManager = new TodoManager();
