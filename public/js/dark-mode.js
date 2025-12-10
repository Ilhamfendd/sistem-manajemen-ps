// Dark Mode Toggle
window.toggleDarkMode = function (e) {
	if (e) {
		e.preventDefault();
		e.stopPropagation();
	}

	const body = document.body;
	const currentTheme = localStorage.getItem("theme") || "light-mode";
	const newTheme = currentTheme === "dark-mode" ? "light-mode" : "dark-mode";

	// Update classes
	body.classList.remove("dark-mode", "light-mode");
	body.classList.add(newTheme);
	document.documentElement.classList.remove("dark-mode", "light-mode");
	document.documentElement.classList.add(newTheme);

	// Update localStorage
	localStorage.setItem("theme", newTheme);

	// Update button icon
	const btn = document.getElementById("themeToggle");
	if (btn) {
		if (newTheme === "dark-mode") {
			btn.innerHTML = '<i class="fas fa-sun"></i>';
			btn.title = "Switch to Light Mode";
		} else {
			btn.innerHTML = '<i class="fas fa-moon"></i>';
			btn.title = "Switch to Dark Mode";
		}
	}
};

// Apply saved theme on page load
document.addEventListener("DOMContentLoaded", function () {
	const savedTheme = localStorage.getItem("theme") || "light-mode";
	document.body.classList.add(savedTheme);
	document.documentElement.classList.add(savedTheme);

	// Update button icon based on saved theme
	const btn = document.getElementById("themeToggle");
	if (btn) {
		if (savedTheme === "dark-mode") {
			btn.innerHTML = '<i class="fas fa-sun"></i>';
			btn.title = "Switch to Light Mode";
		} else {
			btn.innerHTML = '<i class="fas fa-moon"></i>';
			btn.title = "Switch to Dark Mode";
		}
	}
});

// Also apply theme immediately if DOM already loaded
if (
	document.readyState === "interactive" ||
	document.readyState === "complete"
) {
	const savedTheme = localStorage.getItem("theme") || "light-mode";
	document.body.classList.add(savedTheme);
	document.documentElement.classList.add(savedTheme);
}
