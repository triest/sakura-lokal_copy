<template>
    <div>
        <ul class="nav nav-tabs">
            <li role="presentation" @click="currentTab = 'createmy'"><a href="#"><b>Созданные мной</b></a></li>
            <li role="presentation" @click="currentTab = 'participation'"><a href="#"><b>С моим участием</b></a></li>
        </ul>
        <div class="tab-content">
            <div v-if="currentTab == 'createmy'">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>Событие</th>
                        <th>Город</th>
                        <th>Место события</th>
                        <th>Дата события</th>
                        <th>Статус события</th>
                        <th>Создано</th>
                        <th>Изменено</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="event in events">
                        <!--  <a :href="'/anket/'+like.id"> -->
                        <td><a :href="'/myevent/' +event.id">{{event.name}}</a></td>
                        <td>{{event.city_name}}</td>
                        <th>{{event.place}}</th>
                        <td>{{event.begin}}</td>
                        <td>{{event.event_statys}}</td>
                        <td>{{event.created_at}}</td>
                        <td>{{event.updated_at}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div v-if="currentTab == 'participation'">
                <table class="table table-condensed">
                    <thead>
                    <tr>
                        <th>Событие</th>
                        <th>Город</th>
                        <th>Место события</th>
                        <th>Дата события</th>
                        <th>Статус события</th>
                        <th>Создано</th>
                        <th>Изменено</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="event in myparticipationList">
                        <!--  <a :href="'/anket/'+like.id"> -->
                        <td><a :href="'/event/singup/' +event.id">{{event.name}}</a></td>
                        <td>{{event.city_name}}</td>
                        <th>{{event.place}}</th>
                        <td>{{event.begin}}</td>
                        <td>{{event.event_statys}}</td>
                        <td>{{event.created_at}}</td>
                        <td>{{event.updated_at}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {},
        components: {},
        mounted() {
            console.log("myevents");
            this.getEvents();
            this.myparticipation();
        },
        data() {
            return {
                events: "",
                myparticipationList: "",
                currentTab: 'createmy'
            }
        },
        methods: {
            getEvents() {
                axios.get('/myevent/list')
                    .then((response) => {
                        this.events = response.data.events;
                    });
            },
            myparticipation() {
                axios.get('/event/myparticipation')
                    .then((response) => {
                        this.myparticipationList = response.data;
                    });
            }
        }
    }
</script>

<style scoped>

</style>