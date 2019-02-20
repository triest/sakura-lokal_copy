<template>
    <div>
        <b><a href="/messages">Сообщения</a>+{{numberUnreaded}}</b><br>
        <b><a href="/applications">Заявки на открытие анкеты</a></b>
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
                numberUnreaded: 0
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
        },
        methods:
            {
                getNumberUnreadedMessages() {

                }
            }
    }
</script>


<style scoped>

</style>