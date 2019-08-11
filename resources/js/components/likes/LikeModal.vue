<template>
    <transition name="modal" @close="close()">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <div class="modal-header">
                        <slot name="header">
                            <b>Кoму нравится моя анкета</b>
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            <div v-for="like in likeList">
                                <a :href="'/anket/'+like.id">
                                    <img :src="'/images/small/'+like.main_image" height="100">

                                    {{like.name}}
                                </a>
                            </div>
                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="modal-default-button" v-on:click="close()">
                                Закрыть
                            </button>
                        </slot>
                    </div>
                </div>

            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: {
            id: {
                type: '',
                required: true
            }
        },
        mounted() {
            this.getLikeList();
        },
        data() {
            return {
                likeList: ""
            }
        },
        methods: {
            close() {
                this.$emit('closeLikeModalEmit')
            },
            getLikeList() { //список тех, кто поставил мне лайки
                axios.get('/getLikesList', {})
                    .then((response) => {
                        this.likeList = response.data;
                    });
                console.log(this.likeList)
            }
        }
    }
</script>

<style scoped>
    .avatar {
        flex: 1;
        display: flex;
        align-items: center;
    }

    img {
        width: 50px;
        border-radius: 40%;
        margin: 0 auto;
    }


</style>