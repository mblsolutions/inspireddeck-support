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

            <Transaction v-model="code.data"></Transaction>

            <button type="submit" class="btn btn-primary" @click.prevent="showTransactionConfirmation">Credit Code</button>
        </div>

        <Loading message="Loading Credit Code" v-else></Loading>

        <transition name="fade">
            <TransactionConfirmationModal
                    @user-cancel-transaction="cancelTransaction"
                    @user-confirm-transaction="credit"
                    v-if="show_modal"
            >
                <table class="table table-sm table-dark">
                    <tbody>
                    <tr v-for="(data, key, index) in code.data">
                        <th scope="row">{{ code.formatKey(key) }}</th>
                        <td>{{ data ? data : '-' }}</td>
                    </tr>
                    </tbody>
                </table>
            </TransactionConfirmationModal>
        </transition>
    </div>
</template>

<script>
    import {Code} from "../../app/product/Code";
    import Loading from "../helpers/Loading";
    import Transaction from "./Transaction";
    import TransactionConfirmationModal from "./TransactionConfirmationModal";

    export default {
        name: "CreditCode",
        components: {
            Loading,
            Transaction,
            TransactionConfirmationModal
        },
        data() {
            return {
                code: null,
                show_modal: false,
                loaded: false
            }
        },
        methods: {
            /**
             * Confirm Transaction
             */
            showTransactionConfirmation() {
                this.show_modal = true;
            },
            /**
             * Cancel Transaction
             */
            cancelTransaction() {
                this.show_modal = false;
            },
            /**
             * Credit a Code
             */
            credit() {
                this.show_modal = false;

                this.code.credit().then(() => {
                    window.location.href = '/transactions'
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