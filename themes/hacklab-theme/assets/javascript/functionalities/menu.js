document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('.main-header-lateral__menu-mobile .menu-item-has-children');
    console.log(dropdowns);

    dropdowns.forEach ( (dropdown) => {

        dropdown.querySelector('a').addEventListener( 'click', (event) => {
            dropdown.classList.toggle ( 'menu-item--open' );
            event.preventDefault();
        })
    })
});

