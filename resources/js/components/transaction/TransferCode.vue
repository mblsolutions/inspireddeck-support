<template>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
        <div class="pb-0" v-if="loaded && code.getSelectedCode">
            <div class="alert alert-validation" v-if="code.hasErrors()">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ code.getErrorMessage() }}
            </div>

            <div class="form-group">

                <label for="new_serial">New Serial</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" :class="{ 'is-invalid': code.hasError('new_serial') }"><i class="fas fa-hashtag"></i></label>
                    </div>
                    <input type="text" class="form-control" :class="{ 'is-invalid': code.hasError('new_serial') }" id="new_serial" placeholder="New Serial Number" autocomplete="off" required autofocus v-model="code.data.new_serial">

                </div>
                <span v-if="code.hasError('new_serial')" class="alert alert-validation-form-field">
                    {{ code.getError('new_serial') }}
                </span>

                <small id="new_serial_help" class="form-text text-muted">
                    The serial number of the new code the transfer should be made to.
                </small>
            </div>

            <div class="form-group">
                <label for="amount">Transfer Amount</label>

                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" :class="{ 'is-invalid': code.hasError('amount') }"><i class="fas fa-money-bill-wave-alt"></i></label>
                    </div>
                    <input type="text" class="form-control" :class="{ 'is-invalid': code.hasError('amount') }" id="amount" placeholder="Transfer Amount" autocomplete="off" required autofocus v-model="code.data.amount">
                </div>

                <small id="amount_help" class="form-text text-muted">
                    The amount to be transferred to the new code (this can be adjusted to handle administration costs).
                </small>

                <span v-if="code.hasError('amount')" class="alert alert-validation-form-field">
                    {{ code.getError('amount') }}
                </span>
            </div>

            <div class="form-group">
                <label for="activation_date">Activation Date</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" :class="{ 'is-invalid': code.hasError('activation_date') }"><i class="fas fa-calendar-day"></i></label>
                    </div>
                    <datetime v-model="code.data.activation_date" format="yyyy-MM-dd HH:mm:ss" input-class="form-control w-100" :class="{ 'is-invalid': code.hasError('activation_date') }" title="Activation Date" id="activation_date" placeholder="Activation Date" type="datetime" @focus="code.resetErrorKey('activation_date')"></datetime>
                </div>
                <span v-if="code.hasError('activation_date')" class="alert alert-validation">
                    {{ code.getError('activation_date') }}
                </span>

                <small class="text-muted">
                    Set the activation date for the new code <strong>(if not date is specified the code will activate immediately)</strong>.
                </small>
            </div>

            <transaction-form v-model="code.data"></transaction-form>

            <button type="submit" class="btn btn-primary" @click.prevent="transfer">Transfer Code</button>
        </div>

        <loading message="Loading Credit Code" v-else></loading>
    </div>
</template>

<script>
    import {Code} from "../../app/product/Code";

    export default {
        name: "TransferCode",
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
             * Transfer a Code
             */
            transfer() {
                let vm = this;

                vm.code.confirm().then(result => {
                    if (result.value) {
                        vm.code.transfer().then(() => {
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
                    new_serial: null,
                    amount: null,
                    activation_date: null
                });

                resolve(true);
            }).then(response => {
                let code = vm.code.getSelectedCode(vm);

                vm.code.data.amount = vm.code.formattedAmount(code.balance, code.currency_decimals);

                return response;

            }).then(response => {
                vm.loaded = response;
            });
        }
    }
</script>