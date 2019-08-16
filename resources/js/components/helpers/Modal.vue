<template>

    <div class="inspired-deck-modal">
        <div :id="id" class="modal fade show d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" :class="{ 'modal-lg': large_modal }" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <slot name="modal_header"></slot>
                        <h5 class="modal-title">
                            <svg class="brand-logo mr-2" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="-17.5 482.5 36 36">
                                <path d="M-.531 500.016h-.631a2.218 2.218 0 0 1-2.23-2.229v-4.292a1.13 1.13 0 0 0-1.135-1.137h-9.55a2.218 2.218 0 0 0-2.23 2.23v7.488a2.217 2.217 0 0 0 2.23 2.229h1.094c.631 0 1.136-.505 1.136-1.136a2.216 2.216 0 0 1 2.229-2.229h9.087a.487.487 0 0 0 .505-.506c0-.207-.211-.418-.505-.418z"/>
                                <path d="M11.164 488.025h-12.79c-.967 0-1.767.799-1.767 1.768v1.514c0 .589.505 1.095 1.094 1.095h.505c.968 0 1.767.799 1.767 1.767v5.386c0 .294.21.504.504.504h.084c.295 0 .505-.21.505-.504v-1.095c0-.968.8-1.767 1.767-1.767h9.003c.589 0 1.094-.505 1.094-1.094v-5.806c-.041-.969-.798-1.768-1.766-1.768z"/>
                                <path d="M3.339 508.641c-1.262 0-2.272-1.01-2.272-2.23v-4.922a.485.485 0 0 0-.505-.504H.478a.485.485 0 0 0-.504.504v.631a2.217 2.217 0 0 1-2.23 2.229h-8.499c-.63 0-1.135.506-1.135 1.137v5.258a2.217 2.217 0 0 0 2.23 2.23H2.161a2.217 2.217 0 0 0 2.229-2.23v-1.009c.043-.589-.462-1.094-1.051-1.094z"/>
                                <path d="M15.119 496.692h-1.094c-.631 0-1.094.505-1.094 1.095 0 1.219-1.01 2.229-2.271 2.229H1.53a.512.512 0 0 0-.505.505c0 .252.21.505.505.505h.631a2.262 2.262 0 0 1 2.271 2.271v4.292c0 .631.505 1.094 1.094 1.094h9.55c1.22 0 2.229-1.01 2.229-2.23v-7.53c.044-1.264-.966-2.231-2.186-2.231z"/>
                            </svg> {{ title }}
                        </h5>
                        <button type="button" class="close" @click="closeModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <slot name="modal_body"></slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="modal_footer"></slot>

                        <button type="button" class="btn btn-primary" @click.prevent="submitModal" v-if="show_submit">{{ submit_name }}</button>
                        <button type="button" class="btn btn-outline-primary" @click.prevent="closeModal" v-if="show_close">{{ close_name }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    </div>

</template>

<script>
    export default {
        name: "Modal",
        props: {
            id: {
                type: String,
                default: () => {
                    return 'model-' + Math.random().toString().replace('0.', '');
                }
            },
            title: {
                type: String,
                default: 'Inspired Deck Modal'
            },
            show_submit: {
                type: Boolean,
                default: true
            },
            submit_name: {
                type: String,
                default: 'Submit'
            },
            show_close: {
                type: Boolean,
                default: true
            },
            close_name: {
                type: String,
                default: 'Close'
            },
            large_modal: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            /**
             * Submit the Modal
             */
            submitModal() {
                this.$emit('submit-inspireddeck-modal', this.id);
            },
            /**
             * Close the Modal
             */
            closeModal() {
                this.$emit('close-inspireddeck-model', this.id)
            }
        },
    }
</script>

<style scoped>
    .btn {
        border-radius: 3px;
        min-width: 100px;
    }
</style>