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
                    self.selected = response.data.data;
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
                    self.selected = response.data.data;
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
                    self.selected = response.data.data;
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
                    self.selected = response.data.data;
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
                    self.selected = response.data.data;
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
                    self.selected = response.data.data;
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
                    self.selected = response.data.data;
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
     * Transaction Confirmation Dialogue
     *
     * @return {*}
     */
    confirm () {
        let self = this;

        let confirmHtml = '' +
            '<svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" viewBox="-17.5 482.5 36 36" class="login-logo">\n' +
            '  <path id="mbl_logo_1" d="M-.531 500.016h-.631a2.218 2.218 0 0 1-2.23-2.229v-4.292a1.13 1.13 0 0 0-1.135-1.137h-9.55a2.218 2.218 0 0 0-2.23 2.23v7.488a2.217 2.217 0 0 0 2.23 2.229h1.094c.631 0 1.136-.505 1.136-1.136a2.216 2.216 0 0 1 2.229-2.229h9.087a.487.487 0 0 0 .505-.506c0-.207-.211-.418-.505-.418z"/>\n' +
            '  <path id="mbl_logo_2" d="M11.164 488.025h-12.79c-.967 0-1.767.799-1.767 1.768v1.514c0 .589.505 1.095 1.094 1.095h.505c.968 0 1.767.799 1.767 1.767v5.386c0 .294.21.504.504.504h.084c.295 0 .505-.21.505-.504v-1.095c0-.968.8-1.767 1.767-1.767h9.003c.589 0 1.094-.505 1.094-1.094v-5.806c-.041-.969-.798-1.768-1.766-1.768z"/>\n' +
            '  <path id="mbl_logo_3" d="M3.339 508.641c-1.262 0-2.272-1.01-2.272-2.23v-4.922a.485.485 0 0 0-.505-.504H.478a.485.485 0 0 0-.504.504v.631a2.217 2.217 0 0 1-2.23 2.229h-8.499c-.63 0-1.135.506-1.135 1.137v5.258a2.217 2.217 0 0 0 2.23 2.23H2.161a2.217 2.217 0 0 0 2.229-2.23v-1.009c.043-.589-.462-1.094-1.051-1.094z"/>\n' +
            '  <path id="mbl_logo_4" d="M15.119 496.692h-1.094c-.631 0-1.094.505-1.094 1.095 0 1.219-1.01 2.229-2.271 2.229H1.53a.512.512 0 0 0-.505.505c0 .252.21.505.505.505h.631a2.262 2.262 0 0 1 2.271 2.271v4.292c0 .631.505 1.094 1.094 1.094h9.55c1.22 0 2.229-1.01 2.229-2.23v-7.53c.044-1.264-.966-2.231-2.186-2.231z"/>\n' +
            '</svg>' +
            '<h1>Confirm Transaction</h1>' +
            '<p><small>Please confirm that the current transaction is correct.</small></p>' +
            '<ul class="list-group">';

        for (let key in self.data) {
            let value = self.data[key];

            if (value !== null) {
                let name = key.replace('_', ' ').replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});

                confirmHtml = confirmHtml + '<li class="list-group-item">' + name + ' <span>' + self.data[key] + '</span></li>';
            }
        }

        confirmHtml = confirmHtml + '</ul>';

        return window.sweetAlert.fire({
            html: confirmHtml,
            showCancelButton: true,
            confirmButtonColor: '#17abcf',
            cancelButtonColor: '#e3342f',
            confirmButtonText: 'Confirm',
            customClass: {
                container: 'container-transaction-confirm',
                popup: 'popup-transaction-confirm',
                header: 'header-transaction-confirm',
                title: 'title-transaction-confirm',
                closeButton: 'close-button-transaction-confirm',
                icon: 'icon-transaction-confirm',
                image: 'image-transaction-confirm',
                content: 'content-transaction-confirm',
                input: 'input-transaction-confirm',
                actions: 'actions-transaction-confirm',
                confirmButton: 'confirm-button-transaction-confirm',
                cancelButton: 'cancel-button-transaction-confirm',
                footer: 'footer-transaction-confirm'
            }
        });
    }

    /**
     * Convert to Integer
     *
     * @param value
     */
    convertToInteger(value) {

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
