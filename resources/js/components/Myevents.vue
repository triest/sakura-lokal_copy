<template>
    <div>
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
                <td><a :href="'/viewmyevent/' +event.id">{{event.name}}</a></td>
                <td>{{event.city_name}}</td>
                <th>{{event.place}}</th>
                <td>{{event.begin}}</td>
                <td>{{event.status_name}}</td>
                <td>{{event.created_at}}</td>
                <td>{{event.updated_at}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: {},
        components: {},
        mounted() {
            console.log("myevents");
            this.getEvents();
        },
        data() {
            return {
                events: ""
            }
        },
        methods: {
            getEvents() {
                axios.get('/myeventslist')
                    .then((response) => {
                        this.events = response.data.events;
                    });
            }
        }
    }
</script>

<style scoped>

</style>