<template>
    <div>
        <img height="20" src="/images/heart.png"> {{likesNunber}}
        <div v-if="auth">
            <div v-if="showSendLike=='false'">
                <p>Вам нравиться эта анкета</p>
            </div>
            <div v-else>
                <button v-on:click="newLike()">
                    <img height="20" src="/images/heart.png" alt="Постивить отметку">
                </button>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: {
            user: {
                type: Object,
                required: false
            },
            girlid: {
                type: Number,
                required: true
            }
        },
        mounted() {
            console.log("likes");
            this.authOrNot();
            console.log("girl id: " + this.girlid)
            this.getLikesNumber();
            if (this.user != null) {
                this.checkLike();
            }
        },
        data() {
            return {
                auth: false,
                likesNunber: 0,
                likeSended: false,
                responseSender: '',
                showSendLike: false
            }
        },
        methods: {
            authOrNot() {
                if (this.user != null) {
                    this.auth = true;
                    console.log("auth user")
                }
                else {
                    this.auth = false;
                    console.log("not auth user")
                }
            },
            newLike() {
                console.log("new like");
                console.log(this.girlid);
                axios.get('/newlike', {
                    params: {
                        girl_id: this.girlid
                    }
                })
                    .then((response) => {
                        if (!response.data) {

                        }
                        else {
                            this.isOpen = false;

                        }
                    });
                this.checkLike();
                this.getLikesNumber();
            },
            getLikesNumber() {
                axios.get('/getLikesNumber', {
                    params: {
                        girl_id: this.girlid
                    }
                })
                    .then((response) => {

                        // this.likesNunber = response.data;
                        //    console.log(response.data)
                        //console.log("likes number "+response.data['likeNumber']);
                        this.likesNunber = response.data['likeNumber']
                    });
                console.log("likes number " + this.likesNunber)
            },
            checkLike() { //проверяет, отправлен ли like
                axios.get('/likeSended', {
                    params: {
                        girl_id: this.girlid
                    }
                })
                    .then((response) => {
                        //console.log(response.data())
                        this.responseSender = response.data;
                        if (this.responseSender == "alredy") {
                            console.log("alredy");
                            this.showSendLike = "false";

                        } else {
                            this.showSendLike = "true";
                        }
                    });

            }
        }
    }

</script>

<style scoped>

</style>