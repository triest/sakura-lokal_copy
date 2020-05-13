<template>
    <transition name="modal" @close="close()">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">



                    <div class="modal-body">
                        <slot name="body">
                             Вы приглашены на событие!
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
                required: false
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
                this.$emit('close')
            },
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