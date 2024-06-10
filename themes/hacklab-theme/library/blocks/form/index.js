import IMask from 'imask/holder'
import 'imask/masked/dynamic'
import 'imask/masked/pattern'

document.querySelectorAll('input[data-mask]').forEach((maskedEl) => {
    const unmaskedEl = document.querySelector(`input#${maskedEl.id.replace('__mask', '')}`)
    const maskAttr = maskedEl.dataset.mask.split('|')
    if (maskAttr[0] === '') {
        return
    }

    const pattern = (maskAttr.length === 1) ? maskAttr[0] : maskAttr.map((p) => ({ mask: p }))

    const mask = IMask(maskedEl, {  mask: pattern })
    mask.unmaskedValue = unmaskedEl.value

    maskedEl.addEventListener('change', () => {
        unmaskedEl.value = mask.unmaskedValue
    })
})
