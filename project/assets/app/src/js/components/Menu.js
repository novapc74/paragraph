import toggleWindowScroll from "../utils/toggleWindowScroll";
import {addClass, removeClass, toggleActiveClass} from "../utils/classMethods";
import {ScrollTrigger} from 'gsap/ScrollTrigger'

export default class Menu {
    constructor(menu, button, sections, header = null) {
        this.menu = menu
        this.button = button
        this.header = header
        this.links = [...this.menu?.querySelectorAll('[data-nav-link]')]
        this.sections = sections || []
        this.current = null
        this.opened = false

        this.init()
    }

    init() {
        this.button.addEventListener('click', () => {
            this.opened ? this.close() : this.open()
        })
        this.menu.addEventListener('click', (evt) => {
            !evt.target.closest('[data-mobile-inner]') && this.close()
        })
        this.links.length && this.links.forEach(link => {
            link.addEventListener('click', (evt) => {
                toggleActiveClass(evt.currentTarget, this.menu, '[data-nav-link]', 'active')
                this.close()
            })
        })

        if(this.sections) {
            ScrollTrigger.create({
                start: 0,
                end: "max",
                onUpdate: this.update
            });
        }
    }

    close(scroll = true) {
        removeClass(this.button, 'active')
        removeClass(this.menu, 'active')
        removeClass(this.header, 'active')
        scroll && toggleWindowScroll(1)
        this.opened = false
    }

    open() {
        addClass(this.button, 'active')
        addClass(this.menu, 'active')
        addClass(this.header, 'active')
        toggleWindowScroll(0)
        this.opened = true
    }

    update = () => {
        this.sections.forEach(section => {
            if (ScrollTrigger.isInViewport(section, 0.5) && this.current !== section.id) {
                this.current = section.id
                toggleActiveClass(document.querySelector(`[data-nav-link=${this.current}]`), this.menu, '[data-nav-link]', 'active')
            }
        })
    }
}
