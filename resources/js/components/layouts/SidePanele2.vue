<template>
    <div>
        <div class="navbar-brand">
            <p v-if="mainImage!=null">
                <a href="/myAnket">
                    <img :src="'images/upload/'+mainImage" height="30">
                </a>
                <a href="/messages"> <img width="50" height="50" :src="'images/icons/icons8-speech-bubble.svg'">
                    <div v-if="numberUnreaded>0">({{numberUnreaded}})</div>
                </a>
                <a href="/applications"> <img width="50" height="50" :src="'images/icons/lightning-bolt@2x.png'">
                    <div v-if="numberApplication>0">({{numberApplication}})</div>
                </a>
                <likemodal v-if="showLikeModal" @closeLikeModalEmit='closeLikeModal()'></likemodal>
                <a href="/history"> <img width="50" height="50" :src="'images/icons/eye.png'"></a>
            </p>
        </div>
        <div class="navbar-brand">
            <a class="btn btn-primary" href="/event/requwest/list">Запросы {{unreeadedEventRequwest}}</a>
        </div>
    </div>
</template>

<script>
    import likemodal from '../likes/LikeModal'
    import alertmodal from '../layouts/AlertModal'
    import newmessagemodal from '../chat/newMessageModal'


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
            newmessagemodal
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
                mainImage: null,
            }
                ;
        },

        mounted() {
            this.inSeach();
            this.getAllDataForSidePanel();
            this.getNumberUnreadedEventRequwest();
            this.remidese();
            this.getmainImage();
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
            /*
            Echo.private(`App.User.${this.user.id}`)
                .listen('Newevent', (e) => {
                    console.log("new Event");
                    this.getNumberUnreadedEventRequwest();
                });
                */
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
                getmainImage() {
                    axios.get('/image/main')
                        .then((response) => {
                            this.mainImage = response.data;
                        });
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
                closeNewMessageAlert() {
                    this.showNemMessageModal = false;
                }

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
</style>