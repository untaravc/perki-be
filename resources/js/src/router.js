import { createWebHistory, createRouter } from "vue-router";
import Layout from "../pages/Layout";
import Dashboard from "../pages/dashboard/Index";
import Users from "../pages/users/Index";
import UserAddEdit from "../pages/users/AddEdit";
import Roles from "../pages/roles/Index";
import RolesAddEdit from "../pages/roles/AddEdit";
import Menus from "../pages/menus/Index";
import MenusAddEdit from "../pages/menus/AddEdit";
import MenuRole from "../pages/menus/MenuRole";
import Profile from "../pages/auth/Profile";

import Login from "../pages/auth/Login";
import NotFound from "../pages/auth/404";
import ForgotPassword from "../pages/auth/ForgotPassword";

import Category from "../pages/categories/Index.vue";
import CategoryAddEdit from "../pages/categories/AddEdit.vue";
import Posts from "../pages/posts/Index.vue";
import PostsAddEdit from "../pages/posts/AddEdit.vue";
import Transactions from "../pages/transactions/Index.vue";
import TransactionsAddEdit from "../pages/transactions/AddEdit.vue";
import Vouchers from "../pages/vouchers/Index.vue";
import VouchersAddEdit from "../pages/vouchers/AddEdit.vue";

const routes = [
    {
        path: "/panel",
        name: "Layout",
        component: Layout,
        children: [
            { path: 'dashboard', component: Dashboard, meta: { protected: true, title: "Dashboard" } },
            { path: 'users', component: Users, meta: { protected: true, title: "Data Staff" } },
            { path: 'users/:id', component: UserAddEdit, meta: { protected: true, title: "Sistem Antrian" } },
            { path: 'roles', component: Roles, meta: { protected: true, title: "Role" } },
            { path: 'roles/:id', component: RolesAddEdit, meta: { protected: true, title: "Role" } },
            { path: 'menus', component: Menus, meta: { protected: true, title: "Menu" } },
            { path: 'menus/:id', component: MenusAddEdit, meta: { protected: true, title: "Menu" } },
            { path: 'menu-role', component: MenuRole, meta: { protected: true, title: "Menu Role" } },
            { path: 'profile', component: Profile, meta: { protected: true, title: "Profile" } },

            { path: 'categories/:id', component: CategoryAddEdit, meta: { protected: true, title: "Category" } },
            { path: 'categories', component: Category, meta: { protected: true, title: "Category" } },
            { path: 'posts', component: Posts, meta: { protected: true, title: "Posts" } },
            { path: 'posts/:id', component: PostsAddEdit, meta: { protected: true, title: "Post" } },
            { path: 'transactions/:id', component: TransactionsAddEdit, meta: { protected: true, title: "Post" } },

            { path: 'transactions', component: Transactions, meta: { protected: true, title: "Transactions" } },
            { path: 'archived-transactions', component: Dashboard, meta: { protected: true, title: "Transactions" } },
            { path: 'pages', component: Dashboard, meta: { protected: true, title: "Transactions" } },
            { path: 'posts', component: Dashboard, meta: { protected: true, title: "Transactions" } },
            { path: 'archived-posts', component: Dashboard, meta: { protected: true, title: "Transactions" } },
            { path: 'events', component: Dashboard, meta: { protected: true, title: "Transactions" } },
            { path: 'events/:id', component: Dashboard, meta: { protected: true, title: "Event" } },
            { path: 'vouchers', component: Vouchers, meta: { protected: true, title: "Voucher" } },
            { path: 'vouchers/:id', component: VouchersAddEdit, meta: { protected: true, title: "Voucher | Edit Add" } },
            { path: 'settings', component: Dashboard, meta: { protected: true, title: "Transactions" } },
            { path: 'settings/:id', component: Dashboard, meta: { protected: true, title: "Transactions" } },
        ]
    },
    { path: "/auth/404", name: "not-found", component: NotFound },
    { path: "/auth/login", name: "login", component: Login },
    { path: "/auth/forgot-password", name: "forgot-password", component: ForgotPassword },
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

router.beforeEach(async (to, from) => {
    let isAuthenticated = localStorage.getItem('user_token');
    if (!isAuthenticated && to.meta.protected) {
        window.location = '/auth/login'
    }
})

const DEFAULT_TITLE = 'Tenis Indo';
router.afterEach((to, from) => {
    document.title = to.meta.title || DEFAULT_TITLE;
});

export default router;
