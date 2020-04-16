<template>
    <div>
        <div style="width: 500px;  margin-left: auto;  margin-right: auto;  left: 50%;
  top: 50%;">
            <div v-for="item in anketList">
                <a :href="/anket/+item.id">
                    <img :src="'images/upload/'+item.main_image">
                </a>
                <div class="cell">
                    <div class="cell-overflow">
                        {{item.name}} {{item.age}}
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary" v-on:click="like()">Like</button>
        <button class="btn btn-danger" v-on:click="dislike()">Like</button>
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
            }
        },
        methods:
            {
                getAnket() {
                    axios.get('like-carusel/getAnket')
                        .then((response) => {
                            this.anketList = response.data.ankets;
                            this.girl_id = this.anketList[0].id;
                            console.log("id ");
                            console.log(this.girl_id);
                        });
                },
                like() {
                    console.log("like");
                    axios.get('like-carusel/newLike', {
                        params: {
                            anket_id: this.girl_id,
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
                            anket_id: this.girl_id,
                            action: "dislike",
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