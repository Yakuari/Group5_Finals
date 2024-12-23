document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.querySelector('.menu-button');
    const sidebar = document.querySelector('.sidebar');

    menuButton.addEventListener('click', () => {
        sidebar.classList.toggle('active'); // Toggle the "active" class on the sidebar
    });

    // Optional: Close the sidebar when clicking outside it
    document.addEventListener('click', (event) => {
        if (!sidebar.contains(event.target) && !menuButton.contains(event.target)) {
            sidebar.classList.remove('active');
        }
    });
});
