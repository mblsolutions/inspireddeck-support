<template>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
        <div v-if="loaded">
            <div class="alert alert-validation" v-if="code.hasErrors()">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ code.getErrorMessage() }}
            </div>

            <div class="form-group">
                <label for="pin">PIN</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" :class="{ 'is-invalid': code.hasError('pin') }"><i class="fas fa-key"></i></label>
                    </div>
                    <input type="text" class="form-control" :class="{ 'is-invalid': code.hasError('pin') }" id="pin" placeholder="PIN" autocomplete="off" required autofocus v-model="code.data.pin">
                </div>

                <small id="pin_help" class="form-text text-muted">
                    <span>Optional:</span> The codes PIN.
                </small>

                <span v-if="code.hasError('amount')" class="alert alert-validation">
                    {{ code.getError('amount') }}
                </span>
            </div>

            <transaction-form v-model="code.data"></transaction-form>

            <button type="submit" class="btn btn-primary" @click.prevent="debit">Check Balance</button>
        </div>

        <loading message="Loading Balance Check" v-else></loading>
    </div>
</template>

<script>
    import {Code} from "../../app/product/Code";

    export default {
        name: "DebitCode",
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
            debit() {
                let vm = this;

                vm.code.confirm().then(result => {
                    if (result.value) {
                        vm.code.balance().then(() => {
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
                    pin: null
                });

                resolve(true);
            }).then(response => {
                vm.loaded = response;
            });
        }
    }
</script>