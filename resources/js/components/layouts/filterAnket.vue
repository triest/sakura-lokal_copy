<template>
    <div style="z-index: -1">
        <input id="checkbox1" type="checkbox" v-model="filter_enable" :onclick="changeFilter()">
        <label for="checkbox1">Фильтр анкет</label>
        <seachModal v-if="seachModalShow" :event="event" @closeSeachModal="closeSeachModal()"
                    @closeNewMessageAlert="closeNewMessageAlert()"></seachModal>
        <button class="btn-primary" v-on:click="openSeachModal()">Настроить фильтр</button>
    </div>
</template>

<script>
    import seachModal from '../chat/seachModal'

    export default {
        name: "FilterApp",
        props: {
            user: {
                type: Object,
                required: false
            }
        },
        components: {
            seachModal
        },
        mounted() {
            console.log("filter App");
            this.getAnkets();
        },
        data() {
            return {
                filter_enable: false,
                seachModalShow: false,
                ankets: [],
                response: [],
                currentPage: 1,
                numPages: null

            }
                ;
        },
        methods:
            {
                getAllDataForSidePanel() {
                    var data = null;
                    axios.get('/getfilterenable', {
                        params: {
                            girl_id: this.girlid
                        }
                    })
                        .then((response) => {
                            data = response.data;
                            console.log(data);
                            if (data[0] == 1) {
                                this.filter_enable = true;
                            } else {
                                this.filter_enable = false;
                            }
                        });
                },
                openSeachModal() {
                    this.seachModalShow = true;
                },
                closeSeachModal() {
                    this.seachModalShow = false;
                    this.getAnkets();
                },
                changeFilter() {
                    axios.get("filter_enable", {params: {filter: this.filter_enable}}).then((response) => {

                    }).catch(error => console.log(error));
                },
                getAnkets() {
                    this.ankets = [];
                    axios.get("anket3/getankets", {params: {page: this.currentPage}}).then((response) => {
                        this.response = response.data;
                        this.ankets = this.response.ankets;
                        this.numPages = this.response.numPages;
                    })

                },
                nextPage() {
                    this.currentPage++;
                    this.getAnkets();
                },
                prevesionPage() {
                    this.currentPage--;
                    this.getAnkets();
                }

            }
    }
</script>

<style scoped>
    /* прячем стандартный чекбокс */
    input[type="checkbox"] {
        display: none;
    }

    /* стили для метки */
    input[type="checkbox"] + label {
        cursor: pointer;
        padding-left: 50px;
        position: relative;
        font-family: tahoma, sans-serif, arial;
        line-height: 40px;
    }

    /* стили для поля с бегунком*/
    input[type="checkbox"] + label::before {
        content: "";
        display: inline-block;
        position: absolute;
        top: 0;
        left: 0;
        vertical-align: middle;
        padding: 0;
        height: 24px;
        width: 36px;
        margin: 0 5px 0 0;
        border: 1px solid #dadada;
        border-radius: 12px;
        background: #dddddd;
    }

    /* стили для бегунка*/
    input[type="checkbox"] + label::after {
        content: "";
        display: block;
        position: absolute;
        top: 1px;
        left: 1px;
        width: 22px;
        height: 22px;
        border-radius: 22px;
        background: #fff;
        border: 1px solid #dadada;
        box-shadow: 0 3px 3px rgba(140, 140, 140, .1);
    }

    /* плавность )) */
    input[type="checkbox"] + label::before,
    input[type="checkbox"] + label::after {
        -webkit-transition: all .2s ease-out;
        transition: all .2s ease-out;
    }

    /* чекнутое состояние )) */
    input[type="checkbox"]:checked + label::before {
        background: #6edc5f;
        border-color: #6dd75e;
    }

    input[type="checkbox"]:checked + label::after {
        left: 13px;
    }

    /*стиль кнопок*/

    a {
        text-decoration: none;
        display: inline-block;
        padding: 8px 16px;
    }

    a:hover {
        background-color: #ddd;
        color: black;
    }

    .previous {
        background-color: #f1f1f1;
        color: black;
    }

    .next {
        background-color: #110aaf;
        color: white;

    }

    .next:hover {
        cursor: pointer;
    }

    .previous:hover {
        cursor: pointer;
    }

    .round {
        border-radius: 50%;
    }
</style>