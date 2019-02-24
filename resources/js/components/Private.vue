<template>
    <div>
        <h3 v-if="isOpen">У вас открыт доступ к приватной информации!</h3>
        <button v-if="showSendRegButton" v-on:click="sendRequwest()">Отправит запрос на открытие анкеты</button>
        <h3 v-if="regStatus=='notreaded'">Заявка не рассмотренна</h3>
        <h3 v-if="regStatus=='acept'">Заявка принята</h3>
        <h3 v-if="regStatus=='denide'">Заявка отклонена</h3>
    </div>
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
            console.log('private');
            console.log(this.id);
            this.khowHasPrivateOrNot()
        },
        data() {
            return {
                isOpen: false,
                showSendRegButton: false,
                regStatus: null
            }
        },
        methods: {
            khowHasPrivateOrNot() {
                console.log('reg ' + this.id);
                axios.get('/getisprivaterrnot', {
                    params: {
                        id: this.id
                    }
                })
                    .then((response) => {
                        if (!response.data) {
                            this.isOpen = true;
                        }
                        else {
                            this.isOpen = false;
                            this.khowSendRequwestOrNot();
                        }
                    })
            },
            khowSendRequwestOrNot() { //узнаёт, отправлен запрос или нет
                console.log("sendor not");
                var data_response = null;
                axios.get('/getsendregornot', {
                    params: {
                        id: this.id
                    }
                })
                    .then((response) => {
                        data_response = response.data;
                        if (data_response == "not") {
                            this.showSendRegButton = true;
                            console.log("not")
                        }
                        else {
                            console.log("true");

                            this.showSendRegButton = false;
                            console.log();
                            //если отправлен, то надо статус показать
                            if (response.data['readed'] == 1) {
                                // this.regStatus = "notreaded"
                                console.log("readed");
                                if (response.data['status'] == 'confirmed') {
                                    this.regStatus = "acept";
                                    this.showSendRegButton = false;
                                }
                                else {
                                    this.regStatus = "denide";
                                    this.showSendRegButton = false;
                                }
                                //this.showSendRegButton=false;
                            }
                            else {
                                console.log("not readed")
                                this.regStatus = "notreaded";
                            }
                        }

                    })
            },//отправляет запрос на открытие анкеты
            sendRequwest() {
                axios.get('/sendreg', {
                    params: {
                        id: this.id
                    }
                })
                    .then((response) => {
                            this.khowSendRequwestOrNot();
                        }
                    )
            }

        }
    }
</script>

<style scoped>

</style>