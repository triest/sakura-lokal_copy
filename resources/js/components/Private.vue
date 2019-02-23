<template>
    <div>
        <p>Private</p>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('private')
            this.khowHasPrivateOrNot()
        },
        methods: {
            khowHasPrivateOrNot(){
                axios.get('/getIsPrivateOrNot')
                .then((response) => {
                    //this.numberUnreaded = response.data;

                })
            },
        }
    }
</script>

<style scoped>

</style>