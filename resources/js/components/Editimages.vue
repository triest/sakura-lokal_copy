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
                    <input type="file" id="galeray" ref="galerayFileInput" v-on:change="handleFileUploadGaleay()"/>
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
        <br>
        Приватные фотографии:
        <div class="container">
            <div class="large-12 medium-12 small-12 cell">
                <label>File
                    <input type="file" id="privatefile" ref="privatefileInput" v-on:change="handlePrivateFileUpload()"/>
                </label>
                <button v-on:click="submitPrivateFile()">Submit</button>
            </div>
        </div>
        <div v-for="image in privateimages">
            <p v-if="image!=null">
                <img :src="'images/upload/'+image.photo_name" height="200">
            </p>
            <button class="btn btn-danger" v-on:click="deletePrivateGelataiImage(image.photo_name)">Удалить</button>
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
                images: [],
                privateimages: [],
                privatefile: '',
                privatefileInput: ''
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
            this.getmainImage(),
                this.getimages(),
                this.getprivateimages()
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
                    console.log("get images");
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
                    formData.append('file', this.galerayFile);
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
                    })
                        .catch(function () {
                        });
                    this.getimages();
                },
                submitPrivateFile() {
                    /*
                            Initialize the form data
                        */
                    let formData = new FormData();
                    formData.append('file', this.privatefile);
                    axios.post('/updatePrivateGalerayImage',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(function () {
                    })
                        .catch(function () {
                        });
                    this.getimages();
                },

                handleFileUpload() {
                    this.file = this.$refs.file.files[0];
                },
                handleFileUploadGaleay() {
                    this.galerayFile = this.$refs.galerayFileInput.files[0];
                },
                handleFileUploadPrivateGaleay() {
                    this.privatefile = this.$refs.privatefileInput.files[0];
                },
                handlePrivateFileUpload() {
                    this.privatefile = this.$refs.privatefileInput.files[0];
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
                },
                deletePrivateGelataiImage(image) {

                    axios.get('/deletePrivateImage', {
                            params: {
                                imagename: image
                            }
                        }
                    )
                        .then((response) => {
                            this.getprivateimages();
                        });
                    this.getimages();
                },
                getprivateimages() {
                    console.log("get private images");
                    this.privateimages = null;
                    axios.get('/getPrivateImages')
                        .then((response) => {
                            this.privateimages = response.data;
                        });
                },
            }
    }
</script>

<style scoped>

</style>