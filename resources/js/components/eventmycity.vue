<template>
    <div>

        <div v-for="event in events">
            {{event.name}} <br>
            Начало: {{event.begin}} <br>
            Место: {{event.place}}<br>

            <a v-bind:href="'/singup/'+event.id+''">Записаться</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            city: {
                type: Object,
                required: true
            }
        },


        data() {
            return {
                events: []

            };
        },
        computed: {
            getImageUrl: function () {
                return this.getmainImage();
            },
            getImagesUrls: function () {
                return this.getimages()
            }

        },
        mounted() {
            console.log("eventmycity");
            //console.log("id my city " + this.city)
            this.findEventsInMyCity();
        },
        methods:
            {
                findEventsInMyCity() {
                    axios.get('/eventsinmycity', {
                        params: {id: this.city}
                    })
                        .then((response) => {
                            this.events = response.data;
                            //console.log(response.data[0])
                        });
                    console.log(this.events)
                }
            }
    }


</script>

<style scoped>

</style>