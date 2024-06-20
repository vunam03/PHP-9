import "./sidebar.css";

const sidebar = document.querySelector(".sidebar");
const sidebarBtn = document.querySelector(".sidebarBtn");
const main = document.querySelector("main");

function closeSidebar() {
  sidebar.className = "sidebar closed";
  main.className = "sidebarClosed";
  main.dataset.sidebar = "closed";
}

function openSidebar() {
  sidebar.className = "sidebar open";
  main.className = "sidebarOpen";
  main.dataset.sidebar = "open";
}

sidebarBtn.addEventListener("click", () => {
  let isSidebarOpen = main.dataset.sidebar;

  if (isSidebarOpen === "open") {
    closeSidebar();
  } else {
    openSidebar();
  }
});
