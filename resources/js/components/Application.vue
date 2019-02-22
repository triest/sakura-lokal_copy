<template>
    <div class="application">

        Просьбы предоставить доступ:
        <div v-for="application in applications">
            <div class="avatar">
                <img :src="'images/upload/'+application.main_image" :alt="application.name" height="150">
            </div>
            <div class="contact">
                <p class="name">{{ application.name }}</p>
            </div>
            <button v-on:click="getNewApplication(application.id)">Предоставить доступ</button>
            <button v-on:click="denideNewApplication(application.id)">Закрыть доступ</button>
        </div>
        <br>
        Мои запросы на открытие анкеты:
        <div v-for="application in myapplications">
            <div class="avatar">
                <img :src="'images/upload/'+application.main_image" :alt="application.name" height="150">
            </div>
            <div class="contact">
                <p class="name">{{ application.name }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                applications: [],
                myapplications: []
            };
        },
        mounted() {
            this.getApplications(),
                this.getMyApplications()
        },
        methods:
            {
                getApplications() {
                    axios.get('/getapplication')
                        .then((response) => {
                            this.applications=[];
                            this.applications = response.data;
                        })
                },
                getMyApplications() {
                    axios.get('/getmyapplication')
                        .then((response) => {
                            this.myapplications = response.data;
                        })
                },
                denideNewApplication(girl_id) {
                    console.log(girl_id)
                    axios.get('/denideaccess', {
                        params: {
                            id: girl_id,

                        }
                    })
                        .then((response) => {
                            //this.applications = response.data;
                           // console.log(response.data)
                            if (response.data=='ok'){
                                this.getApplications();
                            }
                        })
                },
                getNewApplication(user_id) {
                    axios.get('/geteaccess', {
                        params: {
                            id: user_id
                        }
                    })
                        .then((response) => {
                            if (response.data=='ok'){
                                this.getApplications();
                            }
                        })
                },


            }
    }
</script>

<style scoped>

</style>