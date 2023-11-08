import Swiper from "swiper/bundle";
import axios from "axios";
import {addClass, toggleActiveClass} from "../utils/classMethods";

export class Product {
    constructor(product) {
        this.product = product
        this.title = product.querySelector('.product-card__title')
        this.color = product.querySelector('.product-colors__current')
        this.colors = [...product.querySelectorAll('.product-colors__item')]
        this.wb = product.querySelector('[data-market="wb"]')
        this.ozon = product.querySelector('[data-market="ozon"]')
        this.slidesContainer = this.product.querySelector('.product-card-swiper__wrapper')
        this.thumbsContainer = this.product.querySelector('.product-card-thumbs__wrapper')
        this.thumbs = null
        this.swiper = null

        this.init()
    }

    init() {
        this.#initSwipers()
        this.colors.length && this.colors.forEach(color => color.addEventListener('click', evt => {
            const target = evt.currentTarget
            if (!target.classList.contains('active')) {
                this.#fetchProduct(evt.currentTarget)
            }
        }))
    }

    #initSwipers() {
        this.thumbs = new Swiper(this.product.querySelector('.product-card-thumbs'), {
            slidesPerView: 4,
            spaceBetween: 10,
            breakpoints: {
                768: {
                    direction: 'vertical'
                },
                1024: {
                    direction: 'horizontal'
                }
            }
        })
        this.swiper = new Swiper(this.product.querySelector('.product-card-swiper'), {
            slidesPerView: 1,
            effect: 'fade',
            speed: 1500,
            thumbs: {
                swiper: this.thumbs,
                slideThumbActiveClass: 'product-card-thumbs__slide_active'
            }
        })
    }

    async #fetchProduct(color) {
        try {
            const {data} = await axios.get('modification/' + color.dataset.id, {
                headers: {
                    "X-Requested-With": 'XMLHttpRequest'
                }
            })
            if (data) {
                toggleActiveClass(color, this.product, '.product-colors__item', 'active')
                this.title.textContent = data.title
                this.color.textContent = data.color
                this.wb && (this.wb.href = data.marketplaces.wb)
                this.ozon && (this.ozon.href = data.marketplaces.ozon)
                this.#resetSwipers(data.images)
            }
        } catch (e) {
            console.log(e)
        }
    }

    #resetSwipers(images) {
        this.slidesContainer.innerHTML = this.thumbsContainer.innerHTML = ''
        images.forEach(image => {
            const slide =
                `<div class="swiper-slide product-card-swiper__slide">
                    <picture>
                        <source srcset="${image}" type="image/jpeg">
                        <img src="${image}" alt="${this.title}" loading="lazy">
                    </picture>
                </div>`
            const thumb =
                `<div class="swiper-slide product-card-thumbs__slide">
                    <picture>
                        <source srcset="${image}" type="image/jpeg">
                        <img src="${image}" alt="${this.title}" loading="lazy">
                    </picture>
                </div>`
            this.slidesContainer.insertAdjacentHTML('beforeend', slide)
            this.thumbsContainer.insertAdjacentHTML('beforeend', thumb)
        })
        this.swiper.update()
        this.thumbs.update()
        addClass(this.thumbs.slides[this.swiper.activeIndex], 'product-card-thumbs__slide_active')
    }
}