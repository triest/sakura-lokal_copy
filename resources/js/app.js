/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');

import VueCarousel from 'vue-carousel';

Vue.use(VueCarousel);


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ChatApp.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('index2', require('./components/index2.vue').default);
Vue.component('chat-app', require('./components/chat/ChatApp.vue').default);


Vue.component('conversation', require('./components/chat/Conversation.vue').default);


Vue.component('ContactsList', require('./components/chat/ContactsList.vue').default);


Vue.component('MessagesFeed', require('./components/chat/MessagesFeed.vue').default);


Vue.component('side-panel', require('./components/layouts/SidePanele.vue').default);
Vue.component('side-panel2', require('./components/layouts/SidePanele2.vue').default);
//Vue.component('header', require('./components/Carousel.vue').default);
Vue.component('privatepanel', require('./components/anket/Private.vue').default);

Vue.component('private2', require('./components/anket/private2.vue').default);

//компонент с заявками
Vue.component('application', require('./components/anket/Application.vue').default);

Vue.component('editimages', require('./components/anket/Editimages.vue').default);

Vue.component('modal-template', require('./components/modal-template.vue').default);

Vue.component('power', require('./components/anket/Power.vue').default);

Vue.component('carouseltemp', require('./components/layouts/CarouselTemp.vue').default);

Vue.component('presents', require('./components/admin/Presents.vue').default);

Vue.component('targets', require('./components/admin/Targets.vue').default);

Vue.component('interes', require('./components/admin/Interes.vue').default);

Vue.component('mypresents', require('./components/anket/MyPresents.vue').default);

Vue.component('likemodal', require('./components/likes/LikeModal.vue').default);

//модальное окно для отправки сообщения
//Vue.component('modal', require('./components/ModalComponent.vue'));
Vue.component('delmodal', require('./components/delModal.vue').default);


Vue.component('myanket', require('./components/anket/myAnket.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('edit', require('./components/chat/Edit.vue').default);

Vue.component('phonecomponent', require('./components/confirnPhone/phoneComponent.vue').default);

Vue.component('selectcity', require('./components/layouts/SelectCity.vue').default);

Vue.component('userscontroll', require('./components/admin/Userscontroll.vue').default);

Vue.component('moneycontroll', require('./components/admin/Moneycontroll.vue').default);

Vue.component('likes', require('./components/likes/likes.vue').default);

Vue.component('phonerequwest', require('./components/anket/phoneRequwest.vue').default);

//события
Vue.component('myevents', require('./components/events/Myevents.vue').default);

Vue.component('eventmycity', require('./components/events/eventmycity.vue').default);

//заапрос на участие в событии
Vue.component('eventrequwest', require('./components/events/Eventrequwest.vue').default);

Vue.component('requwesteventlist', require('./components/events/Requwesteventlist.vue').default);

Vue.component('eventinmycityside', require('./components/events/EventInMyCitySide.vue').default);
Vue.component('eventinmycityside2', require('./components/events/EventInMyCitySide2.vue').default);

Vue.component('viewhistory', require('./components/anket/Viewhistory.vue').default);

Vue.component('aperance', require('./components/admin/Aperance.vue').default);

Vue.component('all-event-requwet-list', require('./components/events/AllEventRequwetList.vue').default);

Vue.component('seach', require('./components/seach/index').default);

Vue.component('carusel', require('./components/carusel/carusel').default);
Vue.component('carusel-mobile', require('./components/carusel/carusel-mobile').default);

Vue.component('likeCarusel', require('./components/carusel/likeCarusel').default);

Vue.component('filteranket', require('./components/layouts/filterAnket.vue').default);

Vue.component('anketlist', require('./components/ankertList.vue').default);


Vue.component('album', require('./components/albums/album.vue').default);

Vue.component('view', require('./components/anket/view').default);

Vue.component('like', require('./components/anket/like').default);

window.onload = function () {
    const aperanceApp = new Vue({
        el: '#aperanceApp',
        data: {
            showModal: false
        }
    });

    const caruselApp = new Vue({
        el: '#caruselApp',
        data: {
            showModal: false
        }
    });

    const viewhistoryapp = new Vue({
        el: '#viewhistoryapp',
        data: {
            showModal: false
        }
    });

    const eventinmycityapp = new Vue({
        el: '#eventinmycityapp',
        data: {
            showModal: false
        }
    });

    const requwesteventlistapp = new Vue({
        el: '#requwesteventlistapp',
        data: {
            showModal: false
        }
    });

    const eventrequwestapp = new Vue({
        el: '#eventrequwestapp',
        data: {
            showModal: false
        }
    });

    const events = new Vue({
        el: '#events',
        data: {
            showModal: false
        }
    });

    const eventmycity = new Vue({
        el: '#eventmycityApp',
        data: {
            showModal: false
        }
    });

    const phoneRequwestApp = new Vue({
        el: '#phoneRequwestApp',
        data: {
            showModal: false
        }
    });


    const likesApp = new Vue({
        el: '#likesApp',
        data: {
            showModal: false
        }
    });

    const index = new Vue({
        el: '#index',
        data: {
            showModal: false
        }
    });

    const app = new Vue({
        el: '#app',
        data: {
            showModal: false
        }
    });

    const app2 = new Vue({
        el: '#app2',
        data: {
            showModal: false
        }
    });

    const app3 = new Vue({
        el: '#app3',
        data: {
            showModal: false
        }
    });

    const app4 = new Vue({
        el: '#app4',
        data: {
            showModal: false
        }
    });

    const privateApp = new Vue({
        el: '#privateApp',
        data: {
            showModal: false
        }
    });

    const app7 = new Vue({
        el: '#app7',
        data: {
            showModal: false
        }
    });

    const applicationClass = new Vue({
        el: '#applicationClass',
        data: {
            showModal: false
        }
    });

    const powerApp = new Vue({
        el: '#powerApp',
        data: {
            showModal: false
        }
    });

    const myAnket = new Vue({
        el: '#myAnketApp',
        data: {
            showModal: false
        }
    });

    const phoneApp = new Vue({
        el: '#phoneApp',
        data: {
            showModal: false
        }
    });

    const selectCityApp = new Vue({
        el: '#selectCityApp',
        data: {
            showModal: false
        }
    });

    const indexvue = new Vue({
        el: '#indexvue',
        data: {
            showModal: false
        }
    });

    const moneyApp = new Vue({
        el: '#moneyApp',
        data: {
            showModal: false
        }
    });

    const myeventApp = new Vue({
        el: '#myeventApp',
        data: {
            showModal: false
        }

        //appacepted
    });

    const appaceptedApp = new Vue({
        el: '#appaceptedApp',
        data: {
            showModal: false
        }

        //appacepted
    });

    const sidePanelApp = new Vue({
        el: '#sidePanelApp',
        data: {
            showModal: false
        }

        //appacepted
    });


    const sidePanelApp2 = new Vue({
        el: '#sidePanelApp2',
        data: {
            showModal: false
        }

        //appacepted
    });

    const eventregApp = new Vue({
        el: '#eventregApp',
        data: {
            showModal: false
        }

        //appacepted
    });

    const seachApp = new Vue({
        el: '#seachApp',
        data: {
            showModal: false
        }

        //appacepted
    });


    const private2App = new Vue({
        el: '#private2App',
        data: {
            showModal: false
        }

        //appacepted
    });

    const filterApp = new Vue({
        el: '#filterApp',
        data: {
            showModal: false
        }

        //appacepted
    });

    const anketListApp = new Vue({
        el: '#anketListApp',
        data: {
            showModal: false
        }
        //appacepted
    });

    const albumApp = new Vue({
        el: '#albumApp',
        data: {
            showModal: false
        }
        //appacepted
    });

    const ankataApp = new Vue({
        el: '#ankataApp',
        data: {
            showModal: false
        }
        //appacepted
    });
}