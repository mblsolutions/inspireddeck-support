<template>
    <div class="block w-full text-center py-10">
        <i class="material-icons text-brand-blue-500 text-6xl my-5">
            zoom_in
        </i>
        <h4 class="text-2xl text-brand-blue-500">
            No Code Selected
        </h4>
        <p class="text-gray-500 text-sm mb-10">
            You must select a code before viewing this page
        </p>
        <a href="#" class="brand-btn" @click="toggleExpand">Find Code</a>
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