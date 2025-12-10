// ============================================
// DARK MODE - Apply theme IMMEDIATELY (before DOM renders)
// ============================================
(function () {
// Wait for body to be available
function applyTheme() {
if (!document.body) {
setTimeout(applyTheme, 10);
return;
}

const savedTheme = localStorage.getItem("theme") || "light-mode";
if (savedTheme === "dark-mode") {
document.documentElement.classList.add("dark-mode");
document.body.classList.add("dark-mode");
}
}

if (document.readyState === "loading") {
document.addEventListener("DOMContentLoaded", applyTheme);
} else {
applyTheme();
}
})();

// ============================================
// DARK MODE TOGGLE & MANAGEMENT
// ============================================
window.toggleDarkMode = function (e) {
if (e) {
e.preventDefault();
e.stopPropagation();
}

const currentTheme = localStorage.getItem("theme") || "light-mode";
const newTheme = currentTheme === "dark-mode" ? "light-mode" : "dark-mode";

// Remove all dark-mode classes
document.documentElement.classList.remove("dark-mode");
document.body.classList.remove("dark-mode");

// Add appropriate class
if (newTheme === "dark-mode") {
document.documentElement.classList.add("dark-mode");
document.body.classList.add("dark-mode");
}

localStorage.setItem("theme", newTheme);
updateThemeButton();

// Force repaint
document.body.offsetHeight;
};

function updateThemeButton() {
const themeToggle = document.getElementById("themeToggle");
if (!themeToggle) return;

const currentTheme = localStorage.getItem("theme") || "light-mode";

if (currentTheme === "dark-mode") {
themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
themeToggle.title = "Switch to Light Mode";
themeToggle.classList.add("dark-mode-active");
} else {
themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
themeToggle.title = "Switch to Dark Mode";
themeToggle.classList.remove("dark-mode-active");
}
}

// Initialize handlers
function setupDarkModeHandler() {
const themeToggle = document.getElementById("themeToggle");
if (!themeToggle) {
setTimeout(setupDarkModeHandler, 100);
return;
}

// Add click handler directly - don't clone element
themeToggle.addEventListener("click", function(e) {
e.preventDefault();
e.stopPropagation();
window.toggleDarkMode(e);
return false;
});

updateThemeButton();
}

// Setup when DOM ready
if (document.readyState === "loading") {
document.addEventListener("DOMContentLoaded", setupDarkModeHandler);
} else {
setupDarkModeHandler();
}
