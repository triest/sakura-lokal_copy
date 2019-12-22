<template>
    <div class="newMessageModal">
        <transition name="modal" @close="showModal = false">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">

                        <div class="modal-header">
                            <slot name="header">
                                Поиск:
                            </slot>
                        </div>

                        <div class="modal-body">
                            <slot name="body">
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

                                    <input type="checkbox" id="target" :checked="selected_targets.includes(target.id)">
                                    {{target.name}}

                                </div>
                            </slot>

                        </div>

                        <div class="modal-footer">
                            <slot name="footer">
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
                selected_targets: [],
                meet: "",
                checkedTarget: []
            }
        },
        methods: {
            close() {
                console.log("ren emit");
                this.$emit('closeNewMessageAlert')
            },
            findUserByid() {

            },
            saveChange() {
            },
            getSettings() {
                axios.get('anket2/getsrttings')
                    .then((response) => {
                        let res = response.data;
                        this.meet = res.anket.meet;
                        this.from = res.anket.from_age;
                        this.to = res.anket.to_age;
                        this.targets = res.targets;
                        this.selected_targets = res.selectedTargets;
                        console.log("targets");
                        console.log(this.targets)
                        console.log("selected_targets");
                        console.log(this.selected_targets)
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