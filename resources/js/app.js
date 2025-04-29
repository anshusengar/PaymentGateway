import './bootstrap'; 
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    const userIcon = document.getElementById('userIcon');
    const dropdownMenu = document.getElementById('userDropdown');

    // Only add event listeners if elements exist
    if (userIcon && dropdownMenu) {
        // Toggle dropdown visibility when the user icon is clicked
        userIcon.addEventListener('click', function (event) {
            event.stopPropagation(); // Prevent the click from propagating to the document
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown if clicked outside of it
        document.addEventListener('click', function (event) {
            if (!userIcon.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    }
});
