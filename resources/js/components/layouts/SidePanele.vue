<template>
    <div>

        <img height="20" src="/images/heart.png" v-on:mouseover="triger()" v-on:mouseleave="cleare()"> {{likesNunber}}
        <br>
        <!--
         <button class="btn btn-primary" v-on:click="openSeachModal()">Настроить поиск</button>
         -->
        <br>
        <b><a href="/messages">Сообщения
            <div v-if="numberUnreaded>0">({{numberUnreaded}})</div>
        </a>
        </b><br>
        <b><a href="/applications">Заявки на открытие анкеты
            <div v-if="numberApplication>0">({{numberApplication}})</div>
        </a>
        </b>
        <br>
        <b><a class="btn btn-primary" href="/power">Поднять анкету</a> </b><br><br>
        <b><a class="btn btn-info" href="/mypresents">Мои подарки</a> </b>
        <div v-if="numberApplicationPresents>0"><b>({{numberApplicationPresents}})</b></div>
        <br><br>
        <!--
        <div v-if="inseach==true">
            <b>Ваша анкета отображаеться в поиске</b>
        </div>
        <div v-else>
            <b>Ваша анкета Не отображаеться в поиске</b><br>
            <b><a type="btn primary" href="/power">Поместить анкету в поиск</a></b>
        </div>
        -->
        <likemodal v-if="showLikeModal" @closeLikeModalEmit='closeLikeModal()'></likemodal>
        <b><a class="btn btn-primary" href="/history">Просмотры моей анкеты</a> </b><br><br>
        <div v-if="unreeadedEventRequwest>0" class="event-requwest">
            <b>Запросы на мои события:{{unreeadedEventRequwest}}</b>
        </div>
        <div v-if="unreeadedEventRequwest>0">
            <a class="btn btn-primary" href="/event/requwest/list">Смотреть запросы</a>
        </div>

        <alertmodal v-if="showAlertModal" :event="event" @closeAlert="clouseAlertModal()"></alertmodal>

        <div class="event-requwest" v-if="count_accept_notification>0">
            Ваша заявка на мероприятие принята!
        </div>
    </div>
</template>

<script>
    import likemodal from '../likes/LikeModal'
    import alertmodal from '../layouts/AlertModal'


    export default {

        props: {
            user: {
                type: Object,
                required: true
            }
        },
        components: {
            likemodal,
            alertmodal,
        },
        data() {
            return {
                numberUnreaded: 0,
                numberApplication: 0,
                numberApplicationPresents: 0,
                inseach: false,
                likesNunber: 0,
                showLikeModal: false,
                unreeadedEventRequwest: 0,
                showAlertModal: false,
                event: "",
                showNemMessageModal: false,
                filter_enable: false,
                count_accept_notification: 0
            }
                ;
        },

        mounted() {
            this.inSeach();
            this.getAllDataForSidePanel();
            this.getNumberUnreadedEventRequwest();
            this.remidese();
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    console.log('NewMessage');
                    axios.get('/getCountUnreaded')
                        .then((response) => {
                            this.numberUnreaded = response.data;
                        });
                    this.getNumberUnreadedMessages();
                    this.showNemMessageModal = true;
                });
            Echo.private(`requwests.${this.user.id}`)
                .listen('newApplication', (e) => {
                    console.log('NewRequwest');
                    axios.get('/getCountUnreadedRequwest')
                        .then((response) => {
                            this.numberApplication = response.data;
                        })
                });
            Echo.private(`gifs.${this.user.id}`)
                .listen('eventPreasent', (e) => {
                    this.getNumberUnreadedPresents();
                    console.log("presrn");
                });
            Echo.private(`eventsrequwest.${this.user.id}`)
                .listen('Newevent', (e) => {
                    console.log('NewRequwestEvent');
                });
            Echo.private(`App.User.${this.user.id}`)
                .listen('Newevent', (e) => {
                    this.getNumberUnreadedEventRequwest();
                });
        },
        methods:
            {
                triger() {
                    clearTimeout(this.timer);
                    this.timer = setTimeout(() => {
                        clearTimeout(this.timer);
                        this.showLikeModal = true;
                    }, 1500)
                },


                cleare() {
                    clearTimeout(this.timer);
                },
                closeLikeModal() {
                    this.showLikeModal = false;
                },
                getNumberUnreadedMessages() {
                    axios.get('/getCountUnreaded')
                        .then((response) => {
                            this.numberUnreaded = response.data;
                        })
                },
                getNumberUnreadedPresents() {
                    axios.get('/getCountUnreadedPresents')
                        .then((response) => {
                            this.numberApplicationPresents = response.data;
                        })
                },
                inSeach() {
                    let res;
                    axios.get('/inseach')
                        .then((response) => {
                            res = response.data;
                            if (res == true) {
                                this.inseach = true;
                            }
                            else {
                                this.inseach = false;
                            }
                        })
                },
                getLikesNumber() {
                    axios.get('/getLikesNumberAuch', {
                        params: {
                            girl_id: this.girlid
                        }
                    })
                        .then((response) => {
                            this.likesNunber = response.data['likeNumber']
                        });
                    console.log("likes number " + this.likesNunber)
                },
                getAllDataForSidePanel() {
                    axios.get('/getalldataforsidepanel', {
                        params: {
                            girl_id: this.girlid
                        }
                    })
                        .then((response) => {
                            var data = response.data;
                            this.likesNunber = data.likeNumber;
                            this.numberApplicationPresents = data.countGift;
                            this.numberUnreaded = data.countMessages;
                            this.numberApplication = data.countRequwest;
                            this.filter_enable = data.filter.filter_enable;
                            this.count_accept_notification = data.countAccept_notification;
                        });
                },
                clouseLikeModal() {
                    console.log("clouseLikeModal");
                    this.showLikeModal = false;
                },
                //
                getNumberUnreadedEventRequwest() {
                    axios.get('/event/requwest/myevent', {})
                        .then((response) => {
                                //    this.unreeadedEventRequwest = response.data["count(*)"];
                                this.unreeadedEventRequwest = response.data.organizer;
                            }
                        )
                    ;
                },
                remidese() {
                    axios.get('/event/reminders', {})
                        .then((response) => {
                                //  console.log(response.data)
                                if (response.data.requestMyEvent.length > 0) {
                                    this.showAlertModal = true;
                                    this.event = response.data.requestMyEvent;
                                }
                            }
                        )
                    ;
                },
                clouseAlertModal() {
                    this.showAlertModal = false;
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
    }

    .event-requwest {
        color: red;

    }
</style>