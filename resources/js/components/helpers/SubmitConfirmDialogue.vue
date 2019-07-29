<template>

    <form :id="getElementId" :method="method" :action="action" enctype="multipart/form-data">
        <slot></slot>

        <button type="submit" :class="button_class" @click.prevent="confirm()">
            {{ button_name }}
        </button>
    </form>

</template>

<script>
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
             * Confirm Button Action
             *
             * @return void
             */
            confirm() {
                let vm = this;

                window.sweetAlert.fire({
                    title: vm.title,
                    text: vm.text,
                    type: vm.type,
                    showCancelButton: true,
                    confirmButtonColor: '#17abcf',
                    cancelButtonColor: '#e3342f',
                    confirmButtonText: 'Confirm'
                }).then(function (result) {

                    if (result.value === true) {
                        document.getElementById(vm.getElementId).submit();
                    }

                });
            }

        }
    }
</script>

<style scoped>

</style>