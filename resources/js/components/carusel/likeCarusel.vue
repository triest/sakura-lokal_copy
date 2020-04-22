<template>
    <div class="panel panel-default panel-body">

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-5 box-shadow">
            <div style="width: 500px;  margin-left: auto;  margin-right: auto;  left: 50%;
  top: 50%;">

                <a :href="/anket/+item.id">
                    <img :src="'images/upload/'+item.main_image" height="500px" width="350px">
                </a>

            </div>
            <button class="btn btn-primary" v-on:click="like()"
                    style="position: absolute; margin-top: -50px; margin-left: 5px">
                Нравиться
            </button>
            <button class="btn btn-default" v-on:click="skip()"
                    style="position: absolute; margin-top: -50px; margin-left: 105px">
                Пропустить
            </button>
            <button class="btn btn-danger" v-on:click="dislike()"
                    style="position: absolute; margin-top: -50px;  margin-left: 212px">Не
                нравиться
            </button>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-9 box-shadow">
            <div class="cell">
                <div class="cell-overflow">
                    <b> {{item.name}}, {{item.age}}</b>
                    <p>
                        <small>{{city.name}}</small>
                    </p>
                    <p v-if="online=='null'"> {{item.last_login}}
                    <p v-else>
                        {{lastLogin}}
                    </p>

                    <b>Цель знакомства</b>
                    <div v-for="item in targets">
                        {{item.name}},
                    </div>

                    <b>Интересы</b>
                    <div v-for="item in interets">
                        {{item.name}},
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "kikeCarusel",
        mounted() {
            this.getAnket();
        },
        data() {
            return {
                mainImage: null,
                girl_id: null,
                anketList: [],
                item: null,
                online: null,
                city: null,
                targets: [],
                interets: [],
                lastLogin: null,
            }
        },
        methods:
            {
                getAnket() {
                    axios.get('like-carusel/getAnket')
                        .then((response) => {
                            this.item = response.data.ankets;
                            this.online = response.data.online;
                            this.city = response.data.city;
                            this.targets = response.data.targets;
                            this.interets = response.data.interets;
                            this.interets = response.data.interets;
                            this.lastLogin = response.data.lastLogin
                        });
                },
                like() {
                    console.log("like");
                    axios.get('like-carusel/newLike', {
                        params: {
                            anket_id: this.item.id,
                            action: "like",
                        }
                    })
                        .then((response) => {
                            this.getAnket();
                        });
                },
                dislike() {
                    axios.get('like-carusel/newLike', {
                        params: {
                            anket_id: this.item.id,
                            action: "dislike",
                        }
                    })
                        .then((response) => {
                            this.getAnket();
                        });
                },
                skip() {
                    axios.get('like-carusel/newLike', {
                        params: {
                            anket_id: this.item.id,
                            action: "skip",
                        }
                    })
                        .then((response) => {
                            this.getAnket();
                        });
                },

            }
    }


</script>

<style scoped>
</style>