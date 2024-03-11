import Swiper from "swiper/bundle";
import axios from "axios";
import {addClass, removeClass, toggleActiveClass} from "../utils/classMethods";

export class Product {
    constructor(product) {
        this.product = product
        this.title = this.product.querySelector('.product-card__title')
        this.color = this.product.querySelector('.product-colors__current')
        this.colors = [...this.product.querySelectorAll('.product-colors__item')]
        this.markets = this.product.querySelector('.product-card-marketplaces__list')
        this.marketsWrapper = this.product.querySelector('.product-card__marketplaces')
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
            allowTouchMove: false,
            speed: 1000,
            thumbs: {
                swiper: this.thumbs,
                slideThumbActiveClass: 'product-card-thumbs__slide_active'
            }
        })
    }

    async #fetchProduct(color) {
        try {
            const {data} = await axios.get('/modification/' + color.dataset.id, {
                headers: {
                    "X-Requested-With": 'XMLHttpRequest'
                }
            })
            if (data) {
                toggleActiveClass(color, this.product, '.product-colors__item', 'active')
                this.title.textContent = data.title
                this.color.textContent = data.color
                this.#resetMarketplaces(data.marketplaces)
                this.#resetSwipers(data.images)
            }
        } catch (e) {
            console.log(e)
        }
    }

    #resetMarketplaces(links) {
        if (Object.entries(links).length) {
            this.markets.innerHTML = ''
            removeClass(this.marketsWrapper, 'hidden')
            Object.entries(links).forEach(link => {
                const el = `<li class="product-card-marketplaces__item fade">
                                        <a class="product-card-marketplaces__link product-card-marketplaces__link_${link[0]}" href="${link[1]}" target="_blank"></a>
                                   </li>`
                this.markets.insertAdjacentHTML('beforeend', el)
            })
            return
        }
        addClass(this.marketsWrapper, 'hidden')
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