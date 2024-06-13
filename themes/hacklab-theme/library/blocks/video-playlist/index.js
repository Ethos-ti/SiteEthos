import { __ } from '@wordpress/i18n';

window.addEventListener("DOMContentLoaded", function () {

	if (!videoPlaylist.cookieYesActive || checkCookieYesConsent()) {
		placeholderToggleActive("remove")
		render_gallery()
	} else {
		placeholderToggleActive("add")
	}

	document.addEventListener("cookieyes_consent_update", function (eventData) {
		const data = eventData.detail;
		if (videoPlaylist.cookieYesActive) {
			if (data.rejected.includes("functional")) {
				placeholderToggleActive("add")
			} else {
				placeholderToggleActive("remove")
				render_gallery()
			}
		} else {
			render_gallery()
		}
	});

})

function render_gallery() {
    console.log('oi');
    document.querySelectorAll('.video-gallery-wrapper').forEach( videoGallery => {
        let videoItens = videoGallery.querySelectorAll('.embed-template-block');

        if(videoItens.length > 1) {
            let videoCopyPolicyFix = videoItens[0].cloneNode(true);

            if(document.querySelector('body').classList.contains('cmplz-status-allow')){
                // plugin cmplz postprocessing fix.
                videoCopyPolicyFix.querySelector('figure > div').classList.remove('cmplz-blocked-content-container', 'cmplz-placeholder-1');
                videoCopyPolicyFix.querySelector('figure .wp-block-embed__wrapper iframe').classList.remove('cmplz-video', 'cmplz-hidden');
            }

            videoGallery.insertBefore(videoCopyPolicyFix, videoItens[1]);
        } else if (videoItens.length == 1 && videoItens[0].querySelector('.video-excerpt')) {
            let videoCopyPolicyFix = videoItens[0].querySelector('.video-excerpt').cloneNode(true);
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
function placeholderToggleActive(toggle = "remove") {
    let placeholders = document.querySelectorAll(".cookieyes-placeholder")

    placeholders.forEach(placeholder => {
        if (toggle == "add") {
            placeholder.classList.add("active")
        } else {
            placeholder.classList.remove("active")
        }
    })
}

function checkCookieYesConsent() {
    var cookies = document.cookie.split(';')
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim()
        if (cookie.startsWith("cookieyes-consent")) {
            var parts = cookie.split(',')
            for (var j = 0; j < parts.length; j++) {
                var part = parts[j].trim()
                if (part.startsWith("functional:yes")) {
                    return true
                }
            }
        }
    }
    return false
}



