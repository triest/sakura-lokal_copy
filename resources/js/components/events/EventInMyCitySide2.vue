<template>
    <div>
        <div v-if="eventList.length">
            <carousel :per-page="1" :mouse-drag="false" :autoplay="true" :loop="true"
                      :navigationEnabled="true" :paginationEnabled="false">
                <slide v-for="event in eventList" :key="event.id">
                    <div class="col-sm-1"></div>
                    <b>{{event.name}}</b> <br>
                    Место:{{event.place}} <br>
                    Дата: {{event.begin}} <br>
                    {{event.status_name}}
                    <div v-if="checkRequsest(event.id)!==false">
                        <div v-if="checkRequsest(event.id)=='accept'">
                            <a class="btn btn-primary" v-bind:href="'event/singup/'+event.id"> Заявка принята</a>
                        </div>
                        <div v-if="checkRequsest(event.id)=='denide'">
                            <a class="btn btn-primary" v-bind:href="'event/singup/'+event.id">Заявка отклонена</a>
                        </div>
                        <div v-if="checkRequsest(event.id)=='unreaded'">
                            <a class="btn btn-primary" v-bind:href="'event/singup/'+event.id">Заявка не прочитана</a>
                        </div>
                    </div>
                    <div v-else>
                        <a class="btn btn-primary" v-bind:href="'event/singup/'+event.id">Записаться!</a>
                    </div>
                </slide>
            </carousel>
        </div>
        <div v-else>
            Событий в вашем городе нет.
            <a class="btn btn-primary" v-bind:href="'myevent/store'">Создать событие!</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            city: {
                type: Object,
                default: null
            }
        },
        mounted() {
            this.getEvents()
        },
        data() {
            return {
                eventList: "",
                partification: "",
                add: false
            };
        },
        methods: {
            getEvents() {
                console.log("get events1");
                axios.get('/events/inmycity', {params: {type: "json", city: this.city.id}}
                )
                    .then((response) => {
                        this.eventList = response.data.events;
                        this.partification = response.data.partification;
                    });
            },
            checkRequsest(event_id) {
                for (let i = 0; i < this.partification.length; i++) {
                    if (typeof this.partification[i][0] === "undefined") {
                        return false;
                    }

                    if (this.partification[i][0].event_id === event_id) {
                        return this.partification[i][0].status;
                    }
                }

                return false;


            }
        }

    }
</script>

<style scoped>
    .eventPanel {
        max-width: 250px;
    }
</style>