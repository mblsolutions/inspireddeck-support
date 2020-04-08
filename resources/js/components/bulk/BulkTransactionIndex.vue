<template>

    <div>
        <div class="section-panel" v-if="loaded">

            <slot name="heading"></slot>

            <div v-if="list.length">
                <div class="section-row" v-for="transaction in list">
                    <div class="section-icon">
                        <i class="material-icons material-section-icon">folder</i>
                        <span class="section-icon-pill"
                              :class="{ 'bg-brand-blue-900': transaction.complete,  'bg-teal-500': !transaction.complete && transaction.started, 'bg-brand-error-500': !transaction.started }">
                        {{ transaction.started === false ? 'queued' : null }}
                        {{ transaction.started === true && transaction.complete === false  ? 'processing' : null }}
                        {{ transaction.started === true && transaction.complete === true  ? 'complete' : null }}
                    </span>
                    </div>
                    <div class="w-4/6 ml-6 pt-1">
                        <h4 class="section-title">
                            <i class="material-icons text-sm font-bold text-teal-400" v-if="transaction.synchronous">sync</i>
                            <a href="#">{{ transaction.name }}</a>
                        </h4>
                        <div class="section-description mt-0">
                            <span class="block">{{ transaction.uuid }}</span>
                            <span>Uploaded {{ formatDate(transaction.created_at) }}</span>
                        </div>
                    </div>
                    <div class="w-2/6 justify-end text-right">
                        <div class="text-sm text-brand-blue-400 font-bold">

                            <span class="text-sm">{{ transaction.processed }}</span>
                            <span class="text-xl">/</span>
                            <span class="text-lg text-brand-blue-900">{{ transaction.total }}</span>

                            <button class="brand-btn hidden md:inline-block -mb-4 ml-4" @click.prevent="downloadResponseFile(transaction)" v-if="transaction.complete">
                                Download Response
                            </button>
                            <div class="font-light text-xs">
                                <span class="text-brand-error-300" v-if="!transaction.started">
                                    Scheduled
                                    <span class="text-brand-error-500 text-sm font-bold">{{ humanReadable(transaction.transaction_slot)}}</span>
                                    ({{ formatDate(transaction.transaction_slot, 'YYYY-MM-DD HH:mm') }})
                                </span>
                                    <span class="text-teal-400" v-else-if="transaction.started && !transaction.complete">
                                    Started at
                                    <span class="text-teal-500 text-sm font-bold">{{ formatDate(transaction.transaction_slot, 'YYYY-MM-DD HH:mm') }}</span>
                                </span>
                                <span v-else>&nbsp;</span>
                            </div>
                            <div class="font-light text-muted">
                                Uploaded by <span class="font-bold">{{ transaction.user.name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <InfiniteLoading @infinite="infiniteHandler" v-if="auto_load">
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
                        <div class="col-12 mt-3 pb-3">
                            <h6 class="text-brand-blue-500">No more transactions</h6>
                        </div>
                    </div>
                    <div slot="no-results">
                        <div class="col-12 mt-3 pb-3">
                            <h6 class="text-brand-blue-500">No more transactions</h6>
                        </div>
                    </div>
                </InfiniteLoading>
            </div>
            <div v-else>
                <div class="block w-full text-center py-10">
                    <i class="material-icons text-brand-blue-500 text-6xl my-5">folder</i>
                    <h4 class="text-2xl text-brand-blue-500">
                        Looks like there are no Bulk Transactions
                    </h4>
                    <p class="text-gray-500 text-sm mb-5">
                        Create a new bulk transaction above
                    </p>
                </div>
            </div>
        </div>
        <Loading message="Loading Bulk Transactions" v-else></Loading>
    </div>

</template>

<script>
    import Loading from "../helpers/Loading";
    import SubmitConfirmDialogue from "../helpers/SubmitConfirmDialogue";
    import {BulkTransaction} from "../../app/product/BulkTransaction";
    import InfiniteLoading from 'vue-infinite-loading'

    export default {
        name: "BulkTransactionIndex",
        props: {
            auto_load: {
                type: Boolean,
                default: false
            },
            date_format: {
                type: String,
                default: 'MMMM Do YYYY, h:mm:ss a'
            }
        },
        components: {
            Loading,
            SubmitConfirmDialogue,
            InfiniteLoading
        },
        data() {
            return {
                transaction: null,
                list: [],
                page: 1,
                loaded: false
            }
        },
        methods: {
            /**
             * Download Response File
             *
             * @return {Promise}
             */
            downloadResponseFile(transaction) {
                let vm = this;

                return vm.transaction.downloadBulkResponseFile(transaction.uuid).then(data => {
                    let response = data.data;

                    window.open(response.uri, '_blank');
                });
            },
            /**
             * Infinite Scroll
             *
             * @return {Promise}
             */
            infiniteHandler($state) {
                let vm = this;

                return vm.transaction.loadBulkTransactions(vm.page).then(data => {
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
             * Get a Human Readable Date
             *
             * @return {string}
             */
            humanReadable(date) {
                return window.moment(date).fromNow();
            },
            /**
             * Format Date
             *
             * @param date
             * @param format
             * @return {string}
             */
            formatDate(date, format = null) {
                if (format === null) {
                    format = this.date_format;
                }

                return window.moment(date).format(format);
            },
        },
        mounted() {
            let vm = this;

            new Promise((resolve) => {

                vm.transaction = new BulkTransaction();

                vm.transaction.loadBulkTransactions(vm.page).then(data => {
                    let response = data.data;

                    if (response.data.length) {
                        vm.page += 1;
                        vm.list.push(...response.data);
                    }

                    resolve(true);
                }).catch(error => {
                    console.log(error);
                });
            }).then(result => {
                vm.loaded = result;
            });
        }
    }
</script>

<style scoped>

</style>
