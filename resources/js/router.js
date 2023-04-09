window.Vue = require('vue').default;

//VUE ROUTER
import VueRouter from 'vue-router'

Vue.use(VueRouter);

import Home from './view/dashboard/Index'
import Admin from './view/admin/Index'

const routes = [
    {path: '/', component: require('./view/Layout.vue').default},
    {
        path: '/panel',
        component: require('./view/Layout.vue').default,
        children: [
            {path: 'dashboard', component: Home,},
            {path: 'admin', component: Admin,},
        ]
    },
]

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;
