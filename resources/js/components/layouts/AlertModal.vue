<template>
    <transition name="modal" @close="showModal = false">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-body">
                        <slot name="body">
                            <a :href="'/myevent/'+event[0].id"> <b>{{event[0].name}}</b></a>
                            <p> Сегодня в {{event[0].place}}</p>
                            <p>Начало в {{event[0].begin}}</p>
                            <p>Не пропустите! </p>
                            <img :src="'images/events/'+event[0].photo_name" height="200">
                            <p>Организатор:<a :href="'/anket/'+event[0].girl_id">{{event[0].girl_name}}</a></p>
                            <button class="btn-primary" v-on:click="alert_reciver()">Напоминание прочитанно. Больше не
                                напоминать
                            </button>
                            <button class="btn-primary" v-on:click="alert_late()">Напоминание позже</button>

                        </slot>
                    </div>

                    <div class="modal-footer">
                        <slot name="footer">
                        
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
            event: {
                type: Array,
                required: false
            }
        },
        mounted() {
            console.log(this.event);
        },
        data() {
            return {
                presents: [],
                currentAnket: '',
                userMoney: ''
            }
        },
        methods: {
            closeWindow() {
                console.log("clouse");
                this.$emit('closeAlertModalEmit', 'someValue')
            },
            showMessageWindow() {
                console.log("chow");
            },
            close() {

            },
            alert_reciver() {
                axios.get('event/reminders/recived', {
                    params: {
                        girl_id: this.girlid,
                        action: "alert_recived",
                        notification_type: "alert_today",
                        event_id: this.event[0].id
                    }
                })
                    .then((response) => {

                    });
                this.$emit('closeAlert')
            },
            alert_late() {
                axios.get('/event/reminders/recived', {
                    params: {
                        girl_id: this.girlid,
                        action: "alert_late",
                        notification_type: "alert_today",
                        event_id: this.event[0].id
                    }
                })
                    .then((response) => {

                    });
                this.$emit('closeAlert')
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
</style>