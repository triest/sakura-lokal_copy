<template>
    <div>
        <div v-if="sendedLike==false">
            <button class="btn btn-primary" v-on:click="like()"
                    style="position: absolute; margin-top: -50px; margin-left: 5px">
                Нравиться
            </button>
        </div>
        <div v-else>
            Вам нравиться эта анкета
        </div>
    </div>

</template>

<script>
    export default {
        props: {
            item_id: {
                type: '',
                required: true
            },
            autch_id: {
                id: {
                    type: '',
                    required: false
                },
            }
        },
        data() {
            return {
                sendedLike: false
            }

        },
        mounted() {
            console.log("like 1");
            console.log(this.item_id);
            this.checkLike()
        },
        methods: {
            checkLike() {
                axios.get('/like-carusel/checkLike', {
                    params: {
                        anket_id: this.item_id
                    }
                }).then((response) => {
                    console.log("response1");
                    console.log(response.data);

                    if (response.data == true) {
                        this.sendedLike = true;
                    } else {
                        this.sendedLike = false;
                    }
                });
            },
            like() {
                console.log("like");
                axios.get('/like-carusel/newLike', {
                    params: {
                        anket_id: this.item_id,
                        action: "like",
                    }
                })
                    .then((response) => {
                    });
            },
        }
    }
</script>

<style scoped>

</style>