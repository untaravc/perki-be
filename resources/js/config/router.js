import Layout from "../views/Layout";
import Login from "../views/login/Index";
import Dashboard from "../views/dashboard/Index";
import Posts from "../views/posts/Index";
import Transactions from "../views/transactions/Index";
import VueRouter from "vue-router";

const routes = [
    {
        path: '/panel',
        component: Layout,
        meta: {protected: true},
        children: [
            {
                path: 'dashboard',
                component: Dashboard,
                meta: {protected: true},
            },
            {
                path: 'posts',
                component: Posts,
                meta: {protected: true},
            },
            {
                path: 'transactions',
                component: Transactions,
                meta: {protected: true},
            }
        ]
    },
    {
        path: '/panel/login',
        component: Login,
    }
]

const router = new VueRouter({
    mode: 'history',
    routes
})


router.beforeEach((to, from, next) => {
    if (to.meta.protected) {
        let admin_token = localStorage.getItem('admin_token');
        if (admin_token == null) {
            next({
                path: '/panel/login',
                replace: true
            })
        }
    }

    // check accessible menu
    next();
})

export default router
