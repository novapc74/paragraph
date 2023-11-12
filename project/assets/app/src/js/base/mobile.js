import Menu from "../components/Menu";

export default function mobile() {
    const button = document.querySelector('[data-menu-button]'),
        menu = document.querySelector('[data-mobile-menu]'),
        header = document.querySelector('[data-header]'),
        sections = [...document.querySelectorAll('[data-nav-section]')]

    if (button && menu) {
        window.mobileMenu = new Menu(menu, button, sections, header)
    }
}