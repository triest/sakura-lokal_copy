<template>
    <div>
        <h3 v-if="isOpen">У вас открыт доступ к приватной информации!</h3>
        <!--  <button class="btn-primary" v-if="showSendRegButton" v-on:click="sendRequwest()">Попросить открыть анкету
          </button>
          -->
        <h5 v-if="regStatus=='notreaded' && !showSendRegButton">Просьба еще не рассмотрена
            <button class="btn btn-primary" v-on:click="withdrawRequwest()">
                Отозавать заявку
            </button>
        </h5>
        <h5 v-if="regStatus=='acept'">Пользователь открыл Вам свою анкету</h5>
        <h5 v-if="regStatus=='denide'">Пользователь отклонил вышу просьбу открыть анкету</h5>
        <table>
            <tr>
                <td>
                    <button class="btn btn-primary" v-on:click="showMessageWindow()">Написать сообщение
                    </button>
                </td>
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            или
                        </button>
                        <div class="dropdown-menu">

                            <li v-if="wink==false"><a class="dropdown-item" v-on:click="makeWink()" alt="Подмигнуть"
                                                      style="  cursor: pointer;">Подмигнуть</a>
                            </li>
                            <li v-if="wink==false" role="separator" class="divider"></li>

                            <li><a class="dropdown-item" v-on:click="showPresentModal=true" alt="Отправить подарок"
                                   style="  cursor: pointer;">Отправить
                                подарок</a></li>
                            <li v-if="showSendRegButton" role="separator" class="divider"></li>
                            <li v-if="showSendRegButton"><a class="dropdown-item" v-on:click="sendRequwest()"
                                                            alt="Подмигнуть" style="  cursor: pointer;">Попросить
                                открыть анкету</a></li>

                        </div>
                    </div>

                </td>
            </tr>
        </table>

        <br>
        <div v-if="isAdmin==true">
            <button class="btn btn-danger" v-on:click="showAdminModal=true">Действия администратора</button>
        </div>
        <admin v-if="showAdminModal" :id="user_id" @clouseAdminModal='clouseAdminModal()'></admin>
        <present v-if="showPresentModal" :id="user_id" @closeRequest='close()'></present>
        <modal v-if="showModal===true" :user_name="user_name" :id="id" v-on:close="showModal = false">></modal>
    </div>
</template>

<script>
    import modal from '../chat/ModalComponent.vue';
    import present from './PresentModal.vue'
    import Admin from "../admin/Admin";

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
            this.getWingk();

            console.log("this.user_id " + this.id);
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
                showAdminModal: false,
                wink: false,
                user_name: ""
            }
        },
        methods: {
            khowHasPrivateOrNot() {
                console.log('reg ' + this.id);
                axios.get('/private/status', {
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
            makeWink() {
                axios.get('/anket/wink/make', {
                    params: {
                        id: this.id
                    }
                })
                    .then((response) => {
                        //   this.user_id = response.data;
                    });
                this.getWeak();
            },

            getWingk() {
                axios.get('/anket/wink/get', {
                    params: {
                        id: this.id
                    }
                })
                    .then((response) => {
                        //   this.user_id = response.data;
                        console.log(response.data)
                        if (response.data != [] && response.data == "true") {
                            this.wink = true;
                        } else {
                            this.wink = false;
                        }
                    })
            },

            khowSendRequwestOrNot() { //узнаёт, отправлен запрос или нет
                console.log("sendor not");
                var data_response = null;
                axios.get('/private/requwest/status', {
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
                                this.regStatus = "notreaded"
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
                axios.get('/private/requwest/send', {
                    params: {
                        id: this.id
                    }
                })
                    .then((response) => {
                            this.khowSendRequwestOrNot();
                        }
                    )
            },
            //отозвать запрос на открытие анкеты
            withdrawRequwest() {
                axios.get('/private/requwest/withdraw', {
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