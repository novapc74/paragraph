import Form from "../components/Form";

export default function forms() {
    const forms = [...document.querySelectorAll('[data-form]')]
    if(forms.length) {
        forms.forEach(form => new Form(form))
    }
}