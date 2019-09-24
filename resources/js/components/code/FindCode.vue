<template>
    <form method="post" enctype="multipart/form-data" v-if="loaded">
        <div class="max-w-sm mx-auto flex items-center cursor-pointer" @click.prevent="toggleExpand">
            <div class="flex items-center">
                <i class="material-icons text-4xl" v-if="code.selected">credit_card</i>
                <i class="material-icons text-4xl" v-else>zoom_in</i>
            </div>
            <div class="ml-2 hidden md:block">
                <h4 class="leading-tight">
                    <span v-if="code.selected">{{ code.selected.serial }}</span>
                    <span v-else>Find Code</span>
                </h4>
                <p class="leading-normal text-brand-blue-200">
                    <span v-if="code.selected">{{ code.selected.display }}</span>
                    <span v-else>No Code Selected</span>
                </p>
            </div>
        </div>
        <transition name="slide">
            <div class="absolute w-full top-32 left-0 right-0 border-t-4 border-brand-blue-900 shadow" v-if="showFindCode">
                <div class="p-2 bg-white">
                    <div class="error-alert" v-if="code.hasErrors()">
                        <div class="flex">
                            <div class="flex font-bold text-base items-center w-11/12">
                                <i class="material-icons mr-1">zoom_in</i> Unable to find code.
                            </div>
                            <div class="flex w-1/3 text-brand-error-500 justify-end items-center w-1/12">
                                <i class="material-icons cursor-pointer" @click.prevent="toggleExpand">close</i>
                            </div>
                        </div>
                        <ul class="text-sm mt-2">
                            <li v-for="error in code.error.errors">{{ error[0] }}</li>
                        </ul>
                    </div>
                    <div class="flex border-b border-gray-200 mb-2"  v-else>
                        <h1 class="flex w-2/3 text-brand-blue-900 font-bold p-2 items-center text-base">
                            <i class="material-icons mr-1">zoom_in</i> Find Code
                        </h1>

                        <div class="flex w-1/3 text-brand-blue-900 justify-end items-center" >
                            <i class="material-icons cursor-pointer" @click.prevent="toggleExpand">close</i>
                        </div>
                    </div>

                    <div class="md:flex">
                        <div class="form-group w-full md:w-1/2">
                            <label class="form-label">Serial</label>
                            <input type="text" class="form-control" :class="{ 'form-control-error focus:border-brand-error-200': code.hasError('serial') }" placeholder="Code Serial" v-model="code.data.serial" autocomplete="off">
                        </div>
                        <div class="form-group w-full md:w-1/2">
                            <label class="form-label">PAN</label>
                            <input type="text" class="form-control" :class="{ 'form-control-error focus:border-brand-error-200': code.hasError('pan') }" placeholder="Code PAN" v-model="code.data.pan" autocomplete="off">
                        </div>
                    </div>

                    <div class="md:flex">
                        <div class="form-group w-full md:w-1/2">
                            <label class="form-label">Find by Customer</label>
                            <input type="text" class="form-control" :class="{ 'form-control-error focus:border-brand-error-200': code.hasError('customer') }" placeholder="Find by Customer" v-model="code.data.customer" autocomplete="off">
                        </div>
                        <div class="form-group w-full md:w-1/2">
                            <label class="form-label">Find by Reference</label>
                            <input type="text" class="form-control" :class="{ 'form-control-error focus:border-brand-error-200': code.hasError('transaction_reference') }" placeholder="Find by Reference" v-model="code.data.transaction_reference" autocomplete="off">
                        </div>
                    </div>
                </div>

                <div class="flex w-full bg-brand-blue-500 p-2 text-left justify-end border-b-4 border-brand-blue-900">
                    <a href="#" class="brand-btn mr-3 flex items-center" @click.prevent="toggleExpand">
                        <i class="material-icons">keyboard_arrow_up</i>
                    </a>
                    <button class="white-btn" @click.prevent="search">
                        Find Code
                    </button>
                </div>

                <div class="bg-transparent h-screen flex" style="background: rgba(0,0,0,.7);" @click.prevent="toggleExpand">
                    &nbsp;
                </div>
            </div>

        </transition>
    </form>
</template>

<script>
    import {FindCode} from "../../app/product/FindCode";

    export default {
        props: {
            selected: {
                type: Object,
                default: null
            },
            redirect: {
                type: String,
                default: '/transactions'
            }
        },
        name: "FindCode",
        data() {
            return {
                data: {
                    serial: null,
                    pan: null,
                    customer: null,
                    transaction_reference: null,
                    reference: null
                },
                code: null,
                loaded: false
            }
        },
        computed: {
            /**
             * Show Find Code Form
             *
             * @returns {string}
             */
            showFindCode() {
                return this.$root.show_find_code;
            }
        },
        methods: {
            /**
             * Toggle Expand Search Fields
             */
            toggleExpand() {
                this.code.resetError();

                this.$root.toggleShowFindCode();
            },
            /**
             * Search for a FindCode
             */
            search() {
                let vm = this;

                vm.code.search().then(response => {
                    vm.toggleExpand();
                }).then(response => {
                    window.location.href = vm.redirect;
                });
            }
        },
        mounted() {
            let vm = this;

            vm.data.reference = 'ID-' + window.moment().format('x');

            new Promise(resolve => {
                let code = new FindCode(vm.data, vm.selected);

                resolve(code);
            }).then(code => {
                vm.code = code;
            }).then(function () {
                vm.loaded = true;
            })
        }
    }
</script>

<style scoped>
    .slide-enter-active {
        -moz-transition-duration: 0.3s;
        -webkit-transition-duration: 0.3s;
        -o-transition-duration: 0.3s;
        transition-duration: 0.3s;
        -moz-transition-timing-function: ease-in;
        -webkit-transition-timing-function: ease-in;
        -o-transition-timing-function: ease-in;
        transition-timing-function: ease-in;
    }

    .slide-leave-active {
        -moz-transition-duration: 0.3s;
        -webkit-transition-duration: 0.3s;
        -o-transition-duration: 0.3s;
        transition-duration: 0.3s;
        -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
        -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
        -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
        transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    }

    .slide-enter-to, .slide-leave {
        max-height: 800px;
        overflow: hidden;
    }

    .slide-enter, .slide-leave-to {
        overflow: hidden;
        max-height: 0;
    }
</style>