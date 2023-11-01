import Swiper from 'swiper/bundle';
import leadingZeroFormat from "../utils/leadingZeroFormat";
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
                formatFractionCurrent: leadingZeroFormat,
                formatFractionTotal: leadingZeroFormat
            },
        })
    }

    const paragraph = document.querySelector('.paragraph')
    if (hero) {
        new Swiper('.paragraph__swiper', {
            slidesPerView: 2,
            centeredSlides: true,
            loop: true,
            // slideActiveClass: 'paragraph-slide_active',
            speed: 1500,
            effect: 'creative',
            creativeEffect: {
                limitProgress: 2,
                prev: {
                    translate: ["100%", 0, -1000],
                    shadow: true,
                },
                next: {
                    translate: ["-100%", 0, -1000],
                    shadow: true,
                },
            },
            navigation: {
                disabledClass: 'swiper-button_disabled',
                prevEl: '.paragraph__navigation .swiper-button_prev',
                nextEl: '.paragraph__navigation .swiper-button_next'
            },
            pagination: {
                el: '.paragraph__pagination',
                type: 'fraction',
                // currentClass: 'swiper-pagination-current numeric',
                // totalClass: 'swiper-pagination-total numeric',
                formatFractionCurrent: leadingZeroFormat,
                formatFractionTotal: leadingZeroFormat
            },
        })
    }
}