<template>
    <div>
        <carousel :per-page="1"  :mouse-drag="false" :autoplay="true" :loop="true">
            <slide>
                Slide 1 Content
            </slide>
            <slide>
                Slide 2 Content
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
            console.log("carousel mounted")
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