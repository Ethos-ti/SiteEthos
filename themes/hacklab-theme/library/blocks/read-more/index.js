import { __ } from '@wordpress/i18n';

document.addEventListener('DOMContentLoaded', () => {
    const EXPANDED_CLASS = 'hacklabr-read-more-block--expanded';

    document.querySelectorAll('.hacklabr-read-more-block').forEach((wrapper) => {
        const toggleButton = wrapper.querySelector('.hacklabr-read-more-block__toggle');

        toggleButton.addEventListener('click', (event) => {
            if (wrapper.classList.contains(EXPANDED_CLASS)) {
                wrapper.classList.remove(EXPANDED_CLASS);
                toggleButton.textContent = __('Read more', 'hacklabr');
            } else {
                wrapper.classList.add(EXPANDED_CLASS);
                toggleButton.textContent = __('Read less', 'hacklabr');
            }
        });
    });
});
