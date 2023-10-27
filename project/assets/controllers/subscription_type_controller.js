import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['results']

    async connect() {
        console.log('start ok')
        this.resultsTarget.innerHTML = await fetch(`/api/feedback/emails`).then(res => res.text());
    }
}