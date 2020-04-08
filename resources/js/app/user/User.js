import {Form} from "../support/Form";
import {Error} from '../support/Error';

let axios = require('axios');

export class User extends Form {

    /**
     * User
     *
     * @param data
     */
    constructor(data = {}) {
        super();

        this.data = data ? data : {};

        this.response = null;
        this.error = new Error;
    }

    /**
     * Load More Transactions
     *
     * @return {Promise}
     */
    loadUserSettings() {
        let self = this;

        return new Promise(resolve => {
            self.error.reset();

            axios({
                url: '/async/settings/user',
                method: 'get',
                headers: {
                    'Accept': 'application/json'
                }
            }).then(response => {
                self.response = response;

                self.data = response.data.data;

                resolve(true);
            })
        });
    }

    /**
     * Update User Settings
     *
     * @return {Promise}
     */
    updateUserSettings() {
        let self = this;

        return new Promise((resolve, reject) => {
            self.error.reset();

            axios({
                url: '/async/settings/user',
                method: 'patch',
                data: self.data,
                headers: {
                    'Accept': 'application/json'
                }
            }).then(response => {
                self.response = response;

                resolve(true);
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
            });
        });
    }

}
