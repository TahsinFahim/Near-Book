
    function toggleMenu(button) {
        const submenu = button.nextElementSibling;
        const icon = button.querySelector('svg');

        submenu.classList.toggle('max-h-0');
        submenu.classList.toggle('max-h-96');
        icon.classList.toggle('rotate-180');
    }

