<template>
    <div>
        Фильтр:
        <label>Имя</label>
        <input type="text" v-model="seachName">

        <label>Есть анкета</label>
        <input type="checkbox" v-model="anketExist">
        <br>
        <label>Статус:</label><br>
        <label for="unbanned">Разблокирован</label>
        <input type="radio" id="unbanned" value="unbanned" v-model="banned" checked> <br>
        <label for="banned">Заблокирован</label>
        <input type="radio" id="banned" value="banned" v-model="banned"><br>
        <label for="never_mind">Неважно</label>
        <input type="radio" id="never_mind" value="never_mind" v-model="banned"><br>

        <button v-on:click="seach">Найти</button>

        <table class="table table-condensed">
            <thead>
            <tr>
                <th>id</th>
                <th>Пользовтель</th>
                <th>Анкета</th>
                <th>Счет</th>
                <th>Состояние</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in users">

                <td> {{item.id}}</td>
                <td>
                    {{item.name}}
                </td>

                <td>
                    <div v-if="item.id!=null">
                        <a :href="'http://sakura-city.info/anket/' + item.id "> Анкета</a>
                    </div>
                </td>
                <td>
                    {{item.money}}
                </td>
                <td>
                    <div v-if="item.banned==1">
                        Заблокарован
                    </div>
                    <div v-else>
                        Разблокирован
                    </div>
                </td>

            </tr>
            </tbody>
        </table>
    </div>
</template>


<script>

    //'./components/delModal.vue'

    export default {
        props: {},
        components: {},
        mounted() {
            this.getUsers()
        },
        data() {
            return {
                users: '',
                seachName: '',
                anketExist: true,
                banned: 'unbanned'
            }
        },
        methods: {
            getUsers() {
                this.users = null;
                axios.get('/getuserslist')
                    .then((response) => {
                        this.users = response.data;
                    });
            },
            seach() {
                console.log("seach");
                console.log(this.seachName);
                console.log(this.anketExist);
                console.log(this.banned);
                this.users = null;
                axios.get('/seachAdmin', {
                    params: {
                        seachName: this.seachName,
                        anketExist: this.anketExist,
                        banned: this.banned,
                    }
                }).then((response) => {
                    //console.log(response.data)
                    this.users = response.data;
                })
            }

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