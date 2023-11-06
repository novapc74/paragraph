import {addClass, removeClass} from "../utils/classMethods";

export default function dropdowns() {

    const dropdownInners = [...document.querySelectorAll('[data-dropdown-inner]')]
    dropdownInners.length && dropdownInners.forEach(item => {
        const contentHeight = item.querySelector('[data-dropdown-content]').offsetHeight
        item.style = `--height:${contentHeight}px`
    })

    document.addEventListener('click', (evt) => {
        const target = evt.target.closest('[data-open-dropdown]')
        if (target) {
            const dropdown = target.closest('[data-dropdown]')

            if (dropdown.classList.contains('active')) {
                removeClass(dropdown, 'active')
                if (target.dataset.openText) {
                    target.textContent = target.dataset.openText
                }
            } else {
                addClass(dropdown, 'active')
                if (target.dataset.hideText) {
                    target.textContent = target.dataset.hideText
                }
            }

        }
    })
}

