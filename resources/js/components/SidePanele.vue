<template>
    <div>
        <b><a href="/messages">Сообщения</a>
            <div v-if="numberUnreaded" !="0">+{{numberUnreaded}}</div>
        </b><br>
        <b><a href="/applications">Заявки на открытие анкеты</a></b>
        <div v-if="numberApplication" !="0">+{{numberApplication}}</div>
        <b><a href="/edit">Редактирование анкеты</a> </b>

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
                numberUnreaded: 0,
                numberApplication: 0,
            };
        },
        mounted() {
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    //   console.log('NewMessage');
                    axios.get('/getCountUnreaded')
                        .then((response) => {
                            this.numberUnreaded = response.data;
                        })
                });
            Echo.private(`requwests.${this.user.id}`)
                .listen('newApplication', (e) => {
                       console.log('NewRequwest');
                    axios.get('/getCountUnreadedRequwest')
                        .then((response) => {
                            this.numberApplication = response.data;
                        })
                });

        },
        methods:
            {
                getNumberUnreadedMessages() {

                },
                chechAnketExist() {

                }
            }
    }
</script>


<style scoped>

</style>