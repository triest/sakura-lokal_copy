<template>
    <div class="newMessageModal">
        <transition name="modal" @close="showModal = false">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">

                        <div class="modal-header">
                            <slot name="header">
                                Поиск1:
                            </slot>
                        </div>

                        <div class="modal-body">
                            <slot name="body">
                                <form id="inputForm" name="inputForm">
                                    <p>
                                        <label>Ищу:</label>
                                        <select id="meet" class="meet" style="width: 100px" name="meet" v-model="meet">
                                            <option value="famele">Девушку</option>
                                            <option value="male">Парня</option>
                                        </select>
                                    </p>
                                    <p>
                                        <label>Возраст:</label> от <input type="number" name="from" id="from" min="18"
                                                                          v-model="from"
                                                                          onkeypress="return isNumber(event)"
                                                                          style="width: 50px">
                                        до <input type="number" name="to" id="to" min="18"
                                                  v-model="to"
                                                  onkeypress="return isNumber(event)" style="width: 50px">

                                    </p>

                                    <label>Цель:</label>

                                    <div v-for="target in targets">
                                        <input type="checkbox" :id="target.id" :v-model="select2tarrget"
                                               :checked="selected_targets.includes(target.id)">
                                        {{target.id}} {{target.name}}

                                    </div>

                                    <div v-for="item in interest">
                                        <input type="checkbox" :id="item.id"
                                               :checked="selected_interest.includes(item.id)">
                                        {{item.name}}
                                    </div>

                                    <label>Дети:</label>

                                    <div v-for="item in children">
                                        <input type="radio" :value="item.id" id="item.id" v-model="select2children"/>
                                        {{item.name}}
                                    </div>
                                </form>
                            </slot>
                        </div>

                        <div class="modal-footer">
                            <slot name="footer">
                                <button class="modal-default-button" v-on:click="saveChange()">
                                    Найти
                                </button>
                                <button class="modal-default-button" v-on:click="close()">
                                    Закрыть
                                </button>
                            </slot>
                        </div>
                    </div>

                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: {},
        name: 'modal',
        mounted() {
            this.getSettings();
        },
        data() {
            return {
                seach: "",
                from: "18",
                to: "18",
                targets: "",
                interest: " ",
                selected_targets: [],
                selected_interest: [],
                meet: "",
                checkedTarget: [],
                children: "",
                select2tarrget: [],
                select2interest: [],
                select2children: [],
                target: [],
                target_active: [],
                selected_clildren: "",
            }
        },
        methods: {
            close() {
                console.log("ren emit");
                this.$emit('closeSeachModal')
            },
            findUserByid() {

            },
            saveChange() {


                axios.post('/anket2/savesettings', {
                    meet: this.meet,
                    from: this.from,
                    to: this.to,
                    select_target: this.select2tarrget,
                    selected_interes: this.select2interest,
                    children: this.select2children,
                    target: this.select2tarrget,
                    selected_clildren: "",

                }).then((response) => {
                    this.$emit('closeSeachModal')
                });
            },
            getSettings() {
                axios.get('anket2/getsrttings')
                    .then((response) => {
                        let res = response.data;
                        //   this.meet = res.anket.meet;
                        //  this.from = res.anket.from_age;
                        //  this.to = res.anket.to_age;
                        this.targets = res.targets;
                        this.selected_targets = res.selectedTargets;
                        console.log(this.selected_targets);
                        this.interest = res.interests;
                        this.selected_interest = res.selectedInterest;
                        this.children = res.chidren;

                        this.selected_clildren = res.sechSettings.children;
                        this.select2children = this.selected_clildren;
                        console.log(this.selected_clildren)
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

    .newMessageModal {
        position: fixed;
        bottom: 0;
        right: 0;
        z-index: 999;
    }

    input.apple-switch {
        position: relative;
        appearance: none;
        outline: none;
        width: 50px;
        height: 30px;
        background-color: #ffffff;
        border: 1px solid #D9DADC;
        border-radius: 50px;
        box-shadow: inset -20px 0 0 0 #ffffff;
        transition-duration: 200ms;
    }

    input.apple-switch:after {
        content: "";
        position: absolute;
        top: 1px;
        left: 1px;
        width: 26px;
        height: 26px;
        background-color: transparent;
        border-radius: 50%;
        box-shadow: 2px 4px 6px rgba(0, 0, 0, 0.2);
    }

    input.apple-switch:checked {
        border-color: #4ED164;
        box-shadow: inset 20px 0 0 0 #4ED164;
    }

    input.apple-switch:checked:after {
        left: 20px;
        box-shadow: -2px 4px 3px rgba(0, 0, 0, 0.05);
    }
</style>