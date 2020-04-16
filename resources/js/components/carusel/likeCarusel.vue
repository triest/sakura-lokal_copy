<template>
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
                            this.girl_id = anketList[0].id;
                            console.log("id ");
                            console.log(this.girl_id);
                        });
                },
                like() {
                    console.log("like");
                    axios.get('like-carusel/newLike', {
                        params: {
                            anket_id: item_id,
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
                            anket_id: item_id,
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

    .cell {
        position: absolute;
        top: 350px;
        right: 0;
        bottom: 300px;
        left: 0;
        box-sizing: border-box;
        display: block;
        padding: 200px;
        width: 100%;
        color: white !important;
        text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
    }

    .cell-overflow {
        box-sizing: border-box;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: white;
    }
</style>