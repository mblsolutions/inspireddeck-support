<template>
    <div>
        <div v-if="loaded">
            <div v-if="code && selectedCode">
                <div id="selected-code-info" class="my-3 pt-3 pb-0 px-3 bg-white rounded shadow-sm" @click.prevent="toggleShowInfo">
                    <div class="index-row media selected-code-header pb-3">
                        <div class="fa-3x">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="row media-body ml-3 py-3 lh-125">
                            <div class="col-6 col-lg-4 text-left">
                                <h5 class="text-uppercase" :class="'selected-code-status ' + selectedCode.status">
                                    {{ selectedCode.status }}
                                </h5>
                                <small>{{ customer }}</small>
                            </div>
                            <div class="d-none d-lg-block col-lg-4 text-center">
                                <h3>{{ selectedCode.serial }}</h3>
                                <span>{{ selectedCode.display }}</span>
                            </div>
                            <div class="col-6 col-lg-4 text-right">
                                <h4>{{ balance }} <small class="text-primary-lighter">{{ selectedCode.currency_code }}</small></h4>
                                <small class="text-uppercase">{{ selectedCode.type }}</small>
                            </div>
                        </div>
                    </div>
                    <transition name="slide">
                        <div class="index-row media selected-code-body" v-if="show">
                            <div class="fa-3x">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="row ml-3 media-body">
                                <div class="col-6 col-lg-4 text-left">
                                    <h6 class="text-primary mb-0">{{ selectedCode.asset }}</h6>
                                    <small>{{ selectedCode.sku }}</small>
                                </div>
                                <div class="d-none d-lg-block col-lg-4 text-center"></div>
                                <div class="col-6 col-lg-4 text-right">
                                    <h6 class="text-primary mb-0">Last Updated</h6>
                                    <small>{{ lastUpdated }}</small>
                                </div>
                            </div>
                        </div>
                    </transition>
                </div>

                <slot name="header"></slot>

                <slot name="transaction"></slot>
            </div>
            <div v-else>
                <div class="my-3 p-3 bg-white rounded shadow-sm">
                    <no-selected-code></no-selected-code>
                </div>
            </div>
        </div>
        <loading message="Inspired Deck Loading" v-else></loading>
    </div>
</template>

<script>
    import {Code} from "../../app/product/Code";

    export default {
        props: {
            selected_code: {
                type: Object,
                require: false,
                default: function () {
                    return null;
                }
            }
        },
        name: "SelectedCode",
        components: {
            'loading': require('../helpers/Loading').default,
            'no-selected-code': require('../code/NoSelectedCode').default
        },
        data() {
            return {
                code: null,
                loaded: false,
                show: false,
            }
        },
        computed: {
            /**
             * Formatted Balance
             */
            balance() {
                return this.code.formattedBalance(this);
            },
            /**
             * Get Selected Codes Customer Data
             */
            customer() {
                return 'No Customer Data'
            },
            /**
             * Get Selected Code
             *
             * @return {any}
             */
            selectedCode() {
                let vm = this;

                return vm.code.getSelectedCode(vm);
            },
            /**
             * Get the last updated date
             */
            lastUpdated() {
                return window.moment(this.selectedCode.updated).format("dddd, MMMM Do YYYY, h:mm:ss a")
            }
        },
        methods: {
            /**
             * Toggle Show Information
             */
            toggleShowInfo() {
                this.show = ! this.show;
            }
        },
        beforeMount() {
            let vm = this;

            new Promise((resolve) => {
                vm.code = new Code(vm.$root.deck.serial, {
                    new_serial: null
                });

                // If code supplied, do not load it
                if (vm.selected_code) {
                    vm.code.setSelectedCode(vm, vm.selected_code).then(code => {
                        resolve(code);
                    });
                } else {
                    vm.code.loadSelectedCode(vm).then(code => {
                        resolve(code);
                    }).catch(error => {
                        resolve(error);
                    })
                }
            }).then(() => {
                vm.loaded = true;
            });
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
        max-height: 100px;
        overflow: hidden;
    }

    .slide-enter, .slide-leave-to {
        overflow: hidden;
        max-height: 0;
    }
</style>