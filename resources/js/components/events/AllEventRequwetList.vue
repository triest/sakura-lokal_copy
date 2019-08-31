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
        <div class="applicationClass">
            <div class="tab-content">
                <div v-if="currentTab == 'myRequwest'">
                    <div v-for="requwest in myrequwests">

                        <div class="col-lg-4 col-md-3 col-sm-5 col-xs-9 box-shadow">
                            <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                                <div class="card-body">
                                    {{requwest.name}}
                                    Место: {{requwest.place}}
                                    Начало: {{request.begin}}
                                    <div v-if='requwest.req_status=="unread"'>
                                        <td>Заявка не прочитанна</td>
                                    </div>
                                    <div v-if='requwest.req_status=="accept"'>
                                        <td>Заявка принята</td>
                                    </div>
                                    <div v-if='requwest.req_status=="denide"'>
                                        <td>Заявка отклонена</td>
                                    </div>
                                    <td>{{requwest.created_at}}</td>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="currentTab == 'RequwestToMyEvent'">
                <div v-for="requwest in requwesttomyevent">
                    <div v-for="requwest in myrequwests">

                        <div class="col-lg-4 col-md-3 col-sm-5 col-xs-9 box-shadow">
                            <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                                <div class="card-body">
                                    {{requwest.name}}
                                    Место: {{requwest.place}}
                                    Начало: {{request.begin}}
                                    <div v-if='requwest.req_status=="unread"'>
                                        <td>Заявка не прочитанна</td>
                                    </div>
                                    <div v-if='requwest.req_status=="accept"'>
                                        <td>Заявка принята</td>
                                    </div>
                                    <div v-if='requwest.req_status=="denide"'>
                                        <td>Заявка отклонена</td>
                                    </div>
                                    <td>{{requwest.created_at}}</td>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            eventid: {
                type: String,
                required: true
            },
        },
        components: {},
        mounted() {
            console.log("requwesteventlist1");
            this.getall();
        },
        data() {
            return {
                requwestlist: null,
                currentTab: 'RequwestToMyEvent',
                myrequwests: null,
                requwesttomyevent: null,
                unredded: null,
                countaccepted: null,
                max_people: null,
            }
        },
        methods: {
            getall() {
                this.requwestlist = [];
                this.accepted = null;
                this.rejected = null;
                this.unredded = null;
                axios.get('list/all',
                )
                    .then((response) => {
                        this.myrequwests = response.data.myRequwest;
                        this.requwesttomyevent = response.data.requestMyEvent;
                    });
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