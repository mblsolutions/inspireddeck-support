<template>
    <div>
        <div v-if="loaded">
            <div class="cursor-pointer" v-if="code && selectedCode">

                <div class="section-panel p-3 border-t-4 text-brand-blue-500 border-brand-blue-500" @click.prevent="toggleShowInfo">
                    <div class="flex py-2">
                        <div class="flex flex-shrink-0 items-center mr-4">
                            <i class="material-icons text-brand-blue-500 text-4xl">credit_card</i>
                        </div>
                        <div class="w-6/12 text-left md:w-4/12">
                            <h5 class="uppercase font-bold" :class="{ 'text-brand-error-500': isInvalid, 'text-teal-500': isActive, 'text-brand-blue-500': isInactive }">
                                {{ selectedCode.status }}
                            </h5>
                            <p class="text-muted" v-if="customer">
                                <span class="text-brand-blue-300 font-bold">{{ customer.name }}</span>
                            </p>
                            <p class="text-muted" v-else>No Customer Data</p>
                        </div>
                        <div class="w-4/12 hidden md:block text-center">
                            <h3>{{ selectedCode.serial }}</h3>
                            <p class="text-muted">{{ selectedCode.display }}</p>
                        </div>
                        <div class="w-6/12 text-right md:w-4/12 md:mr-8">
                            <h4 class="text-xl font-bold">
                                {{ balance }}
                                <span class="font-light text-sm text-brand-blue-300">{{ selectedCode.currency_code }}</span>
                            </h4>
                            <p class="text-muted uppercase">{{ selectedCode.type }}</p>
                        </div>
                    </div>

                    <transition name="cardinfoslide">
                        <div class="hidden md:flex py-2 text-brand-blue-300" v-if="show">
                            <div class="w-2/6 text-left ml-12">
                                <h6 class="text-primary mb-0">{{ selectedCode.asset }}</h6>
                                <p class="text-muted">{{ selectedCode.sku }}</p>
                            </div>
                            <div class="w-2/6 text-center">
                                <div v-if="customer">
                                    <span class="text-brand-blue-300">Reigistered To: {{ customer.name }}</span><br>
                                    <span class="text-muted">
                                        <span class="text-gray-600">Address: </span>
                                        <span v-if="customer.address_1 || customer.postcode">{{ customer.address_1 }} {{ customer.postcode }}</span>
                                        <span v-else>Not Supplied</span>
                                        |
                                        <span class="text-gray-600">D.O.B: </span>
                                        <span v-if="customer.date_of_birth">{{ customer.date_of_birth }}</span>
                                        <span v-else>Not Supplied</span>
                                    </span>
                                </div>
                                <div v-else>
                                    <span class="text-brand-blue-300">Code Not Registered</span>
                                </div>
                            </div>
                            <div class="w-2/6 text-right mr-8">
                                <h6 class="text-primary mb-0">Last Updated</h6>
                                <p class="text-muted">{{ lastUpdated }}</p>
                            </div>
                        </div>
                    </transition>


                </div>

                <div class="section-panel p-3 flex text-sm text-gray-500 items-center">
                    <div class="flex-shrink-0 mr-4">
                        <i class="material-icons text-brand-blue-500 text-2xl">calendar_today</i>
                    </div>
                    <div class="align-self-center w-6/12">
                        <span class="uppercase text-xs">Activation</span><br>
                        <span class="text-brand-blue-500 font-bold text-base">{{ activationDate }}</span>
                        <span class="text-brand-blue-300 font-bold">{{ activationTime }}</span>
                    </div>
                    <div class="align-self-center w-6/12 text-right">
                        <span class="uppercase text-xs">Expiration</span><br>
                        <span class="text-brand-blue-500 font-bold text-base">{{ expirationDate }}</span>
                        <span class="text-brand-blue-300 font-bold">{{ expirationTime }}</span>
                    </div>
                </div>

                <slot name="header"></slot>

                <slot name="transaction"></slot>
            </div>
            <div v-else>
                <div class="section-panel p-3">
                    <NoSelectedCode></NoSelectedCode>
                </div>
            </div>
        </div>
        <Loading message="Inspired Deck Loading" v-else></Loading>
    </div>
</template>

<script>
    import Loading from "../helpers/Loading";
    import NoSelectedCode from "./NoSelectedCode";
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
            Loading,
            NoSelectedCode
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
                let customer = this.code.code.customer;

                if (customer) {
                    return customer;
                }

                return false;
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
                return window.moment(this.selectedCode.updated).format("dddd, MMMM Do YYYY")
            },
            /**
             * Get the codes computed Activation Date
             */
            activationDate() {
                if (this.selectedCode.activation_date) {
                    return window.moment(this.selectedCode.activation_date).format("MMMM Do YYYY")
                }

                return 'Not'
            },
            /**
             * Get the codes computed Activation Date
             */
            activationTime() {
                if (this.selectedCode.activation_date) {
                    return window.moment(this.selectedCode.activation_date).format("h:mm:ss a")
                }

                return 'Applicable';
            },
            /**
             * Get the codes computed Expiration Date
             */
            expirationDate() {
                if (this.selectedCode.expiration_date) {
                    return window.moment(this.selectedCode.expiration_date).format("MMMM Do YYYY")
                }

                return 'Not'
            },
            /**
             * Get the codes computed Expiration Date
             */
            expirationTime() {
                if (this.selectedCode.expiration_date) {
                    return window.moment(this.selectedCode.expiration_date).format("h:mm:ss a")
                }

                return 'Applicable';
            },
            /**
             * Check if Code is Invalid
             *
             * @return {boolean}
             */
            isInvalid() {
                let status = this.selectedCode.status;

                return status === 'expired' || status === 'blocked' || status === 'redeemed';
            },
            /**
             * Check if Code is Active
             *
             * @return {boolean}
             */
            isActive() {
                let status = this.selectedCode.status;

                return status === 'active';
            },
            /**
             * Check if Code is Inactive
             *
             * @return {boolean}
             */
            isInactive() {
                let status = this.selectedCode.status;

                return status === 'inactive';
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
    ul {
        cursor: pointer;
    }

    .cardinfoslide-enter-active {
        -moz-transition-duration: 0.05s;
        -webkit-transition-duration: 0.05s;
        -o-transition-duration: 0.05s;
        transition-duration: 0.05s;
        -moz-transition-timing-function: ease-in;
        -webkit-transition-timing-function: ease-in;
        -o-transition-timing-function: ease-in;
        transition-timing-function: ease-in;
    }

    .cardinfoslide-leave-active {
        -moz-transition-duration: 0.05s;
        -webkit-transition-duration: 0.05s;
        -o-transition-duration: 0.05s;
        transition-duration: 0.05s;
        -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
        -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
        -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
        transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    }

    .cardinfoslide-enter-to, .cardinfoslide-leave {
        max-height: 70px;
        overflow: hidden;
    }

    .cardinfoslide-enter, .cardinfoslide-leave-to {
        overflow: hidden;
        max-height: 0;
    }
</style>
