<template>

    <div>
        <div v-if="loaded">

            <div class="section-panel p-3">

                <slot name="body"></slot>

                <div class="form-group">
                    <label class="form-label">Bulk Transaction File</label>

                    <ProductImport
                        :button_name="button_name"
                        :import_description="import_description"
                    >
                        <template v-slot:info>
                            <slot name="info"></slot>
                        </template>
                    </ProductImport>
                </div>

            </div>

        </div>
        <Loading message="Bulk Transaction Loading" v-else></Loading>
    </div>

</template>

<script>
    import ProductImport from "../../../components/product/ProductImport";
    import Loading from "../helpers/Loading";

    export default {
        name: "BulkTransaction",
        props: {
            button_name: {
                type: String,
                default: 'Process Bulk Transaction'
            },
            import_description: {
                type: String,
                default: null
            }
        },
        components: {
            Loading,
            ProductImport
        },
        data() {
            return {
                loaded: false
            }
        },
        mounted() {
            let vm = this;

            setTimeout(function () {
                vm.loaded = true;
            }, 100);
        }
    }
</script>

<style scoped>

</style>
