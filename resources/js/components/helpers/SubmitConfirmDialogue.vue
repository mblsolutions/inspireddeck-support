<template>

    <div>
        <form :id="getElementId" :method="method" :action="action" enctype="multipart/form-data">
            <slot></slot>

            <button type="submit" :class="button_class" @click.prevent="confirm()">
                {{ button_name }}
            </button>
        </form>

        <transition name="fade">
            <Modal
                    :id="getElementId" :title="title" v-if="show_modal"
                    @close-inspireddeck-model="closeAction" @submit-inspireddeck-modal="confirmAction"
            >
                <template slot="modal_body">
                    <p>{{ text }}</p>
                </template>
            </Modal>
        </transition>
    </div>

</template>

<script>
    import Modal from "./Modal";

    export default {
        name: "ConfirmDialogue",

        props: {
            id: {
                type: String,
                required: true,
            },
            method: {
                type: String,
                default: 'post'
            },
            action: {
                type: String,
                required: true
            },
            button_name: {
                type: String,
                default: 'Submit'
            },
            button_class: {
                type: String,
                default: 'btn btn-sm btn-outline-danger'
            },
            title: {
                type: String,
                default: 'Are you sure?'
            },
            text: {
                type: String,
                default: 'This action cannot be undone.'
            },
            type: {
                type: String,
                default: 'warning'
            }
        },
        components: {
            Modal
        },
        data() {
            return {
                show_modal: false
            }
        },
        computed: {

            /**
             * Get the Button ID
             *
             * @return String
             */
            getElementId() {
                return 'submitConfirmDialogue' + this.id;
            }

        },

        methods: {
            /**
             * Close Action
             */
            closeAction() {
                this.show_modal = false;
            },
            /**
             * Confirm Action
             */
            confirmAction() {
                document.getElementById(this.getElementId).submit();
            },
            /**
             * Confirm Button Action
             *
             * @return void
             */
            confirm() {
                this.show_modal = true;
            }

        }
    }
</script>

<style scoped>

</style>