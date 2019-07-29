<template>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
        <div v-if="loaded">
            <div class="alert alert-validation" v-if="code.hasErrors()">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ code.getErrorMessage() }}
            </div>

            <div class="form-group">
                <label for="amount">Credit Amount</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" :class="{ 'is-invalid': code.hasError('amount') }"><i class="fas fa-money-bill-wave-alt"></i></label>
                    </div>
                    <input type="text" class="form-control" :class="{ 'is-invalid': code.hasError('amount') }" id="amount" placeholder="Credit Amount" autocomplete="off" required autofocus v-model="code.data.amount">
                </div>

                <small id="amount_help" class="form-text text-muted">
                    The amount to be credited to the code.
                </small>

                <span v-if="code.hasError('amount')" class="alert alert-validation-form-field">
                    {{ code.getError('amount') }}
                </span>
            </div>

            <transaction-form v-model="code.data"></transaction-form>

            <button type="submit" class="btn btn-primary" @click.prevent="credit">Credit Code</button>
        </div>

        <loading message="Loading Credit Code" v-else></loading>
    </div>
</template>

<script>
    import {Code} from "../../app/product/Code";

    export default {
        name: "CreditCode",
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
             * Credit a Code
             */
            credit() {
                let vm = this;

                vm.code.confirm().then(result => {
                    if (result.value) {
                        vm.code.credit().then(() => {
                            window.location.href = '/transactions'
                        });
                    }
                });
            }
        },
        mounted() {
            let vm = this;

            new Promise((resolve) => {
                vm.code = new Code(vm.$root.deck.serial, {
                    amount: null
                });

                resolve(true);
            }).then(response => {
                vm.loaded = response;
            });
        }
    }
</script>