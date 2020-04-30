<template>
    <div>
        <div v-if="sendedLike==false">
            <button class="btn btn-primary" v-on:click="like()"
                    style="position: absolute; margin-top: -50px; margin-left: 5px">
                Нравиться
            </button>
        </div>
        <div v-else>
            <div class="panel panel-default">
                <div class="panel-body">
                    Вам нравиться {{item.name}}
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: {
            item: {
                type: Object,
                required: false
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
            this.checkLike()
        },
        methods: {
            checkLike() {
                axios.get('/like-carusel/checkLike', {
                    params: {
                        anket_id: this.item.id
                    }
                }).then((response) => {
                    if (response.data == true) {
                        this.sendedLike = true;
                    } else {
                        this.sendedLike = false;
                    }
                });
            },
            like() {
                axios.get('/like-carusel/newLike', {
                    params: {
                        anket_id: this.item.id,
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