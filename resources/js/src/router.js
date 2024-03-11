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

import Competition from "../pages/competitions/Index.vue";
import CompetitionAddEdit from "../pages/competitions/AddEdit.vue";
import Category from "../pages/categories/Index.vue";
import CategoryAddEdit from "../pages/categories/AddEdit.vue";
import Player from "../pages/players/Index.vue";
import PlayerAddEdit from "../pages/players/AddEdit.vue";
import Matches from "../pages/matches/Index.vue";
import MatchesAddEdit from "../pages/matches/AddEdit.vue";
import Points from "../pages/points/Index.vue";
import PointsAddEdit from "../pages/points/AddEdit.vue";
import PointsReport from "../pages/points/Report.vue";
import Posts from "../pages/posts/Index.vue";
import PostsAddEdit from "../pages/posts/AddEdit.vue";

const routes = [
    {
        path: "/admin",
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

            { path: 'players', component: Player, meta: { protected: true, title: "Player" } },
            { path: 'players/:id', component: PlayerAddEdit, meta: { protected: true, title: "Player" } },
            { path: 'categories/:id', component: CategoryAddEdit, meta: { protected: true, title: "Category" } },
            { path: 'categories', component: Category, meta: { protected: true, title: "Category" } },
            { path: 'competitions/:id', component: CompetitionAddEdit, meta: { protected: true, title: "Competition" } },
            { path: 'competitions', component: Competition, meta: { protected: true, title: "Competition" } },
            { path: 'points', component: Points, meta: { protected: true, title: "Points" } },
            { path: 'points/:id', component: PointsAddEdit, meta: { protected: true, title: "Points" } },
            { path: 'point-reports', component: PointsReport, meta: { protected: true, title: "Points" } },
            { path: 'matches', component: Matches, meta: { protected: true, title: "Matches" } },
            { path: 'matches/:id', component: MatchesAddEdit, meta: { protected: true, title: "Matches" } },
            { path: 'posts', component: Posts, meta: { protected: true, title: "Posts" } },
            { path: 'posts/:id', component: PostsAddEdit, meta: { protected: true, title: "Post" } },
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
