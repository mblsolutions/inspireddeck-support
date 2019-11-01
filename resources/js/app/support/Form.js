let axios = require('axios');
let {Error} = require('./Error');

export class Form {

    /**
     * Ajax Form
     *
     * @param data
     */
    constructor(data) {
        this.data = data;

        this.response = null;
        this.error = this.resetError();
    }

    /**
     * Get Axios
     *
     * @return Promise
     */
    request(action, method) {
        let self = this;

        return new Promise((resolve, reject) => {
            self.error.reset();

            // Copy object so reference is remove from data updates
            let request_data = Object.assign({}, self.data);

            if (request_data.amount) {
                request_data.amount = (request_data.amount * 100);
            }

            axios({
                url: action,
                method: method,
                data: request_data,
                headers: {
                    'Accept': 'application/json'
                }
            }).then(response => {
                self.response = response;

                resolve(self.response);
            }).catch(error => {
                let response = error.response.data;

                if (response.message === '') {
                    self.error.addMessage('An Error Occurred');
                } else {
                    self.error.addMessage(response.message);
                }

                if (response.errors) {
                    self.error.addErrors(response.errors);
                }

                reject(response);
            })
        });
    }

    /**
     * Check if there are Errors
     *
     * @return {null|boolean}
     */
    hasErrors() {
        if (!this.error) {
            this.resetError();
        }
        return this.error.message || this.error.errors;
    }

    /**
     * Check if Form has Error
     *
     * @param key
     * @return {boolean}
     */
    hasError(key) {
        return this.error.exists(key);
    }

    /**
     * Get Error
     *
     * @param key
     * @return {boolean|string}
     */
    getError(key) {
        return this.error.get(key);
    }

    /**
     * Get the Error Message
     *
     * @return {null|string}
     */
    getErrorMessage() {
        return this.error.message;
    }

    /**
     * Reset Error Key
     *
     * @param key
     * @return this
     */
    resetErrorKey(key) {
        this.error.resetErrorKey(key);

        return this;
    }

    /**
     * Convert Date to ISO8601
     *
     * @param date
     * @return {*}
     */
    convertDateToISO8601(date = null) {
        if (date) {
            let parsed_date = moment(date);

            date = parsed_date.format('YYYY-MM-DDTHH:mm:ssZ');
        }

        return date;
    }

    /**
     * Reset Error
     */
    resetError() {
        this.error = new Error;
    }

}