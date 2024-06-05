import { __ } from '@wordpress/i18n';

function render_gallery() {
    document.querySelectorAll('.video-gallery-wrapper').forEach( videoGallery => {
        let videoItens = videoGallery.querySelectorAll('.embed-template-block');

        if(videoItens.length > 1) {
            videoCopyPolicyFix = videoItens[0].cloneNode(true);

            videoGallery.insertBefore(videoCopyPolicyFix, videoItens[1]);
        } else if (videoItens.length == 1 && videoItens[0].querySelector('.video-excerpt')) {
            videoCopyPolicyFix = videoItens[0].querySelector('.video-excerpt').cloneNode(true);
            videoCopyPolicyFix.classList.add('video-excerpt-show');

            const excerptLimiter = document.createElement('div');
            excerptLimiter.classList.add('scroll-ratio');
            excerptLimiter.classList.add('scroll-ratio-excerpt');

            excerptLimiter.appendChild(videoCopyPolicyFix);

            videoGallery.insertBefore(excerptLimiter, videoItens[0].nextSibling);
        }

        videoItens = videoGallery.querySelectorAll('.embed-template-block');

        if(videoItens.length > 1) {
            const groupedItens = [...videoItens];
            groupedItens.splice(0, 1);

            const groupedItensWrapper = document.createElement('div');
            groupedItensWrapper.classList.add('sidebar-itens');

            const gridScrollLimiter = document.createElement('div');
            gridScrollLimiter.classList.add('scroll-ratio');

            let lastClicked = "";

            groupedItens.forEach(video => {
                const clickableVideoArea = document.createElement('button');
                clickableVideoArea.setAttribute('action', 'expand-main-area');
                clickableVideoArea.appendChild(video);

                clickableVideoArea.onclick = function(e) {
                    if(lastClicked != this) {
                        this.closest('.video-gallery-wrapper').querySelector('.embed-template-block').remove();
                        this.closest('.video-gallery-wrapper').insertBefore(this.querySelector('.embed-template-block').cloneNode(true), gridScrollLimiter);
                    }

                    lastClicked = this;
                }

                groupedItensWrapper.appendChild(clickableVideoArea);
            })

            gridScrollLimiter.appendChild(groupedItensWrapper);
            videoGallery.appendChild(gridScrollLimiter);
        }
    })
}



