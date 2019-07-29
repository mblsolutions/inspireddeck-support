<template>
    <div class="media text-muted pt-3">
        <div class="index-no-results col align-self-center mx-5 my-5 text-center">
            <i class="fas fa-search-plus"></i>
            <h4>No Code Selected</h4>
            <p class="px-5">You must select a code before viewing this page</p>
            <a href="#" class="btn btn-primary" @click="toggleExpand">Find Code</a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NoSelectedCode",
        methods: {
            /**
             * Toggle Expand Find Code Component
             */
            toggleExpand() {
                this.$root.toggleShowFindCode();
            },
        }
    }
</script>