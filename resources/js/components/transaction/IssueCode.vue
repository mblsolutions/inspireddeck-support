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
                Issuing a code enable its use once activated.
            </p>

            <div class="form-group">
                <label class="form-label" for="amount">Credit Amount</label>
                <input type="text" class="form-control" :class="{ 'is-invalid': code.hasError('amount') }" id="amount" placeholder="Credit Amount" autocomplete="off" required autofocus v-model="code.data.amount" @focus="code.resetErrorKey('amount')">

                <small id="amount_help" class="text-muted">
                    The amount to be credited to the code.
                </small>
            </div>

            <div class="form-group">

                <h2 class="font-bold text-brand-blue-900">Code Activation</h2>

                <p class="text-muted">
                    Overrides the assets configured activation date, selecting activate immediately activates the code immediately on issue.
                </p>
            </div>

            <div class="form-group">
                <label class="checkbox-container">
                    <span class="tracking-wide text-sm font-bold text-gray-600 ml-2">Activate Immediately</span>
                    <input type="checkbox" checked="checked" v-model="code.data.activate_immediately" @focus="code.resetErrorKey('activate_immediately')">
                    <span class="checkmark"></span>
                </label>
            </div>

            <div class="form-group" v-if="!code.data.activate_immediately">
                <label class="form-label" for="amount">Activation Date</label>
                <datetime v-model="code.data.activation_date" format="yyyy-MM-dd HH:mm:ss" input-class="form-control" :class="{ 'focus:border-brand-error-200': code.hasError('activation_date') }" title="Activation Date" placeholder="Activation Date" type="datetime" @focus="code.resetErrorKey('activation_date')"></datetime>
            </div>

            <Transaction v-model="code.data" :errors="code.error.errors"></Transaction>

            <div class="form-group">
                <button type="submit" class="brand-btn" @click.prevent="showTransactionConfirmation">Issue Code</button>
            </div>

        </div>

        <Loading message="Loading Issue Code" v-else></Loading>

        <transition name="fade">
            <TransactionConfirmationModal
                    @user-cancel-transaction="cancelTransaction"
                    @user-confirm-transaction="issue"
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
    import DateTime from "../forms/DateTime";
    import Loading from "../helpers/Loading";
    import Transaction from "./Transaction";
    import TransactionConfirmationModal from "./TransactionConfirmationModal";

    export default {
        name: "IssueCode",
        components: {
            Loading,
            Transaction,
            TransactionConfirmationModal
        },
        data() {
            return {
                code: null,
                date: null,
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
             * Issue a Code
             */
            issue() {
                this.show_modal = false;

                this.code.issue().then(() => {
                    window.location.href = '/transactions'
                });
            }
        },
        mounted() {
            let vm = this;

            new Promise((resolve) => {
                vm.code = new Code(vm.$root.deck.serial, {
                    amount: null,
                    activation_date: null,
                    activate_immediately: false
                });

                resolve(true);
            }).then(response => {
                vm.loaded = response;
            });
        }
    }
</script>