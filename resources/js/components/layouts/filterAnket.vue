<template>
    <div style="z-index: -1">
        Фильтр анкет:
        <input type="checkbox" :checked="filter_enable">
        <seachModal v-if="seachModal" :event="event" @closeSeachModal="closeSeachModal()"
                    @closeNewMessageAlert="closeNewMessageAlert()"></seachModal>
        <button class="btn-primary" v-on:click="openSeachModal()">Настроить поиск</button>

    </div>
</template>

<script>
    import seachModal from '../chat/seachModal'

    export default {
        name: "FilterApp",
        props: {
            user: {
                type: Object,
                required: false
            }
        },
        components: {
            seachModal
        },
        mounted() {
            console.log("filter App")
        },
        data() {
            return {
                filter_enable: false,
                seachModal: false,
            }
                ;
        },
        methods:
            {
                getAllDataForSidePanel() {
                    axios.get('/getalldataforsidepanel', {
                        params: {
                            girl_id: this.girlid
                        }
                    })
                        .then((response) => {
                            var data = response.data;
                            this.filter_enable = data.filter.filter_enable;
                        });
                },
                openSeachModal() {
                    this.seachModal = true;
                },
                closeSeachModal() {
                    console.log("close");
                    this.seachModal = false;
                },
            }
    }
</script>

<style scoped>
    .newmessagemodalclass {
        position: absolute !important;
        top: -100px !important;
        left: -100px !important;
        background-color: yellow !important;
        z-index: 9999;
    }
</style>