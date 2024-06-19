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
            radix: ',',
            scale: 2,
            thousandSeparator: '.',
        },
    },
}

function parseMask (mask) {
    const parts = mask.split('|')
    if (parts.length === 1) {
        if (parts[0] === '__currency__') {
            return CURRENCY_MASK
        } else {
            return parts[0]
        }
    } else {
        return parts.map((part) => ({ mask: part }))
    }
}

document.querySelectorAll('input[data-mask]').forEach((maskedEl) => {
    const unmaskedEl = document.querySelector(`input#${maskedEl.id.replace('__mask', '')}`)

    const pattern = parseMask(maskedEl.dataset.mask)

    const mask = IMask(maskedEl, { mask: pattern })
    mask.unmaskedValue = unmaskedEl.value

    maskedEl.addEventListener('change', () => {
        unmaskedEl.value = mask.unmaskedValue
    })
})
