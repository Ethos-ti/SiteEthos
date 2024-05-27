import { __ } from '@wordpress/i18n';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.hacklabr-read-more-block').forEach((wrapper) => {
        const toggleButton = wrapper.querySelector('.hacklabr-read-more-block__toggle');

        toggleButton.addEventListener('click', (event) => {
            if (wrapper.classList.contains('hacklabr-read-more-block--expanded')) {
                wrapper.classList.remove('hacklabr-read-more-block--expanded');
                toggleButton.textContent = __('Read more', 'hacklabr');
            } else {
                wrapper.classList.add('hacklabr-read-more-block--expanded');
                toggleButton.textContent = __('Read less', 'hacklabr');
            }
        })
    });
})
