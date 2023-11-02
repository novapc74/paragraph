import {gsap} from 'gsap'
import {ScrollTrigger} from 'gsap/ScrollTrigger'

gsap.registerPlugin(ScrollTrigger)
ScrollTrigger.config({ignoreMobileResize: true});

export default function animations() {
    const semicircles = document.querySelector('.semicircles')
    if(semicircles) {
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
}