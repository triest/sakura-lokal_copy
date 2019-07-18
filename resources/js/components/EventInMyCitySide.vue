<template>
    <div>
        <carousel :per-page="1" :mouse-drag="false" :autoplay="true" :loop="true" :centerMode="true"
                  :navigationEnabled="true">
            <slide v-for="event in eventList" :key="event.id">
                <b>{{event.name}}</b> <br>
                Место:{{event.place}} <br>
                Дата: {{event.date}} <br>
                Статус: {{event.status_name}} <br>
                <a type="button" v-bind:href="'/singup/'+event.id+''">Записаться</a>
            </slide>
        </carousel>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log("event in my my city side");
            this.getEvents();
        },
        data() {
            return {
                eventList: ""
            };
        },
        methods: {
            getEvents() {
                console.log("get events");
                axios.get('/eventsinmycity', {
                        /*   params: {
                               eventid: this.eventid,
                               useris: id,
                               action: 'accept',
                               reqid: req_id,
                           }*/
                    }
                )
                    .then((response) => {
                        this.eventList = response.data;
                    });
            }
        }

    }
</script>

<style scoped>

</style>