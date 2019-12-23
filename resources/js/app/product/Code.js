import {Form} from "../support/Form";

let axios = require('axios');

export class Code extends Form {

    /**
     * Code
     *
     * @param serial
     * @param data
     */
    constructor(serial, data = {}) {

        let formData = Object.assign({
            serial: serial,
            reference: 'ID-' + window.moment().format('x'),
            external_ref: null,
            origin_ref: null,
            comment: null
        }, data);

        super(formData);

        this.serial = serial;

        this.code = null;
        this.transactions = [];
    }

    /**
     * Check Balance of Code
     *
     * @return {Promise}
     */
    balance() {
        let self = this;

        return new Promise(resolve => {
            self.request('/async/code/balance', 'post')
                .then(response => {
                    self.selected = response.data;
                    resolve(self.selected);
                });
        });
    }

    /**
     * Issue a Code
     *
     * @return {Promise}
     */
    issue() {
        let self = this;

        if (self.data.activation_date) {
            self.data.activation_date = this.convertDateToISO8601(self.data.activation_date);
        }

        return new Promise(resolve => {
            self.request('/async/code/issue', 'post')
                .then(response => {
                    self.selected = response.data;
                    resolve(self.selected);
                });
        });
    }

    /**
     * Credit a Code
     *
     * @return {Promise}
     */
    credit() {
        let self = this;

        return new Promise(resolve => {
            self.request('/async/code/credit', 'post')
                .then(response => {
                    self.selected = response.data;
                    resolve(self.selected);
                });
        });
    }

    /**
     * Debit a Code
     *
     * @return {Promise}
     */
    debit() {
        let self = this;

        return new Promise(resolve => {
            self.request('/async/code/debit', 'post')
                .then(response => {
                    self.selected = response.data;
                    resolve(self.selected);
                });
        });
    }

    /**
     * Block a Code
     *
     * @return {Promise}
     */
    block() {
        let self = this;

        return new Promise(resolve => {
            self.request('/async/code/block', 'post')
                .then(response => {
                    self.selected = response.data;
                    resolve(self.selected);
                });
        });
    }

    /**
     * Transfer a Code
     *
     * @return {Promise}
     */
    transfer() {
        let self = this;

        if (self.data.activation_date) {
            self.data.activation_date = this.convertDateToISO8601(self.data.activation_date);
        }

        return new Promise(resolve => {
            self.request('/async/code/transfer', 'post')
                .then(response => {
                    self.selected = response.data;
                    resolve(self.selected);
                });
        });
    }

    /**
     * Transfer a Code
     *
     * @return {Promise}
     */
    reverse() {
        let self = this;

        return new Promise(resolve => {
            self.request('/async/code/reverse', 'post')
                .then(response => {
                    self.selected = response.data;
                    resolve(self.selected);
                });
        });
    }

    /**
     * Refresh Code Serial
     *
     * @return {Promise<any>}
     */
    refresh() {
        let self = this;

        return new Promise((resolve) => {
            axios({
                url: '/async/code/refresh/' + self.serial,
                method: 'get',
                headers: {
                    'Accept': 'application/json'
                }
            }).then(response => {
                let code = response.data;

                resolve(code);
            }).catch(error => {
                let response = error.response.data;

                reject(response);
            })
        });
    }

    /**
     * Load More Transactions
     *
     * @param page
     * @return {never}
     */
    loadMoreTransactions(page) {
        let self = this;

        return axios({
            url: '/async/code/transactions/' + self.serial + '/' + page,
            method: 'get',
            headers: {
                'Accept': 'application/json'
            }
        });
    }

    /**
     * Load Selected Code
     *
     * @return {Promise<any>}
     */
    loadSelectedCode(vue_model) {
        let self = this;

        return new Promise((resolve) => {
            if (self.serial) {
                self.refresh().then(code => {
                    resolve(vue_model.$root.selected_code = code);
                });
            } else {
                reject('No Selected Code');
            }
        });
    }

    /**
     * Set Selected Code
     *
     * @param vue_model
     * @param code
     * @return {Promise}
     */
    setSelectedCode(vue_model, code) {
        return new Promise((resolve) => {
            resolve(vue_model.$root.selected_code = code);
        });
    }

    /**
     * Get Selected Code
     *
     * @param vue_model
     * @return {any|null}
     */
    getSelectedCode(vue_model) {
        return vue_model.$root.selected_code;
    }

    /**
     * Get the Formatted Amount
     *
     * @param amount
     * @param decimals
     * @return {number|*}
     */
    formattedAmount(amount, decimals = 0) {
        let formatted_amount = 0;

        if (decimals > 0) {
            amount = Number(amount / this.getConversion(decimals)).toFixed(decimals);
        }

        try {
            formatted_amount = Intl.NumberFormat('en', { style: 'decimals' }).format(amount);
        } catch (error) {
            formatted_amount = amount;
        }

        return formatted_amount;
    }

    /**
     * Format to currency amount
     *
     * @return {number}
     */
    formattedBalance(vue_model) {
        let code = this.getSelectedCode(vue_model);

        let balance = code.balance;
        let decimals = code.currency_decimals;

        return this.formattedAmount(balance, decimals)
    }

    /**
     * Get Decimal Conversion
     *
     * @param decimals
     * @return {string|number}
     */
    getConversion(decimals = 0) {
        if (decimals > 0) {
            let c = "1";

            return c.padEnd((decimals + 1), '0');
        }

        return decimals;
    }

    /**
     * Format Key
     *
     * @param key
     * @return {string}
     */
    formatKey(key) {
        return key.replace('_', ' ').replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});;
    }

}
