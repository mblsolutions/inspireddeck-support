<template>
    <div>
        <div class="accordion" id="transaction_form" v-if="loaded">
            <div class="card">
                <div class="card-header" id="transaction_form_head" @click.prevent="toggleShow">
                    <h6 class="font-weight-normal">
                        <i class="fas fa-plus mr-2 text-icon-darker"></i> Transaction References
                        <small class="text-muted">{{ showMessage }}</small>
                    </h6>

                    <input type="hidden" name="reference" class="form-control" :class="{ 'is-invalid': hasError('reference') }" id="transaction_reference" placeholder="Transaction Reference" v-model="data.reference">
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="transaction_form_head" data-parent="#transaction_form" v-if="!hide">
                    <div class="form-group mt-2">
                        <div class="input-group">
                            <label for="transaction_reference">Transaction Ref.</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" :class="{ 'is-invalid': hasError('reference') }"><i class="fas fa-asterisk"></i></label>
                                </div>
                                <div class="form-control" readonly>{{ data.reference }}</div>
                            </div>
                        </div>
                        <span v-if="hasError('reference')" class="alert alert-validation-form-field">{{ getError('reference') }}</span>
                    </div>

                    <div class="row form-group">
                        <div class="col-md-6">
                            <div class="input-group">
                                <label for="transaction_external_ref">External Ref.</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" :class="{ 'is-invalid': hasError('external_ref') }"><i class="fas fa-tag"></i></label>
                                    </div>
                                    <input type="text" name="external_ref" class="form-control" :class="{ 'is-invalid': hasError('external_ref') }" id="transaction_external_ref" placeholder="External Reference" v-model="data.external_ref">
                                </div>
                            </div>
                            <span v-if="hasError('external_ref')" class="alert alert-validation-form-field">{{ getError('external_ref') }}</span>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group">
                                <label for="transaction_origin_ref">Origin Ref.</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" :class="{ 'is-invalid': hasError('origin_ref') }"><i class="fas fa-map-marker"></i></label>
                                    </div>
                                    <input type="text" name="origin_ref" class="form-control" :class="{ 'is-invalid': hasError('origin_ref') }" id="transaction_origin_ref" placeholder="Origin Reference" v-model="data.origin_ref">
                                </div>
                            </div>

                            <span v-if="hasError('origin_ref')" class="alert alert-validation-form-field">{{ getError('origin_ref') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <label for="transaction_comment">Comment</label>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" :class="{ 'is-invalid': hasError('comment') }"><i class="fas fa-quote-left"></i></label>
                                </div>
                                <input type="text" name="comment" class="form-control" :class="{ 'is-invalid': hasError('comment') }" id="transaction_comment" v-model="data.comment" v-on:blur="transactionDataUpdated">
                            </div>
                        </div>
                        <span v-if="hasError('comment')" class="alert alert-validation-form-field">{{ getError('comment') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <loading message="Loading Transaction" v-else></loading>
    </div>
</template>

<script>
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
            'loading': require('../helpers/Loading').default,
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