<template>
    <div>
        <div class="container">
            <div class="large-12 medium-12 small-12 cell">
                <label>File
                    <input type="file" id="privatefile" ref="galerayFileInput"
                           v-on:change="handleFileUpload()"/>
                </label>
                <button v-on:click="submitFile()">Загрузить</button>
            </div>
        </div>
        <div v-for="photo in photosList">
            <p v-if="photo!=null">
                <img :src="'/images/albums/'+photo.photo_name" height="200">
            </p>
        </div>
    </div>
</template>

<script>

    export default {
        name: 'edit',
        props: {
            id: {
                type: Number,
                default: null,

            }
        },
        mounted() {
            console.log("album");
            console.log(this.id);
            this.getPhoto();
        },
        data() {
            return {
                photosList: [],
                page: 1,
                numPages: null,
                count: 0,
                galerayFile: '',
                comment: "",
            }
        },
        methods: {
            getPhoto() {
                axios.get('/myAnket/albums/' + this.id + '/photos', {
                    params:
                        {
                            type: "json"
                        }
                }).then((response) => {
                    this.photosList = response.data.photos;
                })
            },
            handleFileUpload() {
                this.galerayFile = this.$refs.galerayFileInput.files[0];
            },
            submitFile() {
                let formData = new FormData();
                formData.append('file', this.galerayFile);
                formData.append('album', this.id);
                formData.append('comment', this.comment);
                axios.post('/myAnket/albums/' + this.id + '/upload',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(function () {
                    this.getPhoto();
                })
                    .catch(function () {
                    });
                this.getimages();
            },

        }
    }
</script>

<style scoped>

</style>