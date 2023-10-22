import toggleWindowScroll from "../utils/toggleWindowScroll";
import {addClass, removeClass} from "../utils/classMethods";

export default class Menu {
    constructor(menu, burger, header = null) {
        this.menu = menu
        this.burger = burger
        this.header = header
        this.opened = false

        this.init()
    }

    init() {
        this.burger.addEventListener('click', (evt) => {
            this.opened ? this.close() : this.open()
        })
    }

    close(scroll = true) {
        removeClass(this.burger, 'active')
        removeClass(this.menu, 'active')
        removeClass(this.header, 'active')
        scroll && toggleWindowScroll(1)
        this.opened = false
    }

    open() {
        addClass(this.burger, 'active')
        addClass(this.menu, 'active')
        addClass(this.header, 'active')
        toggleWindowScroll(0)
        this.opened = true
    }
}
