<template>

    <div>
        <p>Главная фотография:</p>
        <p v-if="mainImage!=null">
            <img :src="'images/upload/'+mainImage" height="150">
        </p>
        <div class="container">
            <div class="large-12 medium-12 small-12 cell">
                <label>File
                    <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
                </label>
                <button v-on:click="submitFile()">Submit</button>
            </div>
        </div>

        Галлерея:
        <div class="container">
            <div class="large-12 medium-12 small-12 cell">
                <label>File
                    <input type="file" id="galeray" ref="galerayFile" v-on:change="handleFileUploadGaleay()"/>
                </label>
                <button v-on:click="submitGaleray()">Submit</button>
            </div>
        </div>

        <div v-for="image in images">
            <p v-if="image!=null">
                <img :src="'images/upload/'+image.photo_name" height="200">
            </p>
            <button class="btn btn-danger" v-on:click="deleteGelataiImage(image.photo_name)">Удалить</button>
        </div>

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
                mainImage: null,
                file: '',
                galerayFile: '',
                showModal: false,
                images: []
            };
        },
        computed: {
            getImageUrl: function () {
                return this.getmainImage();
            }
        },
        mounted() {
            this.getmainImage(),
                this.getimages()
        },
        methods:
            {
                getmainImage() {
                    axios.get('/getmainImage')
                        .then((response) => {
                            this.mainImage = response.data;
                        });
                },
                getimages() {
                    this.images = null;
                    axios.get('/getImages')
                        .then((response) => {
                            this.images = response.data;
                        });
                },
                chechAnketExist() {

                },
                submitFile() {
                    /*
                            Initialize the form data
                        */
                    let formData = new FormData();
                    formData.append('file', this.file);
                    axios.post('/updateMainImage',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(function () {
                        console.log('SUCCESS!!');
                        this.getmainImage();
                    })
                        .catch(function () {
                            this.getmainImage();
                        });
                },
                submitGaleray() {
                    /*
                            Initialize the form data
                        */
                    let formData = new FormData();
                    formData.append('file', this.galerayFile);
                    axios.post('/updateGalerayImage',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(function () {
                        console.log('SUCCESS!!');
                        this.getimages();
                    })
                        .catch(function () {
                            this.getimages();
                        });
                    this.getimages();
                },

                handleFileUpload() {
                    this.file = this.$refs.file.files[0];
                },
                handleFileUploadGaleay() {
                    this.galerayFile = this.$refs.galerayFile.files[0];
                },
                deleteGelataiImage(image) {

                    axios.get('/deleteImage', {
                            params: {
                                imagename: image
                            }
                        }
                    )
                        .then((response) => {
                            this.getimages();
                        });
                    this.getimages();
                }
            }
    }
</script>

<style scoped>

</style>