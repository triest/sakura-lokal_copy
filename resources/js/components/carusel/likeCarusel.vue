<template>
    <div style="width: 500px;  margin-left: auto;  margin-right: auto;  left: 50%;
  top: 50%;">
        <img :src="'images/upload/'+mainImage">
        <button class="btn btn-primary" style="  margin-left: auto;  margin-right: auto;  left: 50%;
  top: 50%;" v-on:click="like()">Нравиться
        </button>
        <button class="btn btn-danger" v-on:click="dislike()" style="  margin-left: auto;  margin-right: auto;  left: 50%;
  top: 50%;">Не нравиться
        </button>
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
                girl_id: null
            }
        },
        methods:
            {
                getAnket() {
                    axios.get('like-carusel/getAnket')
                        .then((response) => {
                            this.mainImage = response.data.main_image;
                            this.girl_id = response.data.id;
                        });
                },
                like() {
                    console.log("like");
                    axios.get('like-carusel/newLike', {
                        params: {
                            girl_id: this.girl_id
                        }
                    })
                        .then((response) => {
                            this.getAnket();
                        });
                },
                dislike() {

                },

            }
    }


</script>

<style scoped>

</style>