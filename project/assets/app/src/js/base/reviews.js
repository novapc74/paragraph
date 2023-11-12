import axios from "axios";
import {toggleActiveClass} from "../utils/classMethods";

export default function reviews() {
    if(document.querySelector('.reviews')) {
        const reviews = document.querySelector('.reviews__list')
        const pagination = document.querySelector('.reviews__pagination')
        const pages =[...pagination.querySelectorAll('.reviews-pagination__item')]

        pages.length && pages.forEach(page => {
            page.addEventListener('click', async (evt) => {
                const target = evt.currentTarget
                try {
                    const {data} = await axios.get(`review?page=${target.dataset.page}`, {
                        headers: {
                            "X-Requested-With": 'XMLHttpRequest'
                        }
                    })
                    if(data) {
                        toggleActiveClass(target, pagination, '.reviews-pagination__item', 'active')
                        reviews.innerHTML = data
                        reviews.scrollIntoView()
                    }
                } catch (e) {
                    console.log(e)
                }
            })
        })
    }
}