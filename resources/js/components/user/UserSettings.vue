<template>

    <div>
        <div v-if="loaded">
            <div class="success-alert" v-if="success === true">
                <p class="align-middle font-bold text-base">
                    <i class="material-icons text-sm">check_circle</i> User Settings Updated
                </p>
            </div>

            <div class="error-alert mt-4" v-else-if="success === false">
                <p class="align-middle font-bold text-base">
                    <i class="material-icons text-sm">error</i> {{ user.error.message }}
                </p>
                <ul class="text-sm mt-2" v-for="error in user.error.errors">
                    <li>{{ error[0] }}</li>
                </ul>
            </div>

            <div class="section-panel p-3">
                <p class="mb-4 px-2 text-sm text-gray-500">
                    Some info may be visible to other people using Inspired Deck services e.g. performing a transaction against
                    a card will log your name against that transaction. <a href="/privacy" class="text-brand-blue-500">Learn More.</a>
                </p>

                <div class="flex">
                    <div class="form-group w-2/3">
                        <label class="form-label" for="brand">Brand</label>

                        <div class="text-brand-blue-300 font-bold flex items-center">
                            <i class="material-icons text-2xl mr-2 text-brand-blue-500">business</i> {{ user.data.brand }}
                        </div>

                        <small id="brand" class="form-text text-muted">
                            Interactions with Inspired Deck will be limited to your brands products and codes.
                        </small>
                    </div>
                    <div class="flex w-1/3 justify-end">
                        <slot name="avatar"></slot>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="name">Name</label>

                    <input type="text" name="name" class="form-control" :class="{ 'is-invalid': user.error.exists('name') }" id="name" placeholder="Your Name" v-model="user.data.name">

                    <div v-if="user.error.exists('name')" class="invalid-feedback">{{ user.error.get('name') }}</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="name">Email</label>

                    <div class="text-brand-blue-300 font-bold flex items-center">
                        <i class="material-icons text-2xl mr-2 text-brand-blue-500">mail</i> {{ user.data.email }}
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>

                    <p class="mb-4 text-sm text-gray-500">
                        If you would like to update your password, please enter your new password below.
                    </p>

                    <input type="password" name="password" class="form-control" :class="{ 'is-invalid': user.error.exists('password') }" id="password" placeholder="New Password" v-model="user.data.password">

                    <label class="form-label" for="password_confirmation">&nbsp;</label>

                    <input type="password" name="password_confirmation" class="form-control" :class="{ 'is-invalid': user.error.exists('password') }" id="password_confirmation" placeholder="Confirm New Password" v-model="user.data.password_confirmation">

                    <div v-if="user.error.exists('password')" class="invalid-feedback">{{ user.error.get('password') }}</div>

                    <small id="password_confirmation_help" class="form-text text-muted">
                        We recommend that you use at least 8 characters. Don’t use a password from another site, or something too obvious like your pet’s name.
                    </small>
                </div>

                <blockquote>
                    <p>
                        <span class="flex block mb-2 font-bold uppercase"><i class="material-icons mr-3">error_outline</i> Note</span>

                        Updating some settings will not take effect until you logout and log back in e.g. name changes.
                    </p>
                </blockquote>

                <div class="form-group">
                    <label class="form-label" for="role">Role</label>

                    <p class="mb-4 text-sm text-gray-500">
                        Your <span class="font-bold">Role</span> determines what areas of Inspired Deck you have access to.
                    </p>

                    <div class="text-brand-blue-300 font-bold flex items-center" id="role">
                        <i class="material-icons text-2xl mr-2 text-brand-blue-500">verified_user</i> {{ user.data.role }}
                    </div>

                    <small id="asset_bin_help" class="form-text text-muted">
                        Your role is controlled by the Programme Manager, please contact them if you believe your roll is incorrect.
                    </small>
                </div>

                <div class="form-group">
                    <button type="submit" class="brand-btn" @click.prevent="updateSettings">Update Settings</button>
                </div>
            </div>
        </div>
        <Loading message="Loading Settings" v-else></Loading>
    </div>

</template>

<script>
    import Loading from "../helpers/Loading";
    import {User} from "../../app/user/User";

    export default {
        name: "UserSettings",
        components: {
            Loading
        },
        data() {
            return {
                user: null,
                loaded: false,
                success: null
            }
        },
        methods: {
            /**
             * Update User Settings
             */
            updateSettings() {
                let vm = this;

                vm.success = null;

                vm.user.updateUserSettings().then(result => {
                    vm.success = true;

                    vm.topOfPage();
                }).catch(error => {
                    vm.success = false;

                    vm.topOfPage();
                });
            },

            /**
             * Top of Page
             *
             */
            topOfPage() {
                document.body.scrollTop = 0; // For Safari
                document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
            }
        },
        mounted() {
            let vm = this;

            new Promise((resolve) => {
                vm.user = new User();

                vm.user.loadUserSettings().then(result => {

                    resolve(result);
                });
            }).then(result => {
                vm.loaded = result;
            });
        }
    }
</script>

<style scoped>

</style>
