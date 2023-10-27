import './bootstrap';
import { Application } from '@hotwired/stimulus'

const application = Application.start()
application.register('textarea-autogrow', TextareaAutogrow)

document.querySelectorAll('.form-group_smart').forEach(smartRow => {
    placeholderLabel(smartRow)
})