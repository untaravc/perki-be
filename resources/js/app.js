require('./bootstrap');

import 'flowbite';

import Vue from 'vue'
window.Vue = require('vue').default;

require('./config/filter');
require('./config/components');

// Icon
import Unicon from 'vue-unicons/dist/vue-unicons-vue2.umd'
import icons from './config/icons'
Unicon.add(icons)

window.Fire = new Vue();

// router
import VueRouter from 'vue-router'
import router from './config/router'

import mixin from './config/mixin'

// Register plugin
Vue.use(VueRouter)
    .mixin(mixin)
    .use(Unicon,{
        height: 20,
        width: 20
    })

const app = new Vue({
    el: '#__perki_app',
    router,
    mixins: mixin
});
