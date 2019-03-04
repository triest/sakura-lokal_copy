<template>

    <div>
        <b>Текущее состояние счета: {{money.money}}</b>
        <br>
        <b> Поместить анкету в шапку сайта(сменяемое меню) на 24 часа за {{priceToTop[0][0].price}} рублей:</b>
        <br>
        <b>Поднять анкету на первое место за {{priceToTop[1][0].price}} рублей</b>
        <button v-on:click="toFirstPlase()">Поднять анкету на первое место</button>
        <br>

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
                money: "",
                prices: "",
                priceToTop: ""
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
            this.getMoneut(),
                this.getPrices()
        },
        methods:
            {
                getMoneut() {
                    axios.get('/getMoney')
                        .then((response) => {
                            this.money = response.data;
                        });
                },
                getPrices() {
                    var returnedData = "";
                    axios.get('/getpricestotop')
                        .then((response) => {
                            this.priceToTop = response.data;
                        });
                },
                toFirstPlase() {
                    axios.get('/tofirstplaсe')
                        .then((response) => {
                            console.log(response.data)
                        });
                }
            }
    }
</script>

<style scoped>

</style>