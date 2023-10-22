import axios from "axios";
import {validateForm} from "../utils/validateForm";
import Popup from "./Popup";
import {addClass, removeClass} from "../utils/classMethods";

export default class Form {
    constructor(parent) {
        this.parent = parent
        this.formPopup = null
        this.responsePopup = null
        this.url = `/feedback/${this.parent.dataset.form}`
        this.options = {
            headers: {
                "X-Requested-With": 'XMLHttpRequest'
            }
        }
        this.form = null
        this.validation = null
        this.isError = false
        this.init()
    }

    init() {
        this.getForm()
        const formPopup = this.parent.dataset.popupName && document.querySelector(`[data-modal="${this.parent.dataset.popupName}"]`)
        const responsePopup = this.parent.dataset.responsePopupName && document.querySelector(`[data-modal="${this.parent.dataset.responsePopupName}"]`)
        if (formPopup) {
            const openFn = (evt) => {
                if(evt && evt.target.closest('[data-service]')) {
                    this.form.querySelector('textarea').value = evt.target.closest('[data-service]').dataset.service
                }
            }
            this.formPopup = new Popup(formPopup, { openFn })
        }
        if (responsePopup) {
            const responseTitle = responsePopup.querySelector('.response-popup__title'),
                responseText = responsePopup.querySelector('.response-popup__text')
            const openFn = () => {
                if (this.isError) {
                    addClass(responseTitle, 'hidden')
                    responseText.textContent = 'Что-то пошло не так. Пожалуйста, проверьте введенные данные и попробуйте еще раз. Если ошибка повторяется, пожалуйста, свяжитесь с нами напрямую по телефону для получения дальнейшей помощи. Наша команда будет рада вам помочь!'
                }
            }
            const closeFn = () => {
                if (this.isError) {
                    removeClass(responseTitle, 'hidden')
                    responseText.textContent = 'Мы готовы предоставить вам высококачественные услуги, которые превратят ваши пространства в источник вдохновения и эффективности. Доверьтесь нам, и мы сделаем ваше окружение лучше.'
                }
            }
            this.responsePopup = new Popup(responsePopup, {openFn, closeFn})
        }
    }

    getForm() {
        axios.get(this.url, this.options).then(({data}) => {
            this.parent.innerHTML = data
            this.form = this.parent.querySelector('form')
            this.validate(this.form)
        }).catch(error => console.log(error))
    }

    validate(form) {
        this.validation = validateForm(form)
        this.validation.onSuccess(() => {
            this.send().then(() => {
                this.formPopup && this.formPopup.close()
                this.responsePopup && this.responsePopup.open()
                this.validation.refresh()
            })
        })
    }

    async send() {
        const formData = new FormData(this.form)
        await axios.post(this.url, formData, this.options).then(({data}) => {
            this.isError = !data.success;
            this.getForm()
        }).catch((e) => {
            this.isError = true
            console.log(e)
        })
    }
}