<template>
    $END$
</template>

<script>
    export default {
        props: {},
        components: {},
        mounted() {
            this.getNewPresentsForMe(),
                this.getNewPresentsHistory(),
                this.getNewPresentsFromMe(),
                this.currentTab='new';
        },
        data() {
            return {
                presents: [],
                presentsHistoryFoME: [],
                presentsHistoryFromMe: [],
                name: '',
                price: '',
                file1: '',
                isDisabled: true,
                showModal: false,
                //currentTab: 'foMe',
                currentTab: 'new'
            }
        },
        methods: {
            getNewPresentsForMe() {
                this.presents = null;
                axios.get('/getpresentsforMe')
                    .then((response) => {
                        this.presents = response.data[0];
                    });
            },
            getNewPresentsFromMe() {
                this.presents = null;
                axios.get('/getpresentsFromMe')
                    .then((response) => {
                        this.presentsHistoryFromMe = response.data[0];
                    });
            },

            getNewPresentsHistory() {
                this.presents = null;
                axios.get('/getpresentsHistoryforMe')
                    .then((response) => {
                        this.presentsHistoryFoME = response.data[0];
                    });
            },

            handleFileUpload() {
                this.file = this.$refs.file.files[0];
            },
            mark_as_readed(id) {
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
                this.getNewPresentsForMe();
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

</style>