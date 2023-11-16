import swipers from "./base/swipers";
import {addClass, removeClass, toggleActiveClass} from "./utils/classMethods";
import animations from "./base/animations";
import dropdowns from "./base/dropdowns";
import {Product} from "./components/Product";
import forms from "./base/forms";
import maps from "./base/maps";
import axios from "axios";
import mobile from "./base/mobile";
import reviews from "./base/reviews";

document.addEventListener('DOMContentLoaded', () => {

    location.hash = location.hash;

    if(document.querySelector('[data-header]')) {
        let scrollValue = 0
        const header = document.querySelector('[data-header]')
        window.addEventListener('scroll', () => {
            const st = window.scrollY || document.documentElement.scrollTop
            st > scrollValue ? addClass(header, 'hidden') : removeClass(header, 'hidden')
            scrollValue = st === 0 ? 0 : st;
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