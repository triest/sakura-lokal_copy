<template>
    <div class="newMessageModal">
        <transition name="modal" @close="showModal = false">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">
                        <div class="modal-body">
                            <slot name="body">
                                <form id="inputForm" name="inputForm">
                                    <p>
                                        <label>Ищу:</label>
                                        <select id="meet" class="meet" name="meet" v-model="meet">
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
                                    <div v-for="item in targets">
                                        <label class="switch">
                                            <input type="checkbox" :id="item.id" :value="item.id"
                                                   v-model="select2targets">
                                            <label class="onoffswitch-label" for="myonoffswitch">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>

                                        </label>
                                        {{item.name}}

                                    </div>

                                    <label>Интересы:</label>

                                    <div v-for="item in interest">
                                        <label class="switch">
                                            <input type="checkbox" :id="item.id" :value="item.id"
                                                   v-model="select2inters">
                                            <span class="slider round"></span>
                                        </label>
                                        {{item.name}}
                                    </div>

                                    <label>Дети:</label>

                                    <div v-for="item in children">
                                        <label class="switch">
                                            <input type="radio" :value="item.id" v-model="select2children"/>
                                            <span class="slider round"></span>
                                        </label>
                                        {{item.name}}
                                    </div>
                                </form>
                            </slot>
                        </div>


                        <slot name="footer">
                            <button class="btn btn-primary" v-on:click="saveChange()">
                                Найти
                            </button>
                            <button class="btn btn-secondary" v-on:click="close()">
                                Закрыть
                            </button>
                        </slot>

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
                meet: "",
                children: [],
                select2targets: [],
                select2inters: [],
                select2children: null,
                seachSettings: null,
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
                    interests: this.select2inters,
                    children: this.select2children,
                    targets: this.select2targets
                }).then((response) => {
                    this.getSettings();
                });
            },
            getSettings() {
                axios.get('anket2/getsrttings')
                    .then((response) => {
                        let res = response.data;
                        this.targets = res.targets;
                        this.select2targets = res.selectedTargets;
                        this.select2inters = res.selectedInterest;
                        this.interest = res.interests;
                        this.children = res.chidren;
                        this.seachSettings = res.sechSettings;
                        this.from = this.seachSettings.age_from;
                        this.to = this.seachSettings.age_to;
                        this.select2children = this.seachSettings.children;
                        this.meet = this.seachSettings.meet;
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
        height: 13px;
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