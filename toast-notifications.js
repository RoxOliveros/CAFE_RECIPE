(function (window) {

    function getContainer() {
        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container';
            document.body.appendChild(container);
        }
        return container;
    }

    function showToast(type, title, message, duration = 5000) {
        const container = getContainer();

        const icons = {
            success: '<i class="bi bi-check-circle-fill"></i>',
            error: '<i class="bi bi-x-circle-fill"></i>',
            warning: '<i class="bi bi-exclamation-triangle-fill"></i>',
            info: '<i class="bi bi-info-circle-fill"></i>'
        };

        const toast = document.createElement('div');
        toast.className = `toast-notification ${type}`;
        toast.innerHTML = `
            <div class="toast-icon">${icons[type]}</div>
            <div class="toast-content"> 
                ${title ? `<div class="toast-title">${title}</div>` : ''}
                <div class="toast-message">${message}</div>
            </div>
            <button class="toast-close">&times;</button>
        `;

        toast.querySelector('.toast-close').onclick = () => toast.remove();
        container.appendChild(toast);

        if (duration > 0) {
            setTimeout(() => {
                toast.classList.add('hiding');
                setTimeout(() => toast.remove(), 300);
            }, duration);
        }

        return toast;
    }

    /* =========================
       SHORTCUTS
    ========================= */
    function showSuccess(msg, title = 'Success') {
        return showToast('success', title, msg);
    }

    function showError(msg, title = 'Error') {
        return showToast('error', title, msg);
    }

    function showWarning(msg, title = 'Warning') {
        return showToast('warning', title, msg);
    }

    function showInfo(msg, title = 'Info') {
        return showToast('info', title, msg);
    }

    /* =========================
       LOADING TOAST
    ========================= */
    function showLoading(msg = 'Loading...', title = 'Please wait') {
        const toast = showToast('info', title, msg, 0);
        toast.querySelector('.toast-icon').innerHTML =
            `<div class="spinner-border spinner-border-sm"></div>`;

        return {
            close() {
                toast.classList.add('hiding');
                setTimeout(() => toast.remove(), 300);
            }
        };
    }

    /* =========================
       CONFIRMATION MODAL
    ========================= */
    function showConfirmation(message, onConfirm, onCancel) {
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.innerHTML = `
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>${message}</p>
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-secondary btn-cancel">Cancel</button>
                            <button class="btn btn-danger btn-confirm">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();

        modal.querySelector('.btn-confirm').onclick = () => {
            bsModal.hide();
            onConfirm && onConfirm();
        };

        modal.querySelector('.btn-cancel').onclick = () => {
            bsModal.hide();
            onCancel && onCancel();
        };

        modal.addEventListener('hidden.bs.modal', () => modal.remove());
    }

    /* =========================
       GLOBAL EXPORTS (CRITICAL)
    ========================= */
    window.showToast = showToast;
    window.showSuccess = showSuccess;
    window.showError = showError;
    window.showWarning = showWarning;
    window.showInfo = showInfo;
    window.showLoading = showLoading;
    window.showConfirmation = showConfirmation;

})(window);
