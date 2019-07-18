<template>
    <div>
        <ul class="nav nav-tabs">
            <li role="presentation" @click="currentTab = 'accepted'"><a href="#"><b>Принятые</b></a></li>
            <li role="presentation" @click="currentTab = 'rejected'"><a href="#"><b>Отклоненные</b></a></li>
            <li role="presentation" @click="currentTab = 'unredded'"><a href="#"><b>Непрочитанные</b></a></li>
            <li role="presentation" @click="currentTab = 'all'"><a href="#"><b>Все</b></a>
            </li>
        </ul>
        <div class="applicationClass">
            <div class="tab-content">
                <div v-if="currentTab == 'all'">
                    <div v-for="requwest in requwestlist">

                        <div class="col-lg-4 col-md-3 col-sm-5 col-xs-9 box-shadow">
                            <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                                <div class="card-body">

                                    <a @click="myFunction(requwest.id)">
                                        <img :src="'/images/upload/'+requwest.main_image" height="150">
                                    </a>
                                    <a @click="myFunction(requwest.id)">
                                        <p>{{requwest.name}},
                                            {{requwest.age}}</p></a>
                                    <h5 v-if="requwest.status=='unredded'"><b>
                                        <a class="btn btn-primary" @click="accept(requwest.id,requwest.req_id)">
                                            Принять
                                        </a>
                                        <a class="btn btn-danger" @click="reject(requwest.id,requwest.req_id)">
                                            Отклонить
                                        </a>
                                    </b></h5>
                                    <h5 v-if="requwest.status=='accept'"><b>
                                        <a class="btn btn-danger" @click="reject(requwest.id,requwest.req_id)">
                                            Отклонить
                                        </a>
                                    </b></h5>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="currentTab == 'accepted'">
                <div v-for="requwest in accepted">

                    <div class="col-lg-4 col-md-3 col-sm-5 col-xs-9 box-shadow">
                        <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                            <div class="card-body">

                                <a @click="myFunction(requwest.id)">
                                    <img :src="'/images/upload/'+requwest.main_image" height="150">
                                </a>
                                <a @click="myFunction(requwest.id)">
                                    <p>{{requwest.name}},
                                        {{requwest.age}}</p></a>

                                <h5 v-if="requwest.status=='unredded'"><b>
                                    <a class="btn btn-primary" @click="accept(requwest.id,requwest.req_id)">
                                        Принять
                                    </a>
                                    <a class="btn btn-danger" @click="reject(requwest.id,requwest.req_id)">
                                        Отклонить
                                    </a>
                                </b></h5>
                                <h5 v-if="requwest.status=='accept'"><b>
                                    <a class="btn btn-danger" @click="reject(requwest.id,requwest.req_id)">
                                        Отклонить
                                    </a>
                                </b></h5>
                                <h5 v-if="requwest.status=='denide'"><b>
                                    <a class="btn btn-primary" @click="accept(requwest.id,requwest.req_id)">
                                        Принять
                                    </a>
                                </b>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="currentTab == 'rejected'">
                <div v-for="requwest in rejected">

                    <div class="col-lg-4 col-md-3 col-sm-5 col-xs-9 box-shadow">
                        <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                            <div class="card-body">

                                <a @click="myFunction(requwest.id)">
                                    <img :src="'/images/upload/'+requwest.main_image" height="150">
                                </a>
                                <a @click="myFunction(requwest.id)">
                                    <p>{{requwest.name}},
                                        {{requwest.age}}</p></a>

                                <h5 v-if="requwest.status=='denide'"><b>
                                    <a class="btn btn-primary" @click="accept(requwest.id,requwest.req_id)">
                                        Принять
                                    </a>
                                </b>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="currentTab == 'unredded'">
                <div v-for="requwest in unredded">

                    <div class="col-lg-4 col-md-3 col-sm-5 col-xs-9 box-shadow">
                        <div class="card  border-dark" style="width: 18rem; background-color: #eeeeee;
             border: 1px solid transparent;
             border-color: #666869;
">
                            <div class="card-body">

                                <a @click="myFunction(requwest.id)">
                                    <img :src="'/images/upload/'+requwest.main_image" height="150">
                                </a>
                                <a @click="myFunction(requwest.id)">
                                    <p>{{requwest.name}},
                                        {{requwest.age}}</p></a>
                                <h5 v-if="requwest.status=='unredded'"><b>
                                    <a class="btn btn-primary" @click="accept(requwest.id,requwest.req_id)">
                                        Принять
                                    </a>
                                    <a class="btn btn-danger" @click="reject(requwest.id,requwest.req_id)">
                                        Отклонить
                                    </a>
                                </b></h5>
                                <h5 v-if="requwest.status=='accept'"><b>
                                    <a class="btn btn-primary" @click="accept(requwest.id,requwest.req_id)">
                                        Принять
                                    </a>
                                    <a class="btn btn-danger" @click="reject(requwest.id,requwest.req_id)">
                                        Отклонить
                                    </a>

                                </b></h5>
                                <h5 v-if="requwest.status=='denide'"><b>
                                    <a class="btn btn-primary" @click="accept(requwest.id,requwest.req_id)">
                                        Принять
                                    </a>
                                </b>
                                </h5>
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
                type: Number,
                required: true
            },
        },
        components: {},
        mounted() {
            console.log("requwesteventlist1");
            this.getrequwests();
            console.log(this.eventid);
        },
        data() {
            return {
                accept: null,
                requwestlist: null,
                currentTab: 'all',
                accepted: null,
                rejected: null,
                unredded: null
            }
        },
        methods: {
            accept(id, req_id) {
                console.log(id);
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

            },
            reject(id, req_id) {
                console.log(id);
                console.log(id);
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

            },
            getrequwests() {
                axios.get('/eventrequwestlist', {
                        params: {
                            eventid: this.eventid
                        }
                    }
                )
                    .then((response) => {
                        this.requwestlist = response.data.all;
                        this.accepted=response.data.accepted;
                        this.rejected=response.data.reject;
                        this.unredded=response.data.unredded;
                    });
            },
            myFunction: function (id) {
                console.log(id);
                window.open("/anket/" + id, "_blank");
            }
        }
    }
</script>

<style scoped>

</style>