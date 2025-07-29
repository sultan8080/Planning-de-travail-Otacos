import { startStimulusApp } from '@symfony/stimulus-bundle';

const app = startStimulusApp();
// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);
 document.addEventListener("DOMContentLoaded", () => {
      const sidebar = document.getElementById("sidebar");
      const toggleDesktop = document.getElementById("sidebarToggle");
      const toggleMobile = document.getElementById("offcanvasToggle");

      toggleDesktop?.addEventListener("click", () => {
        sidebar.classList.toggle("collapsed");
      });

      toggleMobile?.addEventListener("click", () => {
        sidebar.classList.toggle("show");
      });

      document.addEventListener("click", (e) => {
        if (
          sidebar.classList.contains("show") &&
          !sidebar.contains(e.target) &&
          !toggleMobile.contains(e.target)
        ) {
          sidebar.classList.remove("show");
        }
      });

      document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && sidebar.classList.contains("show")) {
          sidebar.classList.remove("show");
        }
      });
    });