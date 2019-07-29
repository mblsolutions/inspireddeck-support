<template>
    <div class="mt-3 mb-0 px-3 py-0 pb-3 bg-white rounded shadow-sm">
        <div class="pb-0" v-if="loaded">
            <div class="alert alert-validation" v-if="code.hasErrors()">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ code.getErrorMessage() }}
            </div>

            <transaction-form v-model="code.data"></transaction-form>

            <button type="submit" class="btn btn-primary" @click.prevent="block">Block Code</button>
        </div>

        <loading message="Loading Credit Code" v-else></loading>
    </div>
</template>

<script>
    import {Code} from "../../app/product/Code";

    export default {
        name: "BlockCode",
        components: {
            'loading': require('../helpers/Loading').default,
            'transaction-form': require('./Transaction').default
        },
        data() {
            return {
                code: null,
                loaded: false
            }
        },
        methods: {
            /**
             * Bock a Code
             */
            block() {
                let vm = this;

                vm.code.confirm().then(result => {
                    if (result.value) {
                        vm.code.block().then(() => {
                            window.location.href = '/transactions'
                        });
                    }
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