<template>
    <div class="section-panel p-3">
        <div class="pb-0" v-if="loaded">
            <div class="error-alert" v-if="code.hasErrors()">
                <p class="align-middle font-bold text-base">
                    <i class="material-icons text-sm">error</i> {{ code.getErrorMessage() }}
                </p>
                <ul class="text-sm mt-2" v-if="code.error.errors">
                    <li v-for="error in code.error.errors">{{ error[0] }}</li>
                </ul>
            </div>

            <p class="mb-4 px-2 text-sm text-gray-500">
                Reverse a transaction made against this code (not all transaction types can be reversed).
            </p>

            <div class="form-group">
                <label class="form-label" for="transaction_reference">Transaction Reference</label>
                <input type="text" class="form-control" :class="{ 'is-invalid': code.hasError('transaction_reference') }" id="transaction_reference" placeholder="Transaction Reference" autocomplete="off" required autofocus v-model="code.data.transaction_reference">

                <small id="transaction_reference_help" class="text-muted">
                    The transaction reference that should be reversed.
                </small>
            </div>

            <Transaction v-model="code.data"></Transaction>

            <button type="submit" class="brand-btn" @click.prevent="showTransactionConfirmation">Reverse Transaction</button>
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
