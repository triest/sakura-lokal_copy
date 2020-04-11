<template>
    <transition name="modal" @close="showModal = false">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <slot name="header">
                        </slot>
                    </div>
                    <div class="modal-body">
                        <slot name="body">
                            <img class="container4" :src="'/images/albums/'+name" height="400px"
                                 style="horiz-align:center">
                        </slot>
                        <br>
                        Загруженно: {{photo.created_at}}
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                            <button type="button" class="btn btn-secondary" v-on:click="close()">
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
            },
            name: {
                type: '',
                required: false,
            }
        },
        mounted() {
            this.getImage();
        },
        data() {
            return {
                photo: ''
            }
        },
        methods: {
            close() {
                this.$emit('close')
            },
            getImage() {
                axios.get('/image/' + this.id, {
                    params:
                        {
                            type: "json"
                        }
                }).then((response) => {
                    this.photo = response.data.photo;
                })
            }
        }
    }
</script>

<style scoped>
    textarea {
        width: 90%; /* Ширина поля в процентах */
        height: 200px; /* Высота поля в пикселах */
        resize: none; /* Запрещаем изменять размер */
    }

    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 600px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        float: right;
    }

    /*
     * The following styles are auto-applied to elements with
     * transition="modal" when their visibility is toggled
     * by Vue.js.
     *
     * You can easily play with the modal transition by editing
     * these styles.
     */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }

    div.container4 {
        height: 10em;
        position: relative
    }

    div.container4 p {
        background: yellow;
        position: absolute;
        margin: auto;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%)
    }
</style>