<template>
    <div>
        Принятых заявок:
        {{countaccepted}} <br>
        Максимальное число заявок: {{max_people}}

        <div v-if="countaccepted==max_people">
            <b> Максимальное число участников! </b>
        </div>

        <ul class="nav nav-tabs">
            <li role="presentation" @click="currentTab = 'myRequwest'"><a href="#"><b>Мои запросы</b></a></li>
            <li role="presentation" @click="currentTab = 'RequwestToMyEvent'"><a href="#"><b>Запросы к моим событиям</b></a>
            </li>
        </ul>
        <div v-if="currentTab == 'myRequwest'">
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th>Событие</th>
                    <th>Город</th>
                    <th>Место события</th>
                    <th>Дата события</th>
                    <th>Статус события</th>
                    <th>Создано</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="event in myrequwests">
                    <!--  <a :href="'/anket/'+like.id"> -->
                    <td><a :href="'/event/singup/' +event.id">{{event.name}}</a></td>
                    <td>{{event.city_name}}</td>
                    <th>{{event.place}}</th>
                    <td>{{event.begin}}</td>
                    <td>{{event.statys_name}}</td>
                    <div v-if='event.req_status=="unread"'>
                        <td>Заявка не прочитанна</td>
                    </div>
                    <div v-if='event.req_status=="accept"'>
                        <td>Заявка принята</td>
                    </div>
                    <div v-if='event.req_status=="denide"'>
                        <td>Заявка отклонена</td>
                    </div>
                    <td>{{event.created_at}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div v-if="currentTab == 'RequwestToMyEvent'">
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th></th>
                    <th>Город</th>
                    <th>Место события</th>
                    <th>Дата события</th>
                    <th>Статус события</th>
                    <th>Создано</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="event in requwesttomyevent">
                    <!--  <a :href="'/anket/'+like.id"> -->
                    <td><a :href="'/myevent/' +event.id">{{event.name}}</a></td>
                    <td>{{event.city_name}}</td>
                    <td><a :href="'/anket/' +event.girl_id">{{event.girl_name}}</a></td>
                    <td><img :src="'/images/upload/'+event.girl_main_image" height="100"></td>
                    <td>{{event.place}}</td>
                    <td>{{event.statys_name}}</td>
                    <h5 v-if="event.req_status=='unread'"><b>
                        <p><a class="btn btn-primary" @click="accept(event.id,event.req_id,)">
                            Принять
                        </a></p>
                        <p>
                            <a class="btn btn-danger" @click="reject(event.id,event.req_id)">
                                Отклонить
                            </a>
                        </p>
                    </b></h5>
                    <h5 v-if="event.req_status=='accept'"><b>
                        <a class="btn btn-danger" @click="reject(event.id,event.req_id)">
                            Отклонить
                        </a>
                    </b></h5>
                    <td>{{event.created_at}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props: {},
        components: {},
        mounted() {
            console.log("requwesteventlist1");
            this.getall();
        },
        data() {
            return {
                requwestlist: "",
                currentTab: 'RequwestToMyEvent',
                myrequwests: "",
                requwesttomyevent: "",
                unredded: "",
                countaccepted: "",
                max_people: "",
            }
        },
        methods: {
            getall() {
                this.requwestlist = [];
                this.accepted = null;
                this.rejected = null;
                this.unredded = null;
                var temp;
                axios.get('list/all',)
                    .then((response) => {
                        //  this.myrequwests = response.data.myRequwest;
                        //console.log(response.data);
                        var data = response.data;
                        // console.log(data);
                        this.myrequwests = data.myRequwest;
                        this.requwesttomyevent = data.requestMyEvent;
                        //  console.log(temp);
                        // this.requwesttomyevent = response.data.requestMyEvent;
                    });

            },
            accept(event_id, requwest_id, action) {
                this.requwestlist = [];
                this.accepted = null;
                this.rejected = null;
                this.unredded = null;
                let id = 1;
                axios.get('/event/accept', {
                        params: {
                            eventid: event_id,
                            useris: id,
                            action: 'accept',
                            reqid: requwest_id,
                        }
                    }
                )
                    .then((response) => {

                    });
                this.getall();

            },
            reject(event_id, requwest_id, action) {
                this.requwestlist = [];
                this.accepted = null;
                this.rejected = null;
                this.unredded = null;
                let id = 1;
                axios.get('/event/accept', {
                        params: {
                            eventid: event_id,
                            useris: id,
                            action: 'accept',
                            reqid: requwest_id,
                        }
                    }
                )
                    .then((response) => {

                    });
                this.getall();

            },

            /*
                        accept(id, req_id) {
                            this.requwestlist = [];
                            this.accepted = null;
                            this.rejected = null;
                            this.unredded = null;
                            axios.get('/event/accept', {
                                    params: {
                                        eventid: this.eventid,
                                        useris: id,
                                        action: 'accept',
                                        reqid: req_id,
                                    }
                                }
                            )
                                .then((response) => {

                                });
                            this.gatall();
                            this.getacepted();
                        },
                        reject(id, req_id) {
                            axios.get('/event/accept', {
                                    params: {
                                        eventid: this.eventid,
                                        useris: id,
                                        action: 'reject',
                                        reqid: req_id,
                                    }
                                }
                            )
                                .then((response) => {
                                });
                            this.gatall();
                        },
                        getrequwests() {
                            this.requwestlist = null;
                            axios.get('/event/requwestlist', {
                                    params: {
                                        eventid: this.eventid
                                    }
                                }
                            )
                                .then((response) => {
                                    this.requwestlist = response.data.all;
                                });
                        },
                        getacepted() {
                            axios.get('/event/requwestlist/accepted', {
                                    params: {
                                        eventid: this.eventid
                                    }
                                }
                            )
                                .then((response) => {
                                    this.accepted = response.data;
                                });
                        },
                        getdenided() {

                            axios.get('/event/requwestlist/denided', {
                                    params: {
                                        eventid: this.eventid
                                    }
                                }
                            )
                                .then((response) => {
                                    this.rejected = response.data;
                                });
                        },

                        getunreaded() {
                            axios.get('/event/requwestlist/unreaded', {
                                    params: {
                                        eventid: this.eventid
                                    }
                                }
                            )
                                .then((response) => {
                                    this.unredded = response.data;
                                });
                        },

                        myFunction: function (id) {
                            window.open("/anket/" + id, "_blank");
                        },
                        requwestcount: function () {
                            let temp;
                            axios.get('/event/requwest/count', {
                                    params: {
                                        eventid: this.eventid
                                    }
                                }
                            ).then((response) => {
                                this.countaccepted = response.data.accepted;
                                this.max_people = response.data.event.max_people;

                            });

                        }
                        */
        },
    }
</script>

<style scoped>

</style>