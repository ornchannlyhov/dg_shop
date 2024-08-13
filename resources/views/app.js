// app.js

document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('.dropdown'); // Select all dropdown containers

    dropdowns.forEach(dropdown => {
        const toggleBtn = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');

        // Toggle dropdown menu on button click
        toggleBtn.addEventListener('click', function () {
            closeAllDropdowns(); // Close other dropdowns
            menu.classList.toggle('hidden');
            menu.classList.toggle('opacity-0');
            menu.classList.toggle('opacity-100');
        });

        // Close dropdown if user clicks outside of it
        window.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target)) {
                menu.classList.add('hidden');
                menu.classList.remove('opacity-100');
                menu.classList.add('opacity-0');
            }
        });
    });

    // Function to close all dropdowns (for handling multiple dropdowns on the page)
    function closeAllDropdowns() {
        dropdowns.forEach(dropdown => {
            const menu = dropdown.querySelector('.dropdown-menu');
            menu.classList.add('hidden');
            menu.classList.remove('opacity-100');
            menu.classList.add('opacity-0');
        });
    }
});
