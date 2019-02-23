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
                axios.get('/getsendregornot', {
                    params: {
                        id: this.id
                    }
                })
                    .then((response) => {
                        if (response.data == "not") {
                            this.showSendRegButton = true;
                        }
                        else {
                            this.showSendRegButton = false;
                            //если отправлен, то надо статус показать
                            if (response.data['readed'] == 0) {
                                this.regStatus = "notreaded"
                                this.showSendRegButton=false;
                            }
                            else {
                                if(response.data['status']=='acept'){
                                    this.regStatus="acept"
                                    this.showSendRegButton=false;
                                }
                                else {
                                    this.regStatus="denide"
                                    this.showSendRegButton=false;
                                }
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