<template>
    <div>
        <label for="city">Введите город</label>
        <input type="text" id="city" @input="findCity" v-model="city" name="city">
    </div>
</template>

<script>
    export default {
        data() {
            return {
                city: ""
            }
        },
        mounted() {
            console.log(this.city)
            console.log("targets");
        },
        methods: {
            findCity() {
                console.log(this.city);
                console.log("input")
                    .$http.get('http://geohelper.info/api/v1/cities?apiKey=tVRFVy5LNE0I3NGs4KT1xBdqEbM1xQHz&locale[lang]=ru&filter[name]=%D0%9F%D0%B5', function (data, status, request) {
                    if (status == 200) {
                        this.weather = data;
                        console.log(this.weather);
                    }
                });
                axios.get('http://geohelper.info/api/v1/cities', {
                    params: {
                        apiKey: "tVRFVy5LNE0I3NGs4KT1xBdqEbM1xQHz",
                        'locale[lang]': "ru",
                        'filter[name]': this.city
                    }
                })
                    .then((response) => {
                        console.log(response.data)
                    });
            }
        }
    }
</script>

<style scoped>

</style>