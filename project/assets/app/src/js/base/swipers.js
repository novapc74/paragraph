import Swiper from 'swiper/bundle';
import leadingZeroFormat from "../utils/leadingZeroFormat";
// import {addClass, removeClass} from "../utils/classMethods";

export default function swipers() {

    const hero = document.querySelector('.hero')
    if (hero) {
        new Swiper('.hero__swiper', {
            slidesPerView: 1,
            slideActiveClass: 'hero-slide_active',
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
                formatFractionCurrent: leadingZeroFormat,
                formatFractionTotal: leadingZeroFormat
            },
        })
    }

    const paragraph = document.querySelector('.paragraph')
    if (paragraph) {
        const initialSlide = Math.floor(paragraph.querySelectorAll('.paragraph-swiper__slide').length / 2)
        new Swiper('.paragraph__swiper', {
            slidesPerView: 1,
            initialSlide,
            centeredSlides: true,
            grabCursor: true,
            slideActiveClass: 'paragraph-swiper__slide_active',
            speed: 1000,
            effect: 'coverflow',
            coverflowEffect: {
                rotate: 15,
                stretch: 75,
                depth: 300,
                modifier: 1,
                slideShadows: true,
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
            breakpoints: {
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                }
            },
        })
    }

    const interior = document.querySelector('.interior')
    if (interior) {
        new Swiper('.interior__swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            grabCursor: true,
            slideNextClass: 'interior-slide_next',
            speed: 1000,
            navigation: {
                disabledClass: 'swiper-button_disabled',
                prevEl: '.interior__navigation .swiper-button_prev',
                nextEl: '.interior__navigation .swiper-button_next'
            },
            breakpoints: {
                1024: {
                    slidesPerView: 2,
                }
            }
        })
    }
}