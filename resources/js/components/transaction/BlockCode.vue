<template>
    <div class="mt-3 mb-0 px-3 py-0 pb-3 bg-white rounded shadow-sm">
        <div class="pb-0" v-if="loaded">
            <div class="alert alert-validation" v-if="code.hasErrors()">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ code.getErrorMessage() }}
            </div>

            <Transaction v-model="code.data"></Transaction>

            <button type="submit" class="btn btn-primary" @click.prevent="showTransactionConfirmation">Block Code</button>
        </div>

        <Loading message="Loading Credit Code" v-else></Loading>

        <transition name="fade">
            <TransactionConfirmationModal
                    @user-cancel-transaction="cancelTransaction"
                    @user-confirm-transaction="block"
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
             * Bock a Code
             */
            block() {
                this.show_modal = false;

                this.code.block().then(() => {
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