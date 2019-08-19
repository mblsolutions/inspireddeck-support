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

            <Transaction v-model="code.data"></Transaction>

            <button type="submit" class="btn btn-primary" @click.prevent="showTransactionConfirmation">Check Balance</button>
        </div>

        <Loading message="Loading Balance Check" v-else></Loading>

        <transition name="fade">
            <TransactionConfirmationModal
                    @user-cancel-transaction="cancelTransaction"
                    @user-confirm-transaction="balance"
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
        name: "BalanceCheck",
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
             * Perform a Balance CHeck
             */
            balance() {
                this.show_modal = false;

                this.code.balance().then(() => {
                    window.location.href = '/transactions'
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