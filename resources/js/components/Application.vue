<template>
    <div class="application">
        Заявки:
        <div v-for="application in applications">
            <div class="avatar">
                <img :src="'images/upload/'+application.main_image" :alt="application.name" height="150" >
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
                applications: []
            };
        },
        mounted() {
            this.getApplications()
        },
        methods:
            {
                getApplications() {
                    axios.get('/getapplication')
                        .then((response) => {
                            this.applications = response.data;
                        })
                }
            }
    }
</script>

<style scoped>

</style>