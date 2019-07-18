<template>
    <div>
        <div v-if="requwestSended=='false'">
            <button class="btn-default" v-on:click="makeRequwest()">Отправить заявку на мероприятие
            </button>
        </div>
        <h5 v-if="requwestStatus=='notreaded'"><b>Ваша заявка на участие в мероприятии не рассмотренна</b></h5>
        <h5 v-if="requwestStatus=='aсcept'"><b>Заявка на участие  принята!</b></h5>
        <h5 v-if="requwestStatus=='denide'"><b>Заявка на участие отклонена</b></h5>
    </div>
</template>

<script>
    export default {
        props: {
            event: {
                type: Object,
                required: false
            },
        },
        mounted() {
            console.log("event req");
            console.log(this.event.id);
            this.checkRequwet();
        },
        data() {
            return {
                requwestSended: false,
                requwestStatus: null
            }
        },
        methods: {
            makeRequwest() {
                console.log("make req");
                axios.get('/event/makerequwest', {
                    params: {
                        id: this.event.id
                    }
                })
                    .then((response) => {
                        //console.log(response.data);
                        this.checkRequwet()
                    });
                this.checkRequwet()
            },
            checkRequwet() {
                axios.get('/event/checkrequwest', {
                    params: {
                        id: this.event.id
                    }
                })
                    .then((response) => {
                        //console.log(response.data);
                        var res = response.data;
                        if (res == "notsend") {
                            this.requwestSended = 'false';
                        }
                        else if (res['status'] == 'unredded') {
                            this.requwestSended = true;
                            this.requwestStatus= "notreaded";
                        }
                        else if (res['status'] == 'accept') {
                            this.requwestSended = true;
                            this.requwestStatus= "aсcept";
                        }
                    })
            }
        }
    }
</script>

<style scoped>
</style>