import swipers from "./base/swipers";
import {addClass, removeClass} from "./utils/classMethods";
import animations from "./base/animations";

document.addEventListener('DOMContentLoaded', () => {
    if(document.querySelector('[data-header]')) {
        let scrollValue = 0
        const header = document.querySelector('[data-header]')
        window.addEventListener('scroll', () => {
            const st = window.scrollY || document.documentElement.scrollTop
            st > scrollValue ? addClass(header, 'hidden') : removeClass(header, 'hidden')
            scrollValue = st === 0 ? 0 : st;
        })
    }
    swipers()
    animations()
})