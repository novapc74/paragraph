import {gsap} from 'gsap'
import {ScrollTrigger} from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)
ScrollTrigger.config({ignoreMobileResize: true});

export default function animations() {
    const semicircles = document.querySelector('.semicircles')
    if (semicircles) {
        const words = gsap.utils.toArray('.semicircles__text_center span')
        gsap.to(words, {
            scrollTrigger: {
                trigger: semicircles,
                scrub: true,
                start: `top 60%`,
                end: `+=${window.innerHeight / 1.75}`,
            },
            color: '#0C0C0C',
            ease: "none",
            stagger: 0.1
        })
    }

    const manufacture = document.querySelector('.manufacture')
    if (manufacture) {
        const texts = gsap.utils.toArray('.manufacture p')
        texts.length && texts.forEach(text => {
            gsap.fromTo(text, {
                y: 50,
                opacity: 0,
            }, {
                y: 0,
                opacity: 1,
                scrollTrigger: {
                    trigger: text,
                    start: `top 75%`,
                },
            })
        })
    }
}