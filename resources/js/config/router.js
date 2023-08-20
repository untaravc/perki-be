import Layout from "../views/Layout";
import Login from "../views/login/Index";
import Dashboard from "../views/dashboard/Index";
import Users from "../views/users/Index";
import Abstract from "../views/abstracts/Index";
import Transactions from "../views/transactions/Index";
import Scanner from "../views/scanner/Index";
import EventPresence from "../views/event-presence/Index";
import MailLogs from "../views/mail-logs/Index";
import Vouchers from "../views/vouchers/Index";
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
                path: 'abstracts',
                component: Abstract,
                meta: {protected: true},
            },
            {
                path: 'users',
                component: Users,
                meta: {protected: true},
            },
            {
                path: 'transactions',
                component: Transactions,
                meta: {protected: true},
            },
            {
                path: 'event-presence',
                component: EventPresence,
                meta: {protected: true},
            },
            {
                path: 'mail-logs',
                component: MailLogs,
                meta: {protected: true},
            },
            {
                path: 'vouchers',
                component: Vouchers,
                meta: {protected: true},
            },
        ]
    },
    {
        path: '/panel/login',
        component: Login,
    },
    {
        path: '/scanner',
        component: Scanner,
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
