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
                    <input type="text" class="form-control" :class="{ 'is-invalid': code.hasError('amount') }" id="amount" placeholder="Credit Amount" autocomplete="off" required autofocus v-model="code.data.amount" @focus="code.resetErrorKey('amount')">
                </div>
                <span v-if="code.hasError('amount')" class="alert alert-validation-form-field">
                    {{ code.getError('amount') }}
                </span>

                <small id="amount_help" class="form-text text-muted">
                    The amount to be credited to the code.
                </small>
            </div>

            <hr>

            <div class="form-group mb-0">
                <label>Code Activation</label>
                <p class="text-muted">
                    Overrides the assets configured activation date, selecting activate immediately activates the code immediately on issue.
                </p>
            </div>

            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input" :class="{ 'is-invalid': code.hasError('activate_immediately') }" id="activate_immediately" v-model="code.data.activate_immediately" @focus="code.resetErrorKey('activate_immediately')">
                <label class="form-check-label" for="activate_immediately">Activate Immediately</label>
            </div>

            <div class="form-group">
                <span v-if="code.hasError('activate_immediately')" class="alert alert-validation">
                    {{ code.getError('activate_immediately') }}
                </span>
            </div>

            <div class="form-group" v-if="!code.data.activate_immediately">
                <label for="amount">Activation Date</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <label class="input-group-text" :class="{ 'is-invalid': code.hasError('activation_date') }"><i class="fas fa-calendar-day"></i></label>
                    </div>
                    <datetime v-model="code.data.activation_date" format="yyyy-MM-dd HH:mm:ss" input-class="form-control w-100" :class="{ 'is-invalid': code.hasError('activation_date') }" title="Activation Date" placeholder="Activation Date" type="datetime" @focus="code.resetErrorKey('activation_date')"></datetime>
                </div>
                <span v-if="code.hasError('activation_date')" class="alert alert-validation">
                    {{ code.getError('activation_date') }}
                </span>
            </div>

            <Transaction v-model="code.data" :errors="code.error.errors"></Transaction>

            <button type="submit" class="btn btn-primary" @click.prevent="showTransactionConfirmation">Issue Code</button>
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