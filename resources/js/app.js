/** Dependencies **/
import Vue from 'vue';
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

require('./bootstrap');

/** Initilization **/
window.Vue = require('vue').default;

/** Vue components **/
Vue.component('disease-center', require('./components/DiseaseCenter.vue').default);
Vue.component('laboratory', require('./components/Laboratory.vue').default);

/** Vuetify initialization **/
const vuetify = new Vuetify();

Vue.use(Vuetify)

const app = new Vue({
    el: '#app',
    vuetify
});
