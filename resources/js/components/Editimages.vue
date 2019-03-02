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
    </div>
</template>

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
                file: ''
            };
        },
        computed: {
            getImageUrl: function () {
                return this.getmainImage();
            }
        },
        mounted() {
            this.getmainImage()
        },
        methods:
            {
                getmainImage() {
                    axios.get('/getmainImage')
                        .then((response) => {
                            this.mainImage = response.data;
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
                handleFileUpload() {
                    this.file = this.$refs.file.files[0];
                }
            }
    }
</script>

<style scoped>

</style>