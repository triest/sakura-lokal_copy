<template>

</template>

<script>
    export default {
        props: {
            anketa: {
                type: Object,
                required: true
            }
        },
        data() {
            return {};
        },
        mounted() {
            console.log(this.anketa)
        },
        methods: {},
        components: {}
    }
</script>

<style scoped>

</style>