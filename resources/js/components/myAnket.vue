<template>
    <div>
        <div class="col-md-4">
            <img :src="'/images/upload/'+anket.main_image" height="150">
            <a href="/mypresents"> <img :src="'/images/gift.png'" height="100"></a>
        </div>
        <div class="col-md-3">
            <h4>{{anket.name}}</h4>
            <div v-if="anket.sex=='famele'">
                Женщина
            </div>
            <div v-else-if="anket.sex=='male'">
                Meжчина
            </div>
        </div>

    </div>

</template>

<script>
    export default {
        name: "myAnket",
        mounted() {
            console.log("mounted");
            this.getMyAnketData();
        },
        data() {
            return {
                applications: [],
                myapplications: [],
                whocansee: [],
                currentTab: 'main',
                anket: ""
            };
        },
        methods:
            {
                getMyAnketData() {
                    axios.get('/getMyAnketData')
                        .then((response) => {
                            this.anket = response.data[0]
                        })
                }
            }
    }
</script>

<style scoped>

</style>