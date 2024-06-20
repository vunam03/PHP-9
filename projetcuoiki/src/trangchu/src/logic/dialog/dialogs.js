const dialogs = document.querySelectorAll("dialog");
const forms = document.querySelectorAll("dialog > form");

// INIT
dialogs.forEach((dialog) => {
  dialog.addEventListener("click", () => {
    dialog.style.display = "none";
  });
});

forms.forEach((form) => {
  form.addEventListener("click", (e) => {
    e.stopPropagation();
  });
});
