window.Vue = require('vue');

//window.axios = require('axios');

import AppComponent from './components/AppComponent.vue'
import Router from './router/router.js'
import Vuetify from 'vuetify'
import axios from 'axios'
import VueHtmlToPaper from 'vue-html-to-paper'
import VueApexCharts from 'vue-apexcharts'

window.axios = axios.create()


Vue.component('apexchart', VueApexCharts)

Vue.use(Vuetify,{
    iconfont: 'md'
});

Vue.use(VueHtmlToPaper, {
    name: '_blank',
    specs: [
        'fullscreen=no',
        'titlebar=no',
        'scrollbars=yes'
    ],
    styles: [
        '/css/print.css',
        '/css/app.css',
    ],
});


Vue.use(VueApexCharts);

const app = new Vue({
    el: '#app',
    components: {
        AppComponent,
    },
    router: Router,
    // render: h => h(AppComponent),
    
});
