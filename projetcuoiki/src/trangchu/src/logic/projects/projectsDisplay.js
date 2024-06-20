import {
  createDOMProjectItem,
  projectsContainer,
  projectTitleElement,
} from "../../global_data";

class ProjectDisplay {
  addProjectToDOM(id, title) {
    let domNode = createDOMProjectItem({ id, title });
    projectsContainer.appendChild(domNode);
  }

  removeProjectFromDOM(id) {
    this.getDOMNode(id).remove();
  }

  getDOMNode(id) {
    let node = projectsContainer.querySelector(`.projectItem[data-id='${id}']`);
    return node;
  }

  isProjectActive(id) {
    let node = this.getDOMNode(id);
    return node.classList.contains("active");
  }

  setProjectAsActive(id) {
    this.getDOMNode(id).classList.add("active");
  }

  setProjectAsInactive(id) {
    this.getDOMNode(id).className = "projectItem";
  }

  setProjectTitle(title) {
    projectTitleElement.textContent = title;
  }
}

export const projectDisplay = new ProjectDisplay();
