require('./bootstrap');
import 'flowbite';
import Vue from 'vue'

window.Vue = require('vue').default;

import VueRouter from 'vue-router'
import TobBar from './components/Topbar'
import SideBar from './components/Sidebar'
import Layout from './views/Layout'
import Dashboard from './views/dashboard'
import Posts from './views/posts'

Vue.component('top-bar', TobBar)
Vue.component('side-bar', SideBar)

const routes = [
    {
        path: '/panel',
        component: Layout,
        children:[
            {
                path: 'dashboard',
                component: Dashboard,
            },
            {
                path: 'posts',
                component: Posts,
            }
        ]
    },
]

const router = new VueRouter({
    mode: 'history',
    routes
})
Vue.use(VueRouter);

const app = new Vue({
    el: '#__tenisindo',
    router
});
