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

/**
 * Professional Confirm Dialog
 */
function showConfirm(
	message,
	title = "Konfirmasi",
	onConfirm = null,
	onCancel = null
) {
	// Create modal backdrop
	const backdrop = document.createElement("div");
	backdrop.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9998;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.2s ease-out;
    `;

	// Create modal
	const modal = document.createElement("div");
	modal.style.cssText = `
        background: white;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 400px;
        width: 90%;
        padding: 30px;
        text-align: center;
        animation: slideUp 0.3s ease-out;
    `;

	modal.innerHTML = `
        <div style="margin-bottom: 20px;">
            <i class="fas fa-question-circle" style="font-size: 3rem; color: #3b82f6; margin-bottom: 15px; display: block;"></i>
            <h5 style="margin: 15px 0 10px; font-weight: 600; color: #1f2937;">${title}</h5>
            <p style="margin: 0; color: #6b7280; font-size: 0.95rem;">${message}</p>
        </div>
        <div style="display: flex; gap: 10px; margin-top: 25px;">
            <button class="btn-cancel" style="
                flex: 1;
                padding: 10px 15px;
                border: 1px solid #e5e7eb;
                background: white;
                color: #374151;
                border-radius: 6px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s ease;
            ">Batal</button>
            <button class="btn-confirm" style="
                flex: 1;
                padding: 10px 15px;
                border: none;
                background: #3b82f6;
                color: white;
                border-radius: 6px;
                font-weight: 500;
                cursor: pointer;
                transition: all 0.2s ease;
            ">Setuju</button>
        </div>
    `;

	backdrop.appendChild(modal);
	document.body.appendChild(backdrop);

	// Add animations
	const style = document.createElement("style");
	style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
	document.head.appendChild(style);

	// Button handlers
	const confirmBtn = modal.querySelector(".btn-confirm");
	const cancelBtn = modal.querySelector(".btn-cancel");

	confirmBtn.addEventListener("click", () => {
		backdrop.remove();
		if (onConfirm) onConfirm();
	});

	cancelBtn.addEventListener("click", () => {
		backdrop.remove();
		if (onCancel) onCancel();
	});

	// Close on backdrop click
	backdrop.addEventListener("click", (e) => {
		if (e.target === backdrop) {
			backdrop.remove();
			if (onCancel) onCancel();
		}
	});

	// Add hover effects
	confirmBtn.addEventListener("mouseover", () => {
		confirmBtn.style.background = "#2563eb";
		confirmBtn.style.transform = "translateY(-2px)";
		confirmBtn.style.boxShadow = "0 4px 12px rgba(59, 130, 246, 0.3)";
	});
	confirmBtn.addEventListener("mouseout", () => {
		confirmBtn.style.background = "#3b82f6";
		confirmBtn.style.transform = "translateY(0)";
		confirmBtn.style.boxShadow = "none";
	});

	cancelBtn.addEventListener("mouseover", () => {
		cancelBtn.style.background = "#f3f4f6";
		cancelBtn.style.borderColor = "#d1d5db";
	});
	cancelBtn.addEventListener("mouseout", () => {
		cancelBtn.style.background = "white";
		cancelBtn.style.borderColor = "#e5e7eb";
	});
}

/**
 * Notify shortcuts
 */
const notify = {
	success: (msg, title) => showNotification(msg, "success", 5000, title),
	error: (msg, title) => showNotification(msg, "error", 5000, title),
	warning: (msg, title) => showNotification(msg, "warning", 5000, title),
	info: (msg, title) => showNotification(msg, "info", 5000, title),
	success_permanent: (msg, title) => showNotification(msg, "success", 0, title),
	error_permanent: (msg, title) => showNotification(msg, "error", 0, title),
};
