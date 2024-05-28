document.addEventListener('DOMContentLoaded', () => {
    const dropdowns = document.querySelectorAll('.main-header-lateral__menu-mobile .menu-item-has-children');

    dropdowns.forEach((dropdown) => {
        dropdown.querySelector('a').addEventListener('click', (event) => {
            dropdown.classList.toggle('menu-item--open');
            event.preventDefault();
        });
    });
});
