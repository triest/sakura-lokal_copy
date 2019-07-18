<template>
    <div>
        <h3 v-if="isOpen">У вас открыт доступ к приватной информации!</h3>
        <button class="btn-primary" v-if="showSendRegButton" v-on:click="sendRequwest()">Отправит запрос на открытие
            анкеты
        </button>
        <h5 v-if="regStatus=='notreaded'">Заявка на открытие анкеты не рассмотрена</h5>
        <h5 v-if="regStatus=='acept'">Заявка на открытие анкеты принята</h5>
        <h5 v-if="regStatus=='denide'">Заявка на открытие анкеты отклонена</h5>
        <br>
        <button class="btn-default" v-on:click="showMessageWindow()" style="button.css3button {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
	padding: 10px 20px;
	background: -moz-linear-gradient(
		top,
		#ffffff 0%,
		#ffffff);
	background: -webkit-gradient(
		linear, left top, left bottom,
		from(#ffffff),
		to(#ffffff));
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
	border: 1px solid #000000;
	-moz-box-shadow:
		0px 1px 3px rgba(250,250,250,0.5),
		inset 0px 0px 1px rgba(255,255,255,0.6);
	-webkit-box-shadow:
		0px 1px 3px rgba(250,250,250,0.5),
		inset 0px 0px 1px rgba(255,255,255,0.6);
	box-shadow:
		0px 1px 3px rgba(250,250,250,0.5),
		inset 0px 0px 1px rgba(255,255,255,0.6);
	text-shadow:
		0px -1px 0px rgba(0,0,0,1),
		0px 1px 0px rgba(255,255,255,0.2);
}
">Написать сообщение
        </button>
        <br>

        <button class=" btn-success
        " v-on:click="showPresentModal=true" alt="Отправить подарок">Отправить подарок
        </button>
        <br>
        <div v-if="isAdmin==true">
            <button class="btn-danger" v-on:click="showAdminModal=true">Действия администратора</button>
        </div>
        <admin v-if="showAdminModal" :id="user_id" @clouseAdminModal='clouseAdminModal()'></admin>
        <present v-if="showPresentModal" :id="user_id" @closeRequest='close()'></present>
        <modal v-if="showModal===true" :id="id" v-on:close="showModal = false">></modal>
    </div>
</template>

<script>
    import modal from './ModalComponent.vue';
    import present from './PresentModal.vue'
    import admin from './Admin.vue'
    import Admin from "./Admin";

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
        components: {
            Admin,
            modal, present
        },
        mounted() {
            this.getuserid();
            this.khowHasPrivateOrNot();
            this.isAdminCheck();

        },
        data() {
            return {
                isOpen: false,
                showSendRegButton: false,
                regStatus: null,
                isModalVisible: true,
                showModal: false,
                showPresentModal: false,
                userId: '',
                isAdmin: false,
                showAdminModal: false
            }
        },
        methods: {
            khowHasPrivateOrNot() {
                console.log('reg ' + this.id);
                axios.get('/getisprivaterrnot', {
                    params: {
                        id: this.user_id
                    }
                })
                    .then((response) => {
                        if (response.data == "open true") {
                            this.isOpen = true;     //открыта анкета
                        }
                        else {
                            this.isOpen = false;
                            console.log("open false"); //закрыта
                            this.khowSendRequwestOrNot();
                        }
                    })
            },
            getuserid() {
                axios.get('/getuserid', {
                    params: {
                        id: this.id
                    }
                })
                    .then((response) => {
                        this.user_id = response.data;
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
            },
            itemClicked: function () {
                $("#my-modal").modal('show');
            },
            showModal() {
                this.isModalVisible = true;
            },
            closeModal() {
                this.isModalVisible = false;
            },
            clouseAdminModal() {
                this.showAdminModal = false;
            },
            showMessageWindow() {
                this.showModal = true
            },
            close() {
                this.showPresentModal = false;
            },
            isAdminCheck() {
                axios.get('/isAdmin', {})
                    .then((response) => {
                        var data_response = response.data;
                        if (data_response == "true") {
                            console.log("is admin");
                            this.isAdmin = true;
                        }
                        else {
                            console.log("not admin");
                            this.isAdmin = false;
                        }
                    })
            }
        }
    }
</script>

<style scoped>
    .modal {
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