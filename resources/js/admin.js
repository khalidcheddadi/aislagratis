
window.confirmDelete = (formId, message = '¿Eliminar este registro?') => {
    if (confirm(message)) {
        document.getElementById(formId).submit();
    }
};


const sidebarToggle = document.getElementById('sidebarToggle');
if (sidebarToggle) {
    sidebarToggle.addEventListener('click', () => {
        document.body.classList.toggle('sidebar-open');
    });
}
