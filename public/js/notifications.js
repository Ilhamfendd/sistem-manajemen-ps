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

/* Professional Confirm Dialog */
function showConfirm(message, title = "Konfirmasi", onConfirm, onCancel) {
	// Create modal
	const modal = document.createElement("div");
	modal.style.cssText =
		"position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;z-index:10000;animation:fadeIn 0.3s ease-out;";
	modal.innerHTML = `
		<div style="background:white;border-radius:12px;padding:24px;max-width:400px;width:90%;box-shadow:0 20px 60px rgba(0,0,0,0.3);animation:slideUp 0.3s ease-out;">
			<h5 style="margin:0 0 12px 0;font-size:1.1rem;font-weight:600;color:#1f6feb;">${title}</h5>
			<p style="margin:0 0 24px 0;color:#666;font-size:0.95rem;line-height:1.5;">${message}</p>
			<div style="display:flex;gap:12px;justify-content:flex-end;">
				<button onclick="this.closest('div').parentElement.remove()" style="padding:8px 16px;border:1px solid #ddd;border-radius:6px;background:white;cursor:pointer;font-weight:500;color:#666;transition:all 0.2s;">Batal</button>
				<button onclick="document.querySelector('.confirm-modal-confirmed')?.click()" style="padding:8px 16px;border:none;border-radius:6px;background:#1f6feb;color:white;cursor:pointer;font-weight:500;transition:all 0.2s;">Setuju</button>
			</div>
		</div>
	`;

	// Hidden button for confirm action
	const confirmBtn = document.createElement("button");
	confirmBtn.className = "confirm-modal-confirmed";
	confirmBtn.style.display = "none";
	confirmBtn.onclick = () => {
		modal.remove();
		if (onConfirm) onConfirm();
	};
	modal.appendChild(confirmBtn);

	// Cancel handler
	const closeOnCancel = () => {
		if (onCancel) onCancel();
		modal.remove();
	};
	modal.addEventListener("click", (e) => {
		if (e.target === modal) closeOnCancel();
	});

	// Add animations
	const style = document.createElement("style");
	style.textContent = `
		@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
		@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
	`;
	if (!document.querySelector("style[data-confirm-animations]")) {
		style.setAttribute("data-confirm-animations", "");
		document.head.appendChild(style);
	}

	document.body.appendChild(modal);
}

/* Professional Confirm Dialog */
function showConfirm(message, title = "Konfirmasi", onConfirm, onCancel) {
	// Create modal
	const modal = document.createElement("div");
	modal.style.cssText =
		"position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;z-index:10000;animation:fadeIn 0.3s ease-out;";
	modal.innerHTML = `
		<div style="background:white;border-radius:12px;padding:24px;max-width:400px;width:90%;box-shadow:0 20px 60px rgba(0,0,0,0.3);animation:slideUp 0.3s ease-out;">
			<h5 style="margin:0 0 12px 0;font-size:1.1rem;font-weight:600;color:#1f6feb;">${title}</h5>
			<p style="margin:0 0 24px 0;color:#666;font-size:0.95rem;line-height:1.5;">${message}</p>
			<div style="display:flex;gap:12px;justify-content:flex-end;">
				<button onclick="this.closest('div').parentElement.remove()" style="padding:8px 16px;border:1px solid #ddd;border-radius:6px;background:white;cursor:pointer;font-weight:500;color:#666;transition:all 0.2s;">Batal</button>
				<button onclick="document.querySelector('.confirm-modal-confirmed')?.click()" style="padding:8px 16px;border:none;border-radius:6px;background:#1f6feb;color:white;cursor:pointer;font-weight:500;transition:all 0.2s;">Setuju</button>
			</div>
		</div>
	`;

	// Hidden button for confirm action
	const confirmBtn = document.createElement("button");
	confirmBtn.className = "confirm-modal-confirmed";
	confirmBtn.style.display = "none";
	confirmBtn.onclick = () => {
		modal.remove();
		if (onConfirm) onConfirm();
	};
	modal.appendChild(confirmBtn);

	// Cancel handler
	const closeOnCancel = () => {
		if (onCancel) onCancel();
		modal.remove();
	};
	modal.addEventListener("click", (e) => {
		if (e.target === modal) closeOnCancel();
	});

	// Add animations
	const style = document.createElement("style");
	style.textContent = `
		@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
		@keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
	`;
	if (!document.querySelector("style[data-confirm-animations]")) {
		style.setAttribute("data-confirm-animations", "");
		document.head.appendChild(style);
	}

	document.body.appendChild(modal);
}
