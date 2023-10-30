import swipers from "./base/swipers";
import {addClass, removeClass} from "./utils/classMethods";

document.addEventListener('DOMContentLoaded', () => {
    swipers()
    if(document.querySelector('[data-header]')) {
        let scrollValue = 0
        const header = document.querySelector('[data-header]')
        window.addEventListener('scroll', () => {
            const st = window.scrollY || document.documentElement.scrollTop
            st > scrollValue ? addClass(header, 'hidden') : removeClass(header, 'hidden')
            scrollValue = st === 0 ? 0 : st;
        })
    }
})