<template>
    <div>

        <img height="20" src="/images/heart.png" v-on:mouseover="showLikeModal=true"> {{likesNunber}} <br>
        <b><a href="/messages">Сообщения
            <div v-if="numberUnreaded>0">+{{numberUnreaded}}</div>
        </a>
        </b><br>
        <b><a href="/applications">Заявки на открытие анкеты
            <div v-if="numberApplication>0">+{{numberApplication}}</div>
        </a>
        </b>

        <b><a class="btn btn-primary" href="/power">Поднять анкету</a> </b><br><br>
        <b><a class="btn btn-info" href="/mypresents">Мои подарки</a> </b>
        <div v-if="numberApplicationPresents>0"><b>+{{numberApplicationPresents}}</b></div>
        <br><br>
        <div v-if="inseach==true">
            <b>Ваша анкета отображаеться в поиске</b>
        </div>
        <div v-else>
            <b>Ваша анкета Не отображаеться в поиске</b><br>
            <b><a type="btn primary" href="/power">Поместить анкету в поиск</a></b>
        </div>
        <likemodal v-if="showLikeModal" @closeLikeModalEmit='closeLikeModal()'></likemodal>
        <b><a class="btn btn-primary" href="/history">Просмотры моей анкеты</a> </b><br><br>
    </div>
</template>

<script>
    import likemodal from './LikeModal'


    export default {

        props: {
            user: {
                type: Object,
                required: true
            }
        },
        components: {
            likemodal
        },
        data() {
            return {
                numberUnreaded: 0,
                numberApplication: 0,
                numberApplicationPresents: 0,
                inseach: false,
                likesNunber: 0,
                showLikeModal: false
            }
                ;
        },

        mounted() {
            this.inSeach();
            this.getAllDataForSidePanel();
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    //console.log('NewMessage');
                    axios.get('/getCountUnreaded')
                        .then((response) => {
                            this.numberUnreaded = response.data;
                        });
                    this.getNumberUnreadedMessages();
                });
            Echo.private(`requwests.${this.user.id}`)
                .listen('newApplication', (e) => {
                    // console.log('NewRequwest');
                    axios.get('/getCountUnreadedRequwest')
                        .then((response) => {
                            this.numberApplication = response.data;
                        })
                });
            Echo.private(`gifs.${this.user.id}`)
                .listen('eventPreasent', (e) => {
                    this.getNumberUnreadedPresents();
                });


            /*  axios.get('/getCountUnreaded')
                  .then((response) => {
                      this.numberUnreaded = response.data;
                  });*/
            /*axios.get('/getCountUnreadedRequwest')
                .then((response) => {
                    this.numberApplication = response.data;
                }),
                this.getNumberUnreadedPresents();
            this.getLikesNumber();*/
        },
        methods:
            {
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
                    axios.get('/inseach')
                        .then((response) => {
                            if (response.data == "true") {
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
                }

            }
    }
</script>


<style scoped>

</style>