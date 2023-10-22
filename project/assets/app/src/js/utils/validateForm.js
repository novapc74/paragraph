import JustValidate from 'just-validate';
import phoneMask from "./phoneMask";
import {addClass, removeClass} from "./classMethods";

export const validateForm = (form) => {
    const validation = new JustValidate(form, {
        errorFieldCssClass: ['error'],
        errorLabelCssClass: ['default-input__error-text'],
        successFieldCssClass: ['success'],
        validateBeforeSubmitting: false,
    });
    const inputs = [...form.querySelectorAll('input')]

    inputs.forEach(input => {

        input.closest('.default-input') && input.addEventListener('blur', (evt) => {
            const target = evt.currentTarget,
                parent = target.closest('.default-input')
            target.value === '' ? addClass(parent, 'empty') : removeClass(parent, 'empty')
        } )

        if (input.type === 'tel') {
            phoneMask(input)
            validation.addField(input, [
                {
                    rule: 'function',
                    validator: () => {
                        const phone = input.inputmask.unmaskedvalue();
                        return phone.length === 10;
                    },
                    errorMessage: 'Некорректный номер',
                }
            ],)
        }
        if (input.type === 'text') {
            validation.addField(input, [
                {
                    rule: 'required',
                    errorMessage: 'Обязательное поле',
                }
            ],)
        }
        if (input.type === 'checkbox') {
            validation.addField(input, [
                {
                    rule: 'required',
                },
            ], {
                errorLabelStyle: {
                    display: "none",
                }
            })
        }
    })

    return validation
};