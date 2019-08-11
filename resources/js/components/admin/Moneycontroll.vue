<template>
    <div>
        <b>Цен за перенос анкеты на первое место: </b>
        <input name="pricefirstplays" id="pricefirstplays" type="number" min="0" v-model="to_first_place">
        <button v-on:click="ChangePriceToFirstPlase">Сохранить</button>
        <br>


        <b>Цен за перенос поещение анкеты в шапку сайта: </b>
        <input name="priceToTop" id="priceToTop" type="number" min="0" v-model="to_top"><br>
        <button v-on:click="ChangePriceToTop">Сохранить</button>
        <br>

        <b>Цен за смену аватара: </b>
        <input name="priceToChange" id="priceToChange" type="number" min="0" v-model="change_main_image"><br>
        <button v-on:click="ChangePriceToChange">Сохранить</button>
        <br>

        <b>Цен за помещение анкеты в поиск: </b>
        <input name="priceToSeach" id="priceToSeach" type="number" min="0" v-model="seach">
        <button v-on:click="ChangePriceToSeach">Сохранить</button>
        <br>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log("moneyControll");
            this.getPrices();
        },
        data() {
            return {
                to_first_place: "",
                to_top: "",
                change_main_image: "",
                seach: ""
            };
        },
        comments: {},
        methods:
            {
                getPrices() {
                    axios.get('/getpricestotop')
                        .then((response) => {
                            //console.log(response.data);
                            this.to_top = response.data[0];
                        });

                    axios.get('/getpricetoseach')
                        .then((response) => {
                            //console.log(response.data)
                            this.seach = response.data[0];
                        });

                    axios.get('/getpricetofirstplace')
                        .then((response) => {
                            this.to_first_place = response.data[0];
                        });

                    axios.get('/getpricechangemainimage')
                        .then((response) => {
                            this.change_main_image = response.data[0];
                        })
                },
                ChangePriceToFirstPlase() {
                    let formData = new FormData();
                    formData.append('pricename','to_first_place');
                    formData.append('price',this.pricefirstplays);
                    axios.post('/changePrice',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(function () {
                        console.log('SUCCESS!!');
                        getmainImage();
                    })
                        .catch(function () {
                            getmainImage();
                        });
                },
                ChangePriceToTop(){
                    let formData = new FormData();
                    formData.append('pricename','to_top');
                    formData.append('price',this.to_top);
                    axios.post('/changePrice',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(function () {
                        console.log('SUCCESS!!');
                        getmainImage();
                    })
                        .catch(function () {
                            getmainImage();
                        });
                },
                ChangePriceToChange(){
                    let formData = new FormData();
                    formData.append('pricename','change_main_image');
                    formData.append('price',this.change_main_image);
                    axios.post('/changePrice',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(function () {
                        console.log('SUCCESS!!');
                        getmainImage();
                    })
                        .catch(function () {
                            getmainImage();
                        });
                },
                ChangePriceToSeach(){
                    let formData = new FormData();
                    formData.append('pricename','seach');
                    formData.append('price',this.seach);
                    axios.post('/changePrice',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(function () {
                        console.log('SUCCESS!!');
                        getmainImage();
                    })
                        .catch(function () {
                            getmainImage();
                        });
                }
            }
    }
</script>

<style scoped>


</style>