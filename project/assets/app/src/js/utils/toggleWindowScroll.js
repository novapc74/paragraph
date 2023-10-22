import {addClass, removeClass} from "./classMethods";

export default function toggleWindowScroll(state) {
    state ? removeClass(document.documentElement, 'no-scroll') : addClass(document.documentElement, 'no-scroll')
}