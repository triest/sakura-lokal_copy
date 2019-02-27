<template>
    <div>
        <p>ds</p>
        <p v-if="mainImage!=null">
            <img :src="public/mainImage">
        </p>
    </div>
</template>

<script>
    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                mainImage: null
            };
        },
        mounted() {
            this.getmainImage()
        },
        methods:
            {
                getmainImage() {
                    axios.get('/getmainImage')
                        .then((response) => {
                            this.mainImage = response.data;
                            //console.log(this.mainImage)
                        });
                },
                chechAnketExist() {

                }
            }
    }
</script>

<style scoped>

</style>