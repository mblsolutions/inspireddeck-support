<template>
    <form method="post" enctype="multipart/form-data" v-if="loaded">

        <a href="#" class="nav-link nav-link-card" :class="{ searching: showFindCode }" @click.prevent="toggleExpand">
            <span v-if="code.selected">
                <i class="fas fa-credit-card"></i>
                <span>{{ code.selected.serial }}</span>
                <small>{{ code.selected.display }}</small>
            </span>
            <span v-else>
                <i class="fas fa-search-plus"></i>
                <span>Find Code</span>
                <small>No Card Selected</small>
            </span>
        </a>
        <transition name="slide">
            <div id="code-search" class="row m-0 p-0" v-if="showFindCode">
                <div class="col-10">
                    <h2><i class="fas fa-search-plus mr-2"></i> Find Code</h2>

                    <span class="code-search-error" v-if="code.hasErrors()">
                        <i class="fas fa-exclamation-triangle"></i> Unable to find code matching search criteria.
                    </span>
                </div>
                <div class="col-2 text-right">
                    <a href="#" @click.prevent="toggleExpand">
                        <i class="fas fa-times close-icon mt-2 mr-3"></i>
                    </a>
                </div>

                <div class="col-12 col-lg-6 py-2">
                    <div class="form-group">
                        <label for="serial_id">Serial</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" :class="{ 'is-invalid': code.hasError('serial') }"><i class="fas fa-hashtag"></i></label>
                            </div>
                            <input type="text" class="form-control" :class="{ 'is-invalid': code.hasError('serial') }" id="serial_id" placeholder="Serial Number" tabindex="1" autocomplete="off" v-model="code.data.serial" @focus="code.resetErrorKey('serial')">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="payment_account_number">PAN</label>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" :class="{ 'is-invalid': code.hasError('pan') }"><i class="fas fa-credit-card"></i></label>
                            </div>
                            <input type="text" class="form-control" :class="{ 'is-invalid': code.hasError('pan') }" id="payment_account_number" placeholder="PAN" tabindex="2" autocomplete="off" v-model="code.data.pan"  @focus="code.resetErrorKey('pan')">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 py-2">
                    <div class="form-group">
                        <label for="serial_id">Find by Customer</label>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" :class="{ 'is-invalid': code.hasError('customer') }"><i class="fas fa-address-card"></i></label>
                            </div>
                            <input type="text" class="form-control" :class="{ 'is-invalid': code.hasError('customer') }" id="find_by_customer" placeholder="Find by Customer" tabindex="1" autocomplete="off" v-model="code.data.customer" @focus="code.resetErrorKey('customer')">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="serial_id">Find by Reference</label>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" :class="{ 'is-invalid': code.hasError('transaction_reference') }"><i class="fas fa-asterisk"></i></label>
                            </div>
                            <input type="text" class="form-control" :class="{ 'is-invalid': code.hasError('transaction_reference') }" id="find_by_transaction_reference" placeholder="Find by Transaction Reference" tabindex="1" autocomplete="off" v-model="code.data.transaction_reference" @focus="code.resetErrorKey('transaction_reference')">
                        </div>
                    </div>
                </div>
                <div class="col py-2 footer">
                    <div class="row px-1">
                        <div class="col-12 text-right">
                            <button class="btn" @click.prevent="search"><i class="fas fa-search"></i> Search</button>
                        </div>
                    </div>
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
        max-height: 276px;
        overflow: hidden;
    }

    .slide-enter, .slide-leave-to {
        overflow: hidden;
        max-height: 0;
    }
</style>