import IMask from 'imask/holder'
import 'imask/masked/dynamic'
import 'imask/masked/number'
import 'imask/masked/pattern'

const CURRENCY_MASK = {
    mask: 'R$ num',
    blocks: {
        num: {
            mask: Number,
            mapToRadix: ['.'],
            normalizeZeros: true,
            padFractionalZeros: true,
            radix: ',',
            scale: 2,
            thousandsSeparator: '.',
        },
    },
}

function parseMask (mask) {
    const parts = mask.split('|')
    if (parts.length === 1) {
        if (parts[0] === '__currency__') {
            return CURRENCY_MASK
        } else {
            return { mask: parts[0] }
        }
    } else {
        return { mask: parts.map((part) => ({ mask: part })) }
    }
}

document.querySelectorAll('input[data-mask]').forEach((maskedEl) => {
    const unmaskedEl = document.querySelector(`input#${maskedEl.id.replace('__mask', '')}`)

    const maskPattern = parseMask(maskedEl.dataset.mask)
    const saveMask = maskedEl.hasAttribute('data-save-mask')

    const mask = IMask(maskedEl, maskPattern)
    unmaskedEl._mask = mask
    mask.unmaskedValue = unmaskedEl.value

    maskedEl.addEventListener('change', () => {
        if (saveMask) {
            unmaskedEl.value = mask._value
        } else {
            unmaskedEl.value = mask.unmaskedValue
        }
    })
})

window.setTimeout(() => {
    const searchParams = new URLSearchParams(window.location.search)

    if (searchParams.has('tab')) {
        const initialTab = searchParams.get('tab')

        document.querySelectorAll('.tabs-nav .tab-title[data-title-tab-id]').forEach((tabEl) => {
            if (tabEl.dataset.titleTabId === initialTab) {
                tabEl.classList.add('active')
            } else {
                tabEl.classList.remove('active')
            }
        })

        document.querySelectorAll('.tabs-content .single-tab[data-tab-id]').forEach((tabEl) => {
            if (tabEl.dataset.tabId === initialTab) {
                tabEl.classList.add('active')
                tabEl.style.display = 'block'
            } else {
                tabEl.classList.remove('active')
                tabEl.style.display = 'none'
            }
        })
    }
}, 100)
