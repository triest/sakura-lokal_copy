<template>
    <div>
        <b>Новые подарки для меня:</b>:
         <div v-for="present in presents">
                <b>От:{{present.who_name}}</b><br>
                <img :src="'presents/upload/'+present.pres_image" height="200">
                <button v-on:click="mark_as_readed(present.act_id)">Получен</button>
            </div>
    </div>
</template>



<script>

    //'./components/delModal.vue'

    export default {
        props: {},
        components: {},
        mounted() {
            this.getFresentsForMe()
        },
        data() {
            return {
                presents: [],
                name: '',
                price: '',
                file1: '',
                isDisabled: true,
                showModal: false
            }
        },
        methods: {
            getFresentsForMe() {
                this.presents = {};
                axios.get('/getpresentsforMe')
                    .then((response) => {
                        this.presents = response.data[0];
                    });
            },
            handleFileUpload() {
                this.file = this.$refs.file.files[0];
            },
            mark_as_readed(id) {
                console.log(id);
                let formData = new FormData();
                formData.append('present_id', id);
                axios.post('/markpresentasreaded', formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )
                    .then()
                    .catch();
                this.getFresentsForMe();
            },
            submitPresent() {
                var that = this;
                let formData = new FormData();
                formData.append('file', this.file);
                formData.append('name', this.name);
                formData.append('price', this.price);
                axios.post('/createpresent', formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then((response) => {

                        if (response.data == "ok") {
                            this.name = "";
                            this.price = "";
                            this.file = "";
                        }
                    })
                    .catch(function () {
                    });
                this.getPresents();
            },
            deleWindow(item) {
                this.id = item;
                console.log(item);
                this.showModal = true;
                axios.post('/delpresent',
                    {id: item}
                )
                    .then((response) => {

                    })
                    .catch(function () {
                    });

                this.getPresents();
            },
        }

    }
</script>

<style scoped>
    .delmodal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: table;
        transition: opacity .3s ease;

    }


</style>