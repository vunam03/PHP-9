import { v4 as uuidv4 } from "uuid";
import { projectsList, resetTodosContainer } from "../../global_data";

import { eventManager } from "../../managers/eventManager";
import { projectManager } from "../../managers/projectManager";

import { projectDisplay } from "./projectsDisplay";
import { todoDisplay } from "../todos/todoDisplay";

import { storeProjectDataLocally } from "../../managers/dataManager";
import "./projects.css";

export class Project {
  #id;
  title = "";
  todos = {};

  constructor(_title, _todos = {}) {
    this.#id = uuidv4();
    this.title = _title;
    this.todos = _todos;
  }
  getID = () => this.#id;
}

// REGISTER EVENTS
eventManager.registerEvent("projectItemAdded");
eventManager.registerEvent("projectItemClicked");
eventManager.registerEvent("projectItemActive");
eventManager.registerEvent("projectItemDeleted");
eventManager.registerEvent("projectItemTitleUpdated");
eventManager.registerEvent("allProjectsDeleted");
eventManager.registerEvent("projectsListModified");

// SETTING HANDLERS FOR EVENTS
try {
  eventManager.registerActionToEvent("projectsListModified", () => {
    storeProjectDataLocally(projectsList);
  });

  eventManager.registerActionToEvent("projectItemAdded", (id) => {
    projectManager.setActiveProject(id);
    eventManager.triggerEvent("projectsListModified");
  });

  eventManager.registerActionToEvent("projectItemClicked", (id) => {
    projectManager.setActiveProject(id);
  });

  eventManager.registerActionToEvent("projectItemActive", (id) => {
    const project = projectsList[id];
    todoDisplay.load(project);
  });

  eventManager.registerActionToEvent("projectItemDeleted", (id) => {
    projectManager.removeProject(id);
    eventManager.triggerEvent("projectsListModified");
  });

  eventManager.registerActionToEvent("projectItemTitleUpdated", (id, title) => {
    if (id in projectsList) {
      projectsList[id].title = title;
      eventManager.triggerEvent("projectsListModified");

      if (id === projectManager.getActiveProjectID()) {
        projectDisplay.setProjectTitle(title);
      }
    }
  });

  eventManager.registerActionToEvent("allProjectsDeleted", () => {
    resetTodosContainer();
  });
} catch (error) {
  alert(error);
}

const newProjectBtn = document.getElementById("newProjectBtn");
newProjectBtn.addEventListener("click", () => {
  projectManager.addProject();
});
