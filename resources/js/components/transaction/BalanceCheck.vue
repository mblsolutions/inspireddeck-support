<template>
    <div class="section-panel p-3">
        <div v-if="loaded">
            <div class="error-alert" v-if="code.hasErrors()">
                <p class="align-middle font-bold text-base">
                    <i class="material-icons text-sm">error</i> {{ code.getErrorMessage() }}
                </p>
                <ul class="text-sm mt-2" v-if="code.error.errors">
                    <li v-for="error in code.error.errors">{{ error[0] }}</li>
                </ul>
            </div>

            <p class="mb-4 px-2 text-sm text-gray-500">
                Perform a simulated balance check on the code. The PIN field is optional and is only
                present for testing purposes.
            </p>

            <div class="form-group">
                <label class="form-label">PIN</label>
                <input type="text" class="form-control" :class="{ 'is-invalid': code.hasError('pin') }" placeholder="PIN" autocomplete="off" required autofocus v-model="code.data.pin">

                <small id="pin_help" class="text-muted">
                    Optional: The codes PIN
                </small>
            </div>

            <Transaction v-model="code.data"></Transaction>

            <div class="form-group">
                <button type="submit" class="brand-btn" @click.prevent="showTransactionConfirmation">Check Balance</button>
            </div>
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