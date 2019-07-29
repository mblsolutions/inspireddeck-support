<template>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
        <div class="pb-0" v-if="loaded">
            <div class="alert alert-validation" v-if="code.hasErrors()">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ code.getErrorMessage() }}
            </div>

            <div class="form-group">
                <label for="transaction_reference">Transaction Reference</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" :class="{ 'is-invalid': code.hasError('transaction_reference') }"><i class="fas fa-asterisk"></i></label>
                    </div>
                    <input type="text" class="form-control" :class="{ 'is-invalid': code.hasError('transaction_reference') }" id="transaction_reference" placeholder="Transaction Reference" autocomplete="off" required autofocus v-model="code.data.transaction_reference">
                </div>

                <small id="transaction_reference_help" class="form-text text-muted">
                    The transaction reference that should be reversed.
                </small>

                <span v-if="code.hasError('transaction_reference')" class="alert alert-validation-form-field">
                    {{ code.getError('transaction_reference') }}
                </span>
            </div>

            <transaction-form v-model="code.data"></transaction-form>

            <button type="submit" class="btn btn-primary" @click.prevent="block">Reverse Transaction</button>
        </div>

        <loading message="Loading Reverse Transaction" v-else></loading>
    </div>
</template>

<script>
    import {Code} from "../../app/product/Code";

    export default {
        name: "BlockCode",
        components: {
            'loading': require('../helpers/Loading').default,
            'transaction-form': require('./Transaction').default
        },
        data() {
            return {
                code: null,
                loaded: false
            }
        },
        methods: {
            /**
             * Bock a Code
             */
            block() {
                let vm = this;

                vm.code.confirm().then(result => {
                    if (result.value) {
                        vm.code.reverse().then(() => {
                            window.location.href = '/transactions'
                        });
                    }
                });
            }
        },
        mounted() {
            let vm = this;

            new Promise((resolve) => {
                vm.code = new Code(vm.$root.deck.serial);

                resolve(true);
            }).then(response => {
                vm.loaded = response;
            });
        }
    }
</script>
