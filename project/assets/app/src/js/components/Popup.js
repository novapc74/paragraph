import toggleWindowScroll from "../utils/toggleWindowScroll";
import {addClass, removeClass} from "../utils/classMethods";

export default class Popup {
    constructor(popup, callback = null) {
        this.popup = popup
        this.name = this.popup.dataset.modal
        this.overlay = this.popup.querySelector('.default-popup__overlay')
        this.closeBtn = this.popup.querySelector('.default-popup__close-btn')
        this.cancelBtn = this.popup.querySelector('.default-popup__cancel-btn')

        this.openFn = callback && callback?.openFn
        this.closeFn = callback && callback?.closeFn

        this.init()
    }

    init() {
        const closeItems = [this.overlay, this.closeBtn, this.cancelBtn]

        document.addEventListener('click', evt => {
            if(evt.target.closest(`[data-open-modal="${this.name}"]`)) this.#handleOpenPopup(evt)
            if(evt.target.closest(`[data-close-modal="${this.name}"]`)) this.#handleClosePopup(evt)
        })

        closeItems.forEach(el => {
            el && el.addEventListener('click', evt => this.#handleClosePopup(evt))
        })
    }
    #handleOpenPopup(evt) {
        evt.preventDefault()
        window.mobileMenu && window.mobileMenu.close(false)
        this.open(evt)
    }
    #handleClosePopup(evt) {
        evt.preventDefault()
        this.close(evt)
    }
    open(evt = null) {
        this.popup.style.display = 'block'
        setTimeout(() => addClass(this.popup, 'active'))
        toggleWindowScroll(0)
        this.openFn && this.openFn(evt)
    }
    close(evt = null) {
        removeClass(this.popup, 'active')
        setTimeout(() => (this.popup.style.display = 'none'), 400)
        toggleWindowScroll(1)
        this.closeFn && this.closeFn(evt)
    }
}