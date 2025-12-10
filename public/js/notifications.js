/* Professional Notification System */

function showNotification(
	message,
	type = "info",
	duration = 5000,
	title = null
) {
	let container = document.querySelector(".notifications-container");
	if (!container) {
		container = document.createElement("div");
		container.className = "notifications-container";
		document.body.appendChild(container);
	}

	const notification = document.createElement("div");
	notification.className = `notification notification-${type}`;

	const icons = {
		success: '<i class="fas fa-check-circle"></i>',
		error: '<i class="fas fa-exclamation-circle"></i>',
		warning: '<i class="fas fa-exclamation-triangle"></i>',
		info: '<i class="fas fa-info-circle"></i>',
	};

	const titles = {
		success: "Berhasil",
		error: "Terjadi Kesalahan",
		warning: "Perhatian",
		info: "Informasi",
	};

	const finalTitle = title || titles[type] || "";

	notification.innerHTML = `
        <div class="notification-icon">${icons[type]}</div>
        <div class="notification-content">
            ${
							finalTitle
								? `<p class="notification-title">${finalTitle}</p>`
								: ""
						}
            <p class="notification-message">${message}</p>
        </div>
        <button class="notification-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
        ${duration > 0 ? '<div class="notification-progress"></div>' : ""}
    `;

	container.appendChild(notification);

	if (duration > 0) {
		setTimeout(() => {
			if (notification.parentElement) {
				notification.classList.add("fade-out");
				setTimeout(() => notification.remove(), 300);
			}
		}, duration);
	}

	return notification;
}

function initializeFlashNotifications() {
	// Success
	const successFlash = document.querySelector("[data-flash-success]");
	if (successFlash) {
		const message = successFlash.getAttribute("data-flash-success");
		const title = successFlash.getAttribute("data-flash-title") || "Berhasil";
		if (message) {
			showNotification(message, "success", 5000, title);
			successFlash.remove();
		}
	}

	// Error
	const errorFlash = document.querySelector("[data-flash-error]");
	if (errorFlash) {
		const message = errorFlash.getAttribute("data-flash-error");
		const title =
			errorFlash.getAttribute("data-flash-title") || "Terjadi Kesalahan";
		if (message) {
			showNotification(message, "error", 5000, title);
			errorFlash.remove();
		}
	}

	// Warning
	const warningFlash = document.querySelector("[data-flash-warning]");
	if (warningFlash) {
		const message = warningFlash.getAttribute("data-flash-warning");
		const title = warningFlash.getAttribute("data-flash-title") || "Perhatian";
		if (message) {
			showNotification(message, "warning", 5000, title);
			warningFlash.remove();
		}
	}

	// Info
	const infoFlash = document.querySelector("[data-flash-info]");
	if (infoFlash) {
		const message = infoFlash.getAttribute("data-flash-info");
		const title = infoFlash.getAttribute("data-flash-title") || "Informasi";
		if (message) {
			showNotification(message, "info", 5000, title);
			infoFlash.remove();
		}
	}
}

document.addEventListener("DOMContentLoaded", initializeFlashNotifications);

const notify = {
	success: (msg, title) => showNotification(msg, "success", 5000, title),
	error: (msg, title) => showNotification(msg, "error", 5000, title),
	warning: (msg, title) => showNotification(msg, "warning", 5000, title),
	info: (msg, title) => showNotification(msg, "info", 5000, title),
	success_permanent: (msg, title) => showNotification(msg, "success", 0, title),
	error_permanent: (msg, title) => showNotification(msg, "error", 0, title),
	warning_permanent: (msg, title) => showNotification(msg, "warning", 0, title),
	info_permanent: (msg, title) => showNotification(msg, "info", 0, title),
};
