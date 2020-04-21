<template>

    <transition name="modal" @close="showModal = false">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <div class="modal-body">
                        <input type="name" class="form-control" name="name" id="name" v-model="item_name"
                               width="30">
                    </div>
                    <br>
                    <button type="button" class="btn btn-primary" v-on:click="edit()">
                        Сохранить
                    </button>
                    <button type="button" class="btn btn-secondary" v-on:click="close()">
                        Закрыть
                    </button>
                    <button type="button" class="btn btn-danger" v-on:click="delet()">
                        Удалить
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        props: {
            item_id: {
                type: '',
                required: false
            },
            item_name: {
                type: '',
                required: false
            }

        },
        name: 'modal',

        mounted() {
            console.log(this.item_id);
            console.log(this.item_name);
        },
        data() {
            return {
                bids: null,
                MessageText: "",
                name2: "",
                id: null,
            }
        },
        methods: {
            close() {
                this.$emit('close')
            },
            showBid() {
                axios.get('bid/' + this.item_id).then((response) => {
                    this.bids = response.data;
                    this.inputName = this.bids[0].name;
                    this.phone = this.bids[0].phone;
                    this.description = this.bids[0].description;
                    this.id = this.bids[0].id;
                })
            },
            edit() {

                let url = "aperance/edit/" + this.item_id;

                axios.post(url, {name: this.item_name}).then(function (response) {
                    if (response.status === "200") {
                        alert("Data accepted !");
                        this.$emit('close')
                    } else {

                    }
                }).catch(error => {
                    // error.response can be null
                    if (error.response && error.response.status === 422) {
                        let errors = error.response.data.errors;
                        let array = (Object.values(errors));
                        let message = "";
                        array.forEach(element => message += " " + element);
                        alert(message)
                    }
                })
            },
            delet() {
                let url = "aperance/delete/" + this.item_id;

                axios.post(url, {}).then(function (response) {
                    if (response.status === "200") {
                        alert("Data accepted !");
                        this.$emit('close')
                    } else {

                    }
                }).catch(error => {
                    // error.response can be null
                    if (error.response && error.response.status === 422) {
                        let errors = error.response.data.errors;
                        let array = (Object.values(errors));
                        let message = "";
                        array.forEach(element => message += " " + element);
                        alert(message)
                    }
                    if (error.response && error.response.status === 500) {
                        alert("Нельзя удалить, поскольку уже есть в анкетах!")
                    }
                    this.close();
                })
            }

        },
    };
</script>

<style>
    textarea {
        width: 90%; /* Ширина поля в процентах */
        height: 200px; /* Высота поля в пикселах */
        resize: none; /* Запрещаем изменять размер */
    }

    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 600px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        float: right;
    }

    /*
     * The following styles are auto-applied to elements with
     * transition="modal" when their visibility is toggled
     * by Vue.js.
     *
     * You can easily play with the modal transition by editing
     * these styles.
     */
    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>