import "./init.css";
import "./main.css";
import "./logic/sidebar/sidebar";
import "./logic/dialog/dialogs";
import "./logic/projects/projects";
import "./logic/todos/todos";
import { createProjectItem } from "./global_data";
import { projectManager } from "./managers/projectManager";
import { todoManager } from "./managers/todoManager";

/* Simple functions for easily adding objects and array to localStorage */
Storage.prototype.setObj = function (key, obj) {
  return this.setItem(key, JSON.stringify(obj));
};

Storage.prototype.getObj = function (key) {
  return JSON.parse(this.getItem(key));
};

(function loadLocalData() {
  let projects = localStorage.getObj("projects");
  if (projects === null || Object.keys(projects).length === 0) {
    let defaultProject = createProjectItem("Default");
    projectManager.addProject(defaultProject);
    return;
  }

  try {
    for (const projectID in projects) {
      projectManager.addProject(projects[projectID]);
      let projectTodos = projects[projectID].todos;

      for (const todoID in projectTodos) {
        let todoItem = projectTodos[todoID];
        todoManager.addTodoItem(todoItem, projectID);
      }
    }
  } catch (error) {
    alert(error);
  }
})();
