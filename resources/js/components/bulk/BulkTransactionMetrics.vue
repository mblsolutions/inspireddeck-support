<template>

    <div>
        <div class="mx-auto flex px-3 py-4 bg-brand-blue-500 text-white border-b-4 border-brand-blue-900 rounded shadow">
            <div class="flex flex-shrink-0 items-center">
                <i class="material-icons text-4xl">folder</i>
            </div>
            <div class="ml-6 pt-1 w-4/6">
                <h4 class="text-lg leading-tight">Bulk Transactions</h4>
                <p class="text-xs text-brand-blue-200 leading-normal">Perform bulk transactions on codes</p>
            </div>
            <div class="flex w-2/6 justify-end items-center">
                <a href="#"
                   class="rounded-sm border-2 border-white text-sm bg-white text-brand-blue-500 shadow font-bold py-2 px-2 shadow flex items-center"
                   :class="{ 'rounded-sm border-2 text-sm bg-brand-blue-900 border-brand-blue-900 text-white shadow font-bold py-2 px-2 shadow flex items-center': refresh === true }" @click.prevent="toggleRefresh">
                    <i class="material-icons" v-if="refresh">sync</i>
                    <i class="material-icons" v-else>sync_disabled</i>
                </a>
            </div>
        </div>

        <div v-if="haveMetricsLoaded">
            <div class="section-panel p-3">

                <div class="flex">
                    <div class="w-1/3 p-4 border-r border-gray-400">
                        <h3 class="uppercase text-gray-600">Pending Transactions</h3>

                        <span class="block mt-8 text-right text-2xl font-bold text-brand-blue-500">{{ metrics.data.pending }}</span>
                    </div>
                    <div class="w-1/3 p-4 border-gray-400">
                        <h3 class="uppercase text-gray-600">Processing Transactions</h3>

                        <span class="block mt-8 text-right text-2xl font-bold text-brand-blue-500">{{ metrics.data.processing }}</span>
                    </div>
                    <div class="w-1/3 p-4 border-l border-gray-400">
                        <h3 class="uppercase text-gray-600">Completed Transactions</h3>

                        <span class="block mt-8 text-right text-2xl font-bold text-brand-blue-500">
                        <span class="text-lg">{{ metrics.data.completed }}</span>
                        <span class="text-xl">/</span>
                        <span class="text-brand-blue-900">{{ metrics.data.total }}</span>
                    </span>
                    </div>
                </div>

                <hr class="my-3 border-gray-400">

                <div class="flex">
                    <div class="w-1/3 p-4 border-r border-gray-400">
                        <h3 class="uppercase text-gray-600">Pending Jobs</h3>

                        <span class="block mt-8 text-right text-2xl font-bold text-brand-blue-500">
                        <span class="text-lg">{{ metrics.data.pending_jobs }}</span>
                        <span class="text-xl">/</span>
                        <span class="text-brand-blue-900">{{ metrics.data.total_jobs }}</span>
                    </span>
                    </div>
                    <div class="w-1/3 p-4 border-gray-400">
                        <h3 class="uppercase text-gray-600">Processing Jobs</h3>

                        <span class="block mt-8 text-right text-2xl font-bold text-brand-blue-500">
                        <span class="text-lg">{{ metrics.data.processing_jobs }}</span>
                        <span class="text-xl">/</span>
                        <span class="text-brand-blue-900">{{ metrics.data.total_jobs }}</span>
                    </span>
                    </div>
                    <div class="w-1/3 p-4 border-l border-gray-400">
                        <h3 class="uppercase text-gray-600">Estimated Wait</h3>

                        <span class="block mt-8 text-right text-2xl font-bold text-brand-blue-500">{{ metrics.data.estimated_wait }}</span>
                    </div>
                </div>
            </div>

            <div class="block -mt-2 mb-4 mr-2 text-right text-xs text-gray-500">
                This information is collected from the past 7 days, last update <span class="font-bold">{{ metrics.data.last_updated }}</span>
            </div>
        </div>

        <Loading message="Loading Bulk Transaction Metrics" v-else></Loading>
    </div>

</template>

<script>
    import Loading from "../helpers/Loading";
    import {BulkTransaction} from "../../app/product/BulkTransaction";

    export default {
        name: "BulkTransactionMetrics",
        data() {
            return {
                interval: false,
                metrics: false,
                refresh: false,
                loaded: false
            }
        },
        components: {
            Loading
        },
        computed: {
            /**
             * Check to see if Metrics have loaded
             *
             * @return {Boolean}
             */
            haveMetricsLoaded() {
                return this.metrics !== false && this.loaded === true;
            }
        },
        methods: {
            /**
             * Load Metrics
             *
             * @return {Promise}
             */
            loadMetrics() {
                let vm = this;

                return new Promise((resolve) => {
                    vm.transaction = new BulkTransaction();

                    vm.transaction.loadMetrics(vm.page).then(data => {
                        vm.metrics = data.data;

                        resolve(true);
                    }).catch(error => {
                        console.log(error);
                    });
                });
            },
            /**
             * Toggle Auto Refresh of Metrics (off by default)
             */
            toggleRefresh() {
                let vm = this;

                vm.refresh = ! vm.refresh;

                window.localStorage.setItem('bulk_metrics', vm.refresh);

                if (vm.refresh) {
                    vm.interval = setInterval(function () {
                        vm.loadMetrics()
                    }, 10000);
                } else {
                    clearInterval(vm.interval);

                    vm.interval = false;
                }
            }
        },
        mounted() {
            let vm = this;

            new Promise((resolve) => {
                vm.loadMetrics().then(result => {

                    console.log(window.localStorage.getItem('bulk_metrics'));

                    vm.refresh = window.localStorage.getItem('bulk_metrics');

                    resolve(result);
                });
            }).then(result => {
                vm.loaded = result;
            });
        }
    }
</script>

<style scoped>

</style>
