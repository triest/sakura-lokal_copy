<template>
    <div>
        <div class="container">
            <div class="large-12 medium-12 small-12 cell">
                <label>File
                    <input type="file" id="privatefile" ref="galerayFileInput"
                           v-on:change="handleFileUpload()"/>
                </label>
                <button type="button" class="btn btn-primary" v-on:click="submitFile()">Загрузить</button>
            </div>
        </div>
        <div v-for="photo in photosList">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-3 thumb">
                <p v-if="photo!=null">
                    <img :src="'/images/albums/'+photo.photo_name" height="200"
                         v-on:click="showModalFunction (photo.id,photo.photo_name)" style="cursor: pointer">
                </p>
            </div>
        </div>
        <modal v-if="showModal()===true" :id="Photoid" :name="PhotoName" @close='close()'></modal>
    </div>
</template>

<script>
    import modal from '../albums/PhotoModal.vue';


    export default {
        name: 'edit',
        props: {
            id: {
                type: Number,
                default: null,

            },
            album: {
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
                Photoid: null,
                isModalVisible: false,
                PhotoName: null,
            }
        },
        components: {
            modal
        },
        methods: {
            showModalFunction(id, name) {

                this.Photoid = id;
                this.PhotoName = name
                this.isModalVisible = true;
            },
            getPhoto() {
                this.photosList = null;
                axios.get('/myAnket/' + this.id + '/albums/' + this.album + '/photos', {
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
                        this.getPhoto();
                    });
                this.getPhoto();
            },
            showModal() {
                return this.isModalVisible;
            },
            close() {
                this.isModalVisible = false;
            }

        }
    }
</script>

<style scoped>

</style>