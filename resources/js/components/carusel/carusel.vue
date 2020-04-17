<template>
    <div class="col-ml-4" style="width: 500px;  margin-left: auto;
    margin-right: auto">
        <carousel :per-page="3" :mouse-drag="false" :autoplay="true" :loop="true" :centerMode="true"
                  :navigationEnabled="false" :navigation-enabled="true" :paginationEnabled="false">
            <slide>
                <div class="flex-center2 position-ref">
                    <a :href="'/power'">
                        <img :src="'/images/anketa.jpeg'" height="100">
                    </a>
                </div>
            </slide>
            <slide>
                <div class="flex-center2 position-ref">
                    <a :href="'/power'">
                        <img :src="'/images/anketa.jpeg'" height="100">
                    </a>
                </div>
            </slide>
            <slide>
                <div class="flex-center2 position-ref">
                    <a :href="'/power'">
                        <img :src="'/images/anketa.jpeg'" height="100">
                    </a>
                </div>
            </slide>
            <slide>
                <div class="flex-center2 position-ref">
                    <a :href="'/power'">
                        <img :src="'/images/anketa.jpeg'" height="100">
                    </a>
                </div>
            </slide>
        </carousel>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                imagesList: []
            };
        },
        mounted() {
            this.getmainImage()
        },
        methods:
            {
                getmainImage() {
                    axios.get('/getdataforcarousel')
                        .then((response) => {
                            this.imagesList = response.data;
                        });
                }
            }
    };
</script>

<style scoped>


    .carousel {
        text-align: center; /* Родительскому задать выравнивание по центру */
    }

    .flex-center2 {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }
</style>