import swipers from "./base/swipers";
import {addClass, removeClass} from "./utils/classMethods";
import animations from "./base/animations";
import dropdowns from "./base/dropdowns";
import {Product} from "./components/Product";
import forms from "./base/forms";
import maps from "./base/maps";
import mobile from "./base/mobile";
import reviews from "./base/reviews";

document.addEventListener('DOMContentLoaded', () => {

    if (document.querySelector('[data-header]')) {
        let scrollValue = 0
        const header = document.querySelector('[data-header]')
        window.addEventListener('scroll', () => {
            const st = window.scrollY || document.documentElement.scrollTop
            st > scrollValue ? addClass(header, 'hidden') : removeClass(header, 'hidden')
            scrollValue = st === 0 ? 0 : st;
        })
    }

    if (document.querySelector('[data-back]')) {
        const backBtn = document.querySelector('[data-back]'),
            backBtnWrapper = backBtn.parentElement

        window.scrollY > document.documentElement.scrollHeight / 3 && removeClass(backBtnWrapper, 'hidden')

        backBtn.addEventListener('click', () => {
            window.scrollTo({top: 0, behavior: 'smooth'});
        })

        window.addEventListener('scroll', () => {
            window.scrollY > document.documentElement.scrollHeight / 4 ?
                removeClass(backBtnWrapper, 'hidden') :
                addClass(backBtnWrapper, 'hidden')
        })
    }

    const products = [...document.querySelectorAll('.product-card')]
    products.length && products.forEach(product => new Product(product))

    swipers()
    animations()
    dropdowns()
    forms()
    maps()
    reviews()
    mobile()
})