import {Form} from "../support/Form";

let axios = require('axios');

export class BulkTransaction extends Form {

    /**
     * Load Metrics
     *
     * @return {*}
     */
    loadMetrics() {
        return axios({
            url: '/async/bulk/transactions/metrics',
            method: 'get',
            headers: {
                'Accept': 'application/json'
            }
        });
    }

    /**
     * Load Bulk Transactions
     *
     * @param page
     * @return {*}
     */
    loadBulkTransactions(page) {
        return axios({
            url: '/async/bulk/transactions/' + page,
            method: 'get',
            headers: {
                'Accept': 'application/json'
            }
        });
    }

    /**
     * Download Bulk Download Response File
     *
     * @param id
     * @return {*}
     */
    downloadBulkResponseFile(id) {
        return axios({
            url: '/async/bulk/transactions/' + id + '/export',
            method: 'get',
            headers: {
                'Accept': 'application/json'
            }
        });
    }


}
