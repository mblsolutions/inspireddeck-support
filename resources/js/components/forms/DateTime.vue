<template>

    <div>
        <span v-if="error">
            <datetime v-model="date" input-class="form-control form-control-error focus:border-brand-error-200" :title="title" :hidden-name="name" :placeholder="title" type="datetime"></datetime>
        </span>
        <span v-else>
            <datetime v-model="date" input-class="form-control" :title="title" :hidden-name="name" :format="format" :placeholder="title" type="datetime"></datetime>
        </span>
    </div>

</template>

<script>
    export default {
        name: "DateTime.vue",

        props: {
            value: {
                type: String,
                default: null
            },
            title: {
                type: String,
                default: 'Date'
            },
            name: {
                type: String,
                required: true
            },
            format: {
                type: String,
                default: 'y-LL-dd TT'
            },
            error: {
                type: Boolean,
                default: false
            }
        },

        data() {
            return {
                date: null
            }
        },

        mounted() {
            let vm = this;

            vm.date = vm.value
        }
    }
</script>

<style scoped>

</style>