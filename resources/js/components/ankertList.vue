<template>
    <div>

        <div v-for="item in anketList">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-9 box-shadow">
                <a :href="/anket/+item.id">
                    <img width="200" height="200" :src="'images/upload/'+item.main_image">
                </a>
                <div class="cell">
                    <div class="cell-overflow">
                        {{item.name}}
                    </div>
                    {{item.age}}
                </div>
            </div>
        </div>
        <a class="previous " v-if="page<numPages"><a v-on:click="loadNew">Загрузить еще</a></a>

    </div>
</template>

<script>

    export default {
        name: 'edit',
        mounted() {
            this.seach();
            this.scroll();
        },
        data() {
            return {
                anketList: [],
                page: 1,
                numPages: null,
                count: 0,
            }
        },
        methods: {

            seach() {
                console.log("seach");
                axios.get('/seach').then((response) => {
                    let data = response.data;
                    this.anketList = data.ankets;
                    this.numPages = data.num_pages;
                    this.count = data.count;

                })
            },

            scroll() {
                window.onscroll = () => {
                    let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;

                    if (bottomOfWindow && page < numPages) {
                        this.loadNew();
                    }
                }
            },
            loadNew() {
                this.page++;
                console.log(this.page);
                axios.get('/seach',
                    {
                        params:
                            {
                                page: this.page
                            }
                    }
                ).then((response) => {
                    //  this.anketList.push(response.data);
                    let data = response.data;
                    let temp = data.ankets;
                    for (let i = 0; i < temp.length; i++) {
                        console.log(temp[i]);
                        this.anketList.push(temp[i]);
                    }
                })
            }
        }
    }
</script>

<style scoped>
    * {
        box-sizing: border-box;
    }

    .circle:before {
        content: ' \25CF';
        font-size: 20px;
        margin: 0 auto;
        position: absolute;
        bottom: 0;
        background: rgb(0, 0, 0); /* Fallback color */
        background: rgba(145, 100, 153, 0); /* Black background with 0.5 opacity */
        color: #20f100;
        width: 100%;
        padding: 10px;
    }

    body {
        font-family: Arial;
        font-size: 17px;
    }

    .container {
        position: relative;
        max-width: 800px;
        margin: 0 auto;
    }

    .container img {
        vertical-align: middle;
    }

    .container .content {
        position: absolute;
        bottom: 0;
        background: rgb(0, 0, 0); /* Fallback color */
        background: rgba(0, 0, 0, 0); /* Black background with 0.5 opacity */
        color: #f1f1f1;
        width: 100%;
        padding: 0px;
        margin: 115px;
    }

    .cell {
        position: absolute;
        top: 120px;
        right: 0;
        bottom: 30px;
        left: 0;
        box-sizing: border-box;
        display: block;
        padding: 20px;
        width: 100%;
        color: white !important;
        text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
        cursor: pointer;
    }

    .cell-overflow {
        box-sizing: border-box;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: white;
        cursor: pointer;
    }

    .previous {
        background-color: #f1f1f1;
        color: black;
        cursor: pointer;
        /*  position: absolute;*/
        width: 50%;
        margin: 50%;
    }

    .white:link {
        color: white;
    }
</style>