<template>
    <div>
        <button type="button" class="btn btn-secondary" v-on:click="showModal = true">Настроить поиск
        </button>
        <ModalComponent v-if="showModal===true" v-on:close="showModal = false"></ModalComponent>
    </div>
</template>

<script>
    import ModalComponent from './ModalComponent.vue';

    export default {
        components: {ModalComponent},
        props: {
            user: {
                type: Object,
                required: false
            },

        },
        mounted() {
            console.log("seach");

        },
        data() {
            return {
                showModal: false
            }
        },
        methods: {
            gitAnket() {

            }
        }
    }

</script>

<style scoped>

</style>