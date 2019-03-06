<template>
    <div>
        <carousel :per-page="1" :mouse-drag="false" :autoplay="true" :loop="true">

            <slide v-for="image in imagesList" :key="image[0].id">
                <img :src="'images/upload/'+image[0].main_image" height="50">
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

</style>