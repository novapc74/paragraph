import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['results']

    async connect() {
        this.resultsTarget.innerHTML = await fetch(`/api/subscription/type`).then(res => res.text());
    }
}