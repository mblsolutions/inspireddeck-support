<template>
    <div>
        <div id="transaction-history" class="section-panel p-3" v-if="loaded">
            <div v-if="list.length">
                <div v-for="transaction in list">

                    <div class="flex px-5 pt-3" :class="{ 'pb-3 border-b-4 border-brand-blue-100': !transaction.comment }">
                        <div class="relative flex-shrink-0 rounded-full h-14 w-14 flex items-center justify-center bg-brand-blue-400">
                            <i class="material-icons material-section-icon" v-if="transaction.reversed">history</i>
                            <i class="material-icons material-section-icon" v-else>
                                {{ transactionIcon(transaction.action) }}
                            </i>
                            <span class="section-icon-pill bg-brand-error-500" v-if="transaction.reversed">
                                reversed
                            </span>
                        </div>
                        <div class="w-4/6 ml-6 pt-1">
                            <div class="section-title">
                                <h2 :class="{ 'text-brand-error-500 line-through': transaction.reversed }">
                                    {{ transaction.action_name }}
                                </h2>

                                <div class="font-light text-sm text-brand-blue-300" :class="{ 'text-brand-error-200': transaction.reversed }">
                                    {{ transaction.reference }} <span v-if="transaction.external_ref">- {{ transaction.external_ref }}</span>
                                </div>

                                <div class="font-light text-muted">
                                    {{ formatDate(transaction.date) }}
                                </div>
                            </div>
                        </div>
                        <div class="w-2/6 justify-end text-right">
                            <div class="text-sm text-brand-blue-300 font-bold">
                                <div :class="{ 'text-teal-400': creditTransaction(transaction), 'text-brand-error-500': debitTransaction(transaction) }">
                                    <span v-if="transaction.action === 'debit'">-</span>
                                    <span class="text-lg" :class="{ 'line-through': transaction.reversed }">
                                       {{ formatAmount(transaction.amount, transaction.currency_decimals) }}
                                   </span>
                                    <span class="text-sm" :class="{ 'text-teal-400': creditTransaction(transaction), 'text-brand-error-300': debitTransaction(transaction) }">{{ transaction.currency_code }}</span>
                                </div>
                                <div class="font-light text-sm text-brand-blue-500">
                                    <span v-if="transaction.origin_ref">{{ transaction.origin_ref }}</span>
                                    <span v-else>&nbsp;</span>
                                </div>
                                <div class="font-light text-muted">
                                    {{ transaction.user ? transaction.user : 'System' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex pb-3 border-b-4 border-brand-blue-100 mt-2" v-if="transaction.comment">
                        <div class="relative flex-shrink-0 rounded-full h-1 w-14 flex items-center justify-center bg-transparent">&nbsp;</div>
                        <div class="flex text-sm px-5 ml-6">
                            <svg class=" h-2 w-2 text-brand-blue-200 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M464 256h-80v-64c0-35.3 28.7-64 64-64h8c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24h-8c-88.4 0-160 71.6-160 160v240c0 26.5 21.5 48 48 48h128c26.5 0 48-21.5 48-48V304c0-26.5-21.5-48-48-48zm-288 0H96v-64c0-35.3 28.7-64 64-64h8c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24h-8C71.6 32 0 103.6 0 192v240c0 26.5 21.5 48 48 48h128c26.5 0 48-21.5 48-48V304c0-26.5-21.5-48-48-48z"></path>
                            </svg>

                            <span class="text-brand-blue-200 font-bold">
                                {{ transaction.comment }}
                            </span>

                            <svg class=" h-2 w-2 text-brand-blue-200 ml-2" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M464 32H336c-26.5 0-48 21.5-48 48v128c0 26.5 21.5 48 48 48h80v64c0 35.3-28.7 64-64 64h-8c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24h8c88.4 0 160-71.6 160-160V80c0-26.5-21.5-48-48-48zm-288 0H48C21.5 32 0 53.5 0 80v128c0 26.5 21.5 48 48 48h80v64c0 35.3-28.7 64-64 64h-8c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24h8c88.4 0 160-71.6 160-160V80c0-26.5-21.5-48-48-48z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <infinite-loading @infinite="infiniteHandler" v-if="autoload">
                    <div slot="spinner">
                        <div class="media text-muted pt-3">
                            <div class="index-no-results col align-self-center text-center">
                                <div class="sk-cube-grid">
                                    <div class="sk-cube sk-cube1"></div>
                                    <div class="sk-cube sk-cube2"></div>
                                    <div class="sk-cube sk-cube3"></div>
                                    <div class="sk-cube sk-cube4"></div>
                                    <div class="sk-cube sk-cube5"></div>
                                    <div class="sk-cube sk-cube6"></div>
                                    <div class="sk-cube sk-cube7"></div>
                                    <div class="sk-cube sk-cube8"></div>
                                    <div class="sk-cube sk-cube9"></div>
                                </div>
                                <h5>Loading</h5>
                            </div>
                        </div>
                    </div>
                    <div slot="no-more">
                        <div class="col-12 mt-3">
                            <h6 class="text-brand-blue-500">No more transactions</h6>
                        </div>
                    </div>
                    <div slot="no-results">
                        <div class="col-12 mt-3">
                            <h6 class="text-brand-blue-500">No more transactions</h6>
                        </div>
                    </div>
                </infinite-loading>
            </div>
            <div v-else>
                <div class="transaction-block my-2 py-1 px-3 bg-white rounded shadow-sm" >
                    <div class="media text-muted pt-3">
                        <div class="index-no-results col align-self-center mx-5 my-5 text-center">
                            <i class="fas fa-list-ul"></i>
                            <h4>There is no transaction history for this code</h4>
                            <p class="px-5">Transactions will only appear when a code has been used.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Loading message="Loading Transactions" v-else></Loading>
    </div>
</template>

<script>
    import {Code} from "../../app/product/Code";
    import Loading from "../helpers/Loading";
    import InfiniteLoading from 'vue-infinite-loading'

    export default {
        name: "TransactionHistory",
        props: {
            serial: {
                type: Number,
                default: null
            },
            date_format: {
                type: String,
                default: 'MMMM Do YYYY, h:mm:ss a'
            },
            autoload: {
                type: Boolean,
                required: false,
                default: true
            },
            transactions: {
                type: Object,
                required: false,
                default: function () {
                    return null;
                }
            }
        },
        data() {
            return {
                code: null,
                loaded: false,
                list: [],
                page: 1
            }
        },
        components: {
            Loading,
            InfiniteLoading
        },
        methods: {
            transactionIcon(action) {
                switch(action) {
                    case 'generate':
                        return 'perm_data_setting';
                    case 'search':
                        return 'search';
                    case 'balance':
                        return 'account_balance_wallet';
                    case 'issue':
                        return 'play_circle_filled';
                    case 'credit':
                        return 'add';
                    case 'debit':
                        return 'remove';
                    case 'activation':
                        return 'new_releases';
                    case 'expiration':
                        return 'watch_later';
                    case 'redeem':
                        return 'card_membership';
                    case 'block':
                        return 'block';
                    case 'transfer':
                        return 'loop';
                    case 'reverse':
                        return 'history';
                    default:
                        return 'credit_card';
                }
            },
            /**
             * Infinite Scroll
             *
             * @return {Promise}
             */
            infiniteHandler($state) {
                let vm = this;

                return vm.code.loadMoreTransactions(vm.page).then(data => {
                    let response = data.data;

                    if (response.data.length) {
                        vm.page += 1;
                        vm.list.push(...response.data);
                        $state.loaded();
                    } else {
                        $state.complete();
                    }
                });
            },
            /**
             * Check if this is a Credit Transaction
             *
             * @return {boolean}
             */
            creditTransaction(transaction) {
                return (transaction.action === 'credit' || transaction.action === 'issue') && transaction.amount > 0;
            },
            /**
             * Check if this is a Debit Transaction
             *
             * @return {boolean}
             */
            debitTransaction(transaction) {
                return transaction.action === 'debit' && transaction.amount > 0;
            },
            /**
             * Format Date
             *
             * @param date
             * @return {string}
             */
            formatDate(date) {
                return window.moment(date).format(this.date_format);
            },
            /**
             * Format Amount
             *
             * @param amount
             * @param decimals
             * @return {string|*}
             */
            formatAmount(amount = 0, decimals = 0) {
                let vm = this;

                return vm.code.formattedAmount(amount, decimals);
            }
        },
        mounted() {
            let vm = this;

            new Promise((resolve) => {
                vm.code = new Code(vm.serial ? vm.serial : vm.$root.deck.serial);

                if (vm.autoload) {
                    vm.code.loadMoreTransactions(vm.page).then(data => {
                        let response = data.data;

                        if (response.data.length) {
                            vm.page += 1;
                            vm.list.push(...response.data);
                        }

                        resolve(true);
                    });
                } else {
                    vm.list.push(...vm.transactions.data);

                    resolve(true);
                    // LOAD SUPPLIED TRANSACTIONS
                }

            }).then(result => {
                vm.loaded = result;
            });
        }
    }
</script>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>
