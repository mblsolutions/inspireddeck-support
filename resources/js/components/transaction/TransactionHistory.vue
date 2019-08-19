<template>
    <div>
        <div id="transaction-history" class="mb-5" v-if="loaded">
            <div v-if="list.length">
                <div v-for="transaction in list">
                    <div class="transaction-block my-2 py-1 px-3 bg-white rounded shadow-sm" >
                        <div class="index-row media">
                            <div class="transaction-icon fa-4x">
                            <span class="fa-layers fa-fw">
                                <i class="fas fa-circle"></i>
                                <i class="icon fas fa-cogs" data-fa-transform="shrink-8" v-if="transaction.action === 'generate'"></i>
                                <i class="icon fas fa-search" data-fa-transform="shrink-8" v-else-if="transaction.action === 'search'"></i>
                                <i class="icon fas fa-balance-scale" data-fa-transform="shrink-8" v-else-if="transaction.action === 'balance'"></i>
                                <i class="icon fas fa-clipboard-check" data-fa-transform="shrink-8" v-else-if="transaction.action === 'issue'"></i>
                                <i class="icon fas fa-plus" data-fa-transform="shrink-8" v-else-if="transaction.action === 'credit'"></i>
                                <i class="icon fas fa-minus" data-fa-transform="shrink-8" v-else-if="transaction.action === 'debit'"></i>
                                <i class="icon fas fa-power-off" data-fa-transform="shrink-8" v-else-if="transaction.action === 'activation'"></i>
                                <i class="icon fas fa-clock" data-fa-transform="shrink-8" v-else-if="transaction.action === 'expiration'"></i>
                                <i class="icon fas fa-certificate" data-fa-transform="shrink-8" v-else-if="transaction.action === 'redeemed'"></i>
                                <i class="icon fas fa-ban" data-fa-transform="shrink-8" v-else-if="transaction.action === 'block'"></i>
                                <i class="icon fas fa-exchange-alt" data-fa-transform="shrink-8" v-else-if="transaction.action === 'transfer'"></i>
                                <i class="icon fas fa-history" data-fa-transform="shrink-8" v-else-if="transaction.action === 'reverse'"></i>
                                <i class="icon fas fa-credit-card" data-fa-transform="shrink-8" v-else></i>
                            </span>
                            </div>
                            <div class="row media-body ml-3 py-3 lh-125">
                                <div class="col-12 col-md-6 text-left">
                                    <h3>
                                        <s v-if="transaction.reversed">{{ transaction.action_name }}</s>
                                        <span v-else>{{ transaction.action_name }}</span>
                                        <small class=" text-danger" v-if="transaction.reversed"><i class="fas fa-history text-danger"></i> REVERSED</small>
                                    </h3>
                                    <h4>{{ transaction.reference }} <span v-if="transaction.external_ref">- {{ transaction.external_ref }}</span></h4>
                                    <small>{{ formatDate(transaction.date) }}</small>
                                </div>
                                <div class="col-12 col-md-6 text-left mt-2 text-md-right mt-md-0">
                                    <h3 class="no-amount-transaction" :class="{ 'credit-transaction': creditTransaction(transaction), 'debit-transaction': debitTransaction(transaction) }">
                                        <span v-if="transaction.action === 'debit'">-</span>{{ formatAmount(transaction.amount, transaction.currency_decimals) }} {{ transaction.currency_code }}
                                    </h3>
                                    <h4><span v-if="transaction.origin_ref">{{ transaction.origin_ref }}</span><span v-else>&nbsp;</span></h4>
                                    <small v-if="transaction.user">{{ transaction.user }}</small>
                                    <small v-else>System</small>
                                </div>
                                <div class="col-12 mt-3" v-if="transaction.comment">
                                    <p class="m-0 transaction-comment">

                                        <i class="fas fa-quote-left mr-2"></i> {{ transaction.comment }} <i class="fas fa-quote-right ml-2"></i>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <infinite-loading @infinite="infiniteHandler">
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
                            <h6 class="text-primary font-weight-bold">No more transactions</h6>
                        </div>
                    </div>
                    <div slot="no-results">
                        <div class="col-12 mt-3">
                            <h6 class="text-primary font-weight-bold">No more transactions</h6>
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
        <div class="my-3 p-3 bg-white rounded shadow-sm" v-else>
            <Loading message="Loading Transactions"></Loading>
        </div>
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

                vm.code.loadMoreTransactions(vm.page).then(data => {
                    let response = data.data;

                    if (response.data.length) {
                        vm.page += 1;
                        vm.list.push(...response.data);
                    }

                    resolve(true);
                });
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
