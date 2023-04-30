require('./bootstrap');
import 'flowbite';
import Vue from 'vue'
window.Vue = require('vue').default;

// Icon
import Unicon from 'vue-unicons/dist/vue-unicons-vue2.umd'
import icons from './config/icons'
Unicon.add(icons)

// router
import VueRouter from 'vue-router'
import router from './config/router'

// Register plugin
Vue.use(VueRouter)
    .use(Unicon,{
        height: 20,
        width: 20
    })

const app = new Vue({
    el: '#__perki_app',
    router
});
