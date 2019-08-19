<template>
    <Modal
            title="Confirm Transaction" :large_modal="true" submit_name="Confirm" close_name="Cancel"
            @close-inspireddeck-model="cancelTransaction" @submit-inspireddeck-modal="confirmTransaction"
    >
        <template slot="modal_body">
            <p class="text-muted">
                Please confirm that this transaction is correct, this transaction will be <strong>logged</strong> and
                in some cases may <strong>not be reversible</strong>.
            </p>

            <slot></slot>
        </template>
    </Modal>
</template>

<script>
    import Modal from "../helpers/Modal"

    export default {
        name: "TransactionConfirmationModal",
        components: {
            Modal
        },
        methods: {
            cancelTransaction() {
                this.$emit('user-cancel-transaction');
            },
            confirmTransaction() {
                this.$emit('user-confirm-transaction');
            },
        }
    }
</script>