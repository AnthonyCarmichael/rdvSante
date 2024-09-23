import './bootstrap';


document.addEventListener('DOMContentLoaded', () => {
    window.addEventListener('open-modal', event => {
        let modalName = event.detail;
        let modal = document.querySelector(`div[name="${modalName}"]`);
        if (modal) {
            modal.show = true; // Active le modal
        }
    });
});