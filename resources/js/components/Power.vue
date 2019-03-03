<template>

    <div>
        <b>Текущее состояние счета: {{money.money}}</b>

    </div>
</template>

<!--Модальное -->


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
                money: ""
            };
        },
        computed: {
            getImageUrl: function () {
                return this.getmainImage();
            },
            getImagesUrls: function () {
                return this.getimages()
            }

        },
        mounted() {
            this.getMoneut()
        },
        methods:
            {
                getMoneut() {
                    axios.get('/getMoney')
                        .then((response) => {
                            this.money = response.data;
                        });
                }
            }
    }
</script>

<style scoped>

</style>