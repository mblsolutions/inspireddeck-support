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

            <Transaction v-model="code.data"></Transaction>

            <button type="submit" class="btn btn-primary" @click.prevent="showTransactionConfirmation">Reverse Transaction</button>
        </div>

        <Loading message="Loading Reverse Transaction" v-else></Loading>

        <transition name="fade">
            <TransactionConfirmationModal
                    @user-cancel-transaction="cancelTransaction"
                    @user-confirm-transaction="reverse"
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
        name: "BlockCode",
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
             * Reverse a Code
             */
            reverse() {
                this.show_modal = false;

                this.code.reverse().then(() => {
                    window.location.href = '/transactions'
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
