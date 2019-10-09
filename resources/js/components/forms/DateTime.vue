<template>

    <div>
        <span v-if="error">
            <datetime v-model="date" input-class="form-control form-control-error focus:border-brand-error-200" :title="title" :format="format" :hidden-name="name" :placeholder="title" :type="type" @close="selectedDateTime"></datetime>
        </span>
        <span v-else>
            <datetime v-model="date" input-class="form-control" :title="title" :hidden-name="name" :format="format" :placeholder="title" :type="type" @close="selectedDateTime"></datetime>
        </span>
    </div>

</template>

<script>
    let moment = require('moment');

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
            type: {
                type: String,
                default: 'datetime'
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
        methods: {
            /**
             * Selected DateTime
             *
             * @return void
             */
            selectedDateTime() {
                let date = this.date;

                if (this.type === 'date') {
                    date = moment(this.date).format('YYYY-MM-DD');
                } else if (this.type === 'time') {
                    date = moment(this.date).format('HH:mm:ssZ');
                }

                let payload = {
                    name: this.name,
                    value: date
                };

                console.log(payload);

                this.$emit('input-selected', payload);
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
