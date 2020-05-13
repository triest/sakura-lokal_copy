<template>
    <div class="col-ml-4" style="width: 414px;  margin-left: auto;
    margin-right: auto">
        <carousel :per-page="3" :mouse-drag="false" :autoplay="true" :loop="true" :centerMode="true"
                  :navigationEnabled="false" :navigation-enabled="true" :paginationEnabled="false">
            <slide>
                <div class="flex-center2 position-ref">
                    <a :href="'/power'">
                        <img :src="'/images/anketa.jpeg'" height="100">
                    </a>
                </div>
            </slide>
            <slide>
                <div class="flex-center2 position-ref">
                    <a :href="'/power'">
                        <img :src="'/images/anketa.jpeg'" height="100">
                    </a>
                </div>
            </slide>
            <slide>
                <div class="flex-center2 position-ref">
                    <a :href="'/power'">
                        <img :src="'/images/anketa.jpeg'" height="100">
                    </a>
                </div>
            </slide>
            <slide>
                <div class="flex-center2 position-ref">
                    <a :href="'/power'">
                        <img :src="'/images/anketa.jpeg'" height="100">
                    </a>
                </div>
            </slide>
        </carousel>

        <!--Здесь будут увдомления -->
    </div>
</template>

<script>

    export default {
        props: {
            user: {
                type: Object,
                required: false
            }
        },
        data() {
            return {
                imagesList: []
            };
        },
        mounted() {
            Echo.private(`App.User.${this.user.id}`)
                .listen('Newevent', (e) => {
                    console.log(e.eventreq)
                    console.log(e)
                    console.log("new Event22");
                    axios.get('/events/')
                        .then((response) => {
                            this.numberUnreaded = response.data;
                        });
                    alert("Вы приглашены на мнроприятие! http://newchat/myevent#")
                });
            this.getmainImage();

        },
        methods:
            {
                getmainImage() {
                    axios.get('/getdataforcarousel')
                        .then((response) => {
                            this.imagesList = response.data;
                        });
                }
            }
    };
</script>

<style scoped>


    .carousel {
        text-align: center; /* Родительскому задать выравнивание по центру */
    }

    .flex-center2 {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }
</style>