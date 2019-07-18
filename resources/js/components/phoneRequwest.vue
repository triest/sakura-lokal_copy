<template>
    <div>

        <button class="btn-primary" v-if="showSendRegButton" v-on:click="sendRequwest()">Отправить запрос на открытие
            телефона
        </button>
        <div v-if="regStatus == 'notreaded'">
            Ваш запрос на открытие номера телефона ещё не расcмотрен.
        </div>
        <div v-if="regStatus == 'rejected'">
            Ваш запрос на открытие телефона отклонён
        </div>
    </div>
</template>


<script>

    //'./components/delModal.vue'

    export default {
        props: {
            id: {
                type: '',
                required: true
            },
            user_id: {
                type: '',
                required: true
            },
        },
        components: {},
        mounted() {
            console.log("phoneReg");
            this.khowSendRequwestOrNot();
        },
        data() {
            return {
                showSendRegButton: false,
                regStatus: ''
            }
        },
        methods: {
            sendRequwest() {
                axios.get('/sendphonereg', {
                    params: {
                        id: this.id
                    }
                })
                    .then((response) => {
                            this.khowSendRequwestOrNot();
                        }
                    )
            },
            sendRequwest() {
                axios.get('/sendregphone', {
                    params: {
                        id: this.id
                    }
                })
                    .then((response) => {

                            this.khowSendRequwestOrNot();
                        }
                    )
            },
            khowSendRequwestOrNot() { //узнаёт, отправлен запрос или нет
                console.log("sendor not");
                var data_response = null;
                console.log("id " + this.id);
                axios.get('/getsendregphoneornot', {
                    params: {
                        id: this.id
                    }
                })
                    .then((response) => {
                        data_response = response.data;
                        if (data_response == "not") {
                            this.showSendRegButton = true;
                            console.log("phone not")
                            this.regStatus = "notsended"
                        }
                        else {
                            this.showSendRegButton = false;

                            //если отправлен, то надо статус показать
                            if (response.data == "notreaded") {

                                this.regStatus = "notreaded"
                            }
                            else if (response.data == "readed") {
                                this.regStatus = "readed";
                            }
                            else if (response.data['status'] == "rejected") {
                                console.log("regecter");
                                this.regStatus = "rejected";
                            }
                        }

                    })
            },//отправляет запрос на открытие анкеты
        }
    }
</script>

<style scoped>
    .delmodal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: table;
        transition: opacity .3s ease;

    }


</style>