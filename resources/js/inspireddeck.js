import Datetime from 'vue-datetime'

// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'
import InfiniteLoading from 'vue-infinite-loading';

window.moment = require('moment');
window.sweetAlert = require('sweetalert2');
window.Vue = require('vue');

window.Vue.use(InfiniteLoading);
window.Vue.use(Datetime);

const app = new Vue({
    el: '#inspireddeck',
    components: {
        // Code
        'find-code': require('./components/code/FindCode').default,
        'selected-code': require('./components/code/SelectedCode').default,
        // Transaction
        'balance-check': require('./components/transaction/BalanceCheck').default,
        'issue-code': require('./components/transaction/IssueCode').default,
        'credit-code': require('./components/transaction/CreditCode').default,
        'debit-code': require('./components/transaction/DebitCode').default,
        'block-code': require('./components/transaction/BlockCode').default,
        'transfer-code': require('./components/transaction/TransferCode').default,
        'reverse-transaction': require('./components/transaction/ReverseTransaction').default,
        'transaction-history': require('./components/transaction/TransactionHistory').default,
        'transaction-form': require('./components/transaction/Transaction').default,
        // Forms
        'date-time-form': require('./components/forms/DateTime').default,
        // Helpers
        'submit-confirm-dialogue': require('./components/helpers/SubmitConfirmDialogue').default
    },
    data() {
        return {
            deck: null,
            expanded_nav: false,
            show_find_code: false,
            selected_code: null
        }
    },
    methods: {
        /**
         * Toggle expanded navigation
         */
        toggleExpandedNav() {
            this.expanded_nav = ! this.expanded_nav;
        },
        /**
         * Toggle show find code component
         */
        toggleShowFindCode() {
            this.show_find_code = ! this.show_find_code;
        }
    },
    created() {
        // Load inspired deck js object
        this.deck = window.INSPIREDDECK;
    }
});