<template>
    <div>
        <div class="my-5" id="transaction_form" v-if="loaded">
            <div class="card">
                <div id="transaction_form_head" @click.prevent="toggleShow">
                    <h6 class="flex items-center mb-4 font-bold text-brand-blue-900">
                        <i class="material-icons text-brand-blue-300 mr-2" v-if="hide">add</i>
                        <i class="material-icons text-brand-blue-300 mr-2" v-else>clear</i>
                        Transaction References
                        <span class="text-muted ml-2">{{ showMessage }}</span>
                    </h6>

                    <hr>

                    <input type="hidden" name="reference" class="form-control" :class="{ 'form-control-error focus:border-brand-error-200': hasError('reference') }" id="transaction_reference" placeholder="Transaction Reference" v-model="data.reference">
                </div>
                <div id="transaction_form_head_body" v-if="!hide">

                    <p class="py-3 px-2 text-sm text-gray-500">
                        References assigned to this transaction can be used for reporting and searching.
                    </p>

                    <div class="form-group mt-2">
                        <div class="input-group">
                            <label class="form-label" for="transaction_reference">Transaction Reference</label>
                            <div class="form-control p-3" readonly>{{ data.reference }}</div>
                        </div>
                    </div>

                    <div class="md:flex">
                        <div class="form-group md:w-1/2">
                            <label class="form-label" for="transaction_external_ref">External Reference</label>
                            <input type="text" name="external_ref" class="form-control" :class="{ 'form-control-error focus:border-brand-error-200': hasError('external_ref') }" id="transaction_external_ref" placeholder="External Reference" v-model="data.external_ref">
                        </div>

                        <div class="form-group md:w-1/2">
                            <label class="form-label" for="transaction_origin_ref">Origin Reference</label>
                            <input type="text" name="origin_ref" class="form-control" :class="{ 'form-control-error focus:border-brand-error-200': hasError('origin_ref') }" id="transaction_origin_ref" placeholder="Origin Reference" v-model="data.origin_ref">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="transaction_comment">Transaction Comment</label>
                        <input type="text" name="comment" class="form-control" :class="{ 'form-control-error focus:border-brand-error-200': hasError('comment') }" id="transaction_comment" v-model="data.comment" v-on:blur="transactionDataUpdated">
                    </div>
                </div>
            </div>
        </div>
        <loading message="Loading Transaction" v-else></loading>
    </div>
</template>

<script>
    import Loading from "../helpers/Loading";

    export default {
        name: "Transaction",
        props: {
            value: {
                type: Object,
                default: function () {
                    return {
                        reference: 'ID-' + window.moment().format('x'),
                        external_ref: null,
                        origin_ref: null,
                        comment: null
                    }
                },
            },
            errors: {
                default: function () {
                    return [];
                }
            }
        },
        components: {
            Loading
        },
        data() {
            return {
                hide: true,
                data: null,
                loaded: false
            }
        },
        computed: {
            /**
             * Show title message
             *
             * @return {String}
             */
            showMessage() {
                if (!this.hide) {
                    return "(click to hide)";
                }

                return "(click to expand)";
            },
        },
        methods: {
            /**
             * Toggle Show/Hide of transaction block
             */
            toggleShow() {
                this.hide = !this.hide;

                localStorage.setItem('deck_transaction', this.hide);
            },
            /**
             * Transaction Data Updated
             */
            transactionDataUpdated() {
                this.value = this.data;
            },
            /**
             * Check to see if error exists
             *
             * @param key
             * @return {*|boolean}
             */
            hasError(key) {
                return this.errors && this.errors[key];
            },
            /**
             * Get Error
             *
             * @param key
             * @return {*}
             */
            getError(key) {
                if (this.hasError(key)) {
                    return this.errors[key][0];
                }
            }
        },
        mounted() {
            let vm = this;

            new Promise(resolve => {
                let hide = localStorage.getItem('deck_transaction');

                if (hide !== undefined) {
                    vm.hide = JSON.parse(hide);
                }

                vm.data = vm.value;

                resolve();
            }).then(response => {
                vm.loaded = true;
            });
        }
    }
</script>