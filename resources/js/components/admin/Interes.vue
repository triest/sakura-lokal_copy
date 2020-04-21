<template>
    <div>
        <label>Создать цель знакоства.<br> После добавления она будет доступна пользователям</label> <br>
        <input type="text" id="name" name="name" v-model="name" placeholder="Введите цель">
        <button v-on:click="createTarget">Создать</button>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Имя</th>
                <th scope="col">Изменить</th>
                <th scope="col">Удалить</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="target in targets">
                <td>{{target.name}}</td>
                <td>
                    <button class="btn" v-on:click="editWindow(target.id,target.name)"><i class="fa fa-pencil"></i>
                    </button>
                </td>
                <td>
                    <button class="btn" v-on:click="deleWindow(target.id,target.name)"><i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
        <modal v-if="showModal" :item_id="item" :item_name="name" v-on:close="showModal = false" @close='close()'>>
        </modal>
    </div>
</template>

<script>
    import modal from './DelInteresModal'

    export default {
        name: "listComponent",
        mounted() {
            console.log("targets");
            this.getTargets();
        },
        components: {
            modal
        },
        data() {
            return {
                targets: "",
                name: "",
                id: "",
                value_input: "",
                item: "",
                isModalVisible: true,
                showModal: false,
            }
        },
        methods: {
            getTargets() {
                this.targets = null;
                axios.get('interes')
                    .then((response) => {
                            this.targets = response.data;
                        }
                    )
            },
            editWindow(item) {
                this.id = item.id;
                this.value_input = item.name;
                this.item = item;
                $("#edit-modal").modal('show');
            },
            deleWindow(target, name) {
                console.log("show");
                console.log(target)
                this.item = target;
                this.name = name;
                this.showModal = true;
            },
            confurmDelete() {
                var that = this;
                let formData = new FormData();
                formData.append('id', this.id);
                axios.delet('interes/' + this.id, formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then((response) => {

                        if (response.data == "ok") {
                            this.name = "";
                        }
                    })
                    .catch(function () {
                    });
                this.getTargets();
                $("#del-modal").modal('hide');
            },


            createTarget() {
                var that = this;
                let formData = new FormData();
                formData.append('name', this.name);
                axios.post('interes/create', formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then((response) => {

                        if (response.data == "ok") {
                            this.name = "";
                        }
                    })
                    .catch(function () {
                    });
                this.getTargets();
            },
            saveChange() {
                let formData = new FormData();
                formData.append('name', this.item.name);
                axios.put('/interes/edit/' + this.id, formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then((response) => {

                        if (response.data == "ok") {
                            this.name = "";
                        }
                    })
                    .catch(function () {
                    });
                this.getTargets();
                $("#edit-modal").modal('show');
            },
            close() {
                this.showModal = false;
            },
        }
    }
</script>

<style scoped>

</style>