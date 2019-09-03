<template>
    <div class="section-panel p-3">
        <div class="pb-0" v-if="loaded && code.getSelectedCode">
            <div class="error-alert" v-if="code.hasErrors()">
                <p class="align-middle font-bold text-base">
                    <i class="material-icons text-sm">error</i> {{ code.getErrorMessage() }}
                </p>
                <ul class="text-sm mt-2" v-if="code.error.errors">
                    <li v-for="error in code.error.errors">{{ error[0] }}</li>
                </ul>
            </div>

            <p class="mb-4 px-2 text-sm text-gray-500">
                Transfer funds to a new code, blocking this code preventing further transactions.
            </p>

            <div class="form-group">
                <label class="form-label" for="new_serial">New Serial</label>
                <input type="text" class="form-control" :class="{ 'is-invalid': code.hasError('new_serial') }" id="new_serial" placeholder="New Serial Number" autocomplete="off" required autofocus v-model="code.data.new_serial">

                <small id="new_serial_help" class="text-muted">
                    The serial number of the new code the transfer should be made to.
                </small>
            </div>

            <div class="form-group">
                <label class="form-label" for="amount">Transfer Amount</label>
                <input type="text" class="form-control" :class="{ 'is-invalid': code.hasError('amount') }" id="amount" placeholder="Transfer Amount" autocomplete="off" required autofocus v-model="code.data.amount">

                <small id="amount_help" class="text-muted">
                    The amount to be transferred to the new code (this can be adjusted to handle administration costs).
                </small>
            </div>

            <div class="form-group">
                <label class="form-label" for="activation_date">Activation Date</label>
                <datetime v-model="code.data.activation_date" format="yyyy-MM-dd HH:mm:ss" input-class="form-control" :class="{ 'is-invalid': code.hasError('activation_date') }" title="Activation Date" id="activation_date" placeholder="Activation Date" type="datetime" @focus="code.resetErrorKey('activation_date')"></datetime>

                <small class="text-muted">
                    Set the activation date for the new code <strong>(if not date is specified the code will activate immediately)</strong>.
                </small>
            </div>

            <Transaction v-model="code.data"></Transaction>

            <div class="form-group">
                <button type="submit" class="brand-btn" @click.prevent="showTransactionConfirmation">Transfer Code</button>
            </div>
        </div>

        <Loading message="Loading Credit Code" v-else></Loading>

        <transition name="fade">
            <TransactionConfirmationModal
                    @user-cancel-transaction="cancelTransaction"
                    @user-confirm-transaction="transfer"
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
        name: "TransferCode",
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
             * Transfer a Code
             */
            transfer() {
                this.show_modal = false;

                this.code.transfer().then(() => {
                    window.location.href = '/transactions'
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