<template>
    <div class="eventPanel">
        <div v-if="eventList.length">
            <carousel :per-page="1" :mouse-drag="false" :autoplay="true" :loop="true" :centerMode="true"
                      :navigationEnabled="true">
                <slide v-for="event in eventList" :key="event.id">
                    <b>{{event.name}}</b> <br>
                    Место:{{event.place}} <br>
                    Дата: {{event.begin}} <br>
                    {{event.status_name}} <br>
                    <div v-if="event.requwest_status=='accept'">
                        <b>Вы записаны на это мероприятие</b>
                    </div>
                    <div v-else>
                        <a class="btn btn-primary" v-bind:href="'event/singup/'+event.id">Записаться!</a>
                    </div>
                </slide>
            </carousel>
        </div>
        <div v-else>
            <p>Нет событий</p>
            <a type="button" class="btn btn-primary" href="/myevent/store">Создать событие</a>
        </div>
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
                axios.get('/events/inmycity', {}
                )
                    .then((response) => {
                        this.eventList = response.data;
                    });
            }
        }

    }
</script>

<style scoped>
    .eventPanel {
        max-width: 100px;
    }
</style>