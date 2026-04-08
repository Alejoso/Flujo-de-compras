const toggle = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('adminSidebar');
const overlay = document.getElementById('sidebarOverlay');

function openSidebar() {
    sidebar.classList.add('open');
    overlay.classList.add('open');
}

function closeSidebar() {
    sidebar.classList.remove('open');
    overlay.classList.remove('open');
}

toggle && toggle.addEventListener('click', openSidebar);
overlay && overlay.addEventListener('click', closeSidebar);

const toastEl = document.querySelector('.toast');
toastEl && new bootstrap.Toast(toastEl).show();
