<template>
    <div>
        <div v-for="item in viewArray">
            <div class="row">
                <div class="col-lg-4 col-md-3 col-sm-5 col-xs-9 box-shadow">
                    <img :src="'images/upload/'+item.main_image" height="200">
                </div>
                <div class="col-lg-4 col-md-3 col-sm-5 col-xs-9 box-shadow">
                    <p><b>{{item.name}}</b></p>
                    <p>{{item.city_name}}</p>
                    <p>{{item.time}}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log("Viewhistory");
            this.gitViews();
        },
        data() {
            return {
                viewArray: [],
            }
        },
        methods: {
            gitViews() {
                axios.get('/gethistory')
                    .then((response) => {
                            this.viewArray = response.data;

                        }
                    )
            },
        }
    }
</script>

<style scoped>

</style>