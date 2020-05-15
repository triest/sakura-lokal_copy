<template>
    <div class="col-ml-4" style="width: 375px;  margin-left: auto;
    margin-right: auto">
        <carousel :per-page="3" :mouse-drag="false" :autoplay="true" :loop="true" :centerMode="true"
                  :navigationEnabled="false" :navigation-enabled="true" :paginationEnabled="false">
            <slide>
                <div class="flex-center2 position-ref">
                    <a :href="'/power'">
                        <img :src="'/images/anketa.jpeg'" width="100" height="80">
                    </a>
                </div>
            </slide>
            <slide>
                <div class="flex-center2 position-ref">
                    <a :href="'/power'">
                        <img :src="'/images/anketa.jpeg'"  width="100" height="100">
                    </a>
                </div>
            </slide>
            <slide>
                <div class="flex-center2 position-ref">
                    <a :href="'/power'">
                        <img :src="'/images/anketa.jpeg'"  width="100" height="100">
                    </a>
                </div>
            </slide>
        </carousel>
        <eventmodal v-if="showEventmodal" @close="clouseModal()"></eventmodal>
        <!--Здесь будут увдомления -->
    </div>
</template>

<script>
    import eventmodal from '../events/EventModal'

    export default {
        props: {
            user: {
                type: Object,
                required: false
            }
        },
        data() {
            return {
                imagesList: [],
                showEventmodal: false
            };
        },
        components: {
            eventmodal,
        },
        mounted() {
            if (typeof this.user !== 'undefined') {
                Echo.private(`App.User.${this.user.id}`)
                    .listen('Newevent', (e) => {
                        console.log(e.eventreq)
                        console.log(e)
                        console.log("new Event22");
                        axios.get('/events/')
                            .then((response) => {
                                this.numberUnreaded = response.data;
                            });
                        this.showEventmodal = true;
                    });
            }
            this.getmainImage();

        },
        methods:
            {
                getmainImage() {
                    axios.get('/getdataforcarousel')
                        .then((response) => {
                            this.imagesList = response.data;
                        });
                },
                clouseModal() {
                    this.showEventmodal = false;
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