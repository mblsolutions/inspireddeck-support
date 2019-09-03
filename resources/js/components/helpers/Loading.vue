<template>
    <div class="section-panel p-3">
        <div class="p-20 text-center">
            <div class="sk-cube-grid">
                <div class="sk-cube sk-cube1 bg-brand-blue-500"></div>
                <div class="sk-cube sk-cube2 bg-brand-blue-500"></div>
                <div class="sk-cube sk-cube3 bg-brand-blue-500"></div>
                <div class="sk-cube sk-cube4 bg-brand-blue-500"></div>
                <div class="sk-cube sk-cube5 bg-brand-blue-500"></div>
                <div class="sk-cube sk-cube6 bg-brand-blue-500"></div>
                <div class="sk-cube sk-cube7 bg-brand-blue-500"></div>
                <div class="sk-cube sk-cube8 bg-brand-blue-500"></div>
                <div class="sk-cube sk-cube9 bg-brand-blue-500"></div>
            </div>
            <h5 class="text-gray-500 text-lg">
                {{ message }}
            </h5>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Loading",
        props: {
            message: {
                type: String,
                default: 'Loading'
            }
        },
    }
</script>