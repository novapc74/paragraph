import Swiper from 'swiper/bundle';
// import {addClass, removeClass} from "../utils/classMethods";

export default function swipers() {

    const hero = document.querySelector('.hero')
    if (hero) {
        new Swiper('.hero__swiper', {
            slidesPerView: 1,
            slideActiveClass: 'hero-slide_active',
            allowTouchMove: false,
            speed: 1500,
            effect: 'fade',
            navigation: {
                disabledClass: 'swiper-button_disabled',
                prevEl: '.hero__navigation .swiper-button_prev',
                nextEl: '.hero__navigation .swiper-button_next'
            },
            pagination: {
                el: '.hero__pagination',
                type: 'fraction',
                // currentClass: 'swiper-pagination-current numeric',
                // totalClass: 'swiper-pagination-total numeric',
                formatFractionCurrent: number => number < 10 ? '0' + number : number,
                formatFractionTotal: number => number < 10 ? '0' + number : number
            },
        })
    }
}