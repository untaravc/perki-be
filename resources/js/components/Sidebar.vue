<template>
    <!--begin::sidebar-->
    <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
        data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
        data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
        <!--begin::Logo-->
        <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
            <!--begin::Logo image-->
            <div class="d-flex align-items-center justify-content-center">
                <div>
                    <img alt="MEP HEHA" src="/assets/logo/PERKI-logo.jpg" style="height: 25px" class="app-sidebar-logo-default">
                    <img alt="MEP HEHA" src="/assets/logo/PERKI-logo.jpg" style="height: 15px" class="app-sidebar-logo-minimize">
                </div>
                <div style="font-size: 15px; color: #c7c7c7; font-weight: 600; padding-left: 10px"
                    class="app-sidebar-logo-default">

                </div>
            </div>
            <!--end::Logo image-->
            <!--begin::Sidebar toggle-->
            <div id="kt_app_sidebar_toggle"
                class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
                data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                data-kt-toggle-name="app-sidebar-minimize">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
                <span class="svg-icon svg-icon-2 rotate-180">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.5"
                            d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                            fill="currentColor">
                        </path>
                        <path
                            d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                            fill="currentColor"></path>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
            <!--end::Sidebar toggle-->
        </div>
        <!--end::Logo-->
        <!--begin::sidebar menu-->
        <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
            <!--begin::Menu wrapper-->
            <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
                data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true" style="height: 755px;">
                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">

                    <div v-for="menu in main_menu" :key="menu.id">
                        <div class="menu-item" v-if="menu.children === null">
                            <router-link class="menu-link" :to="menu.link">

                                <span class="menu-title ms-1">{{ menu.name }}</span>
                            </router-link>
                        </div>

                        <div data-kt-menu-trigger="click" v-if="menu.children != null" class="menu-item menu-accordion">
                            <span class="menu-link">

                                <span class="menu-title ms-1">{{ menu.name }}</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <div class="menu-sub menu-sub-accordion" :kt-hidden-height="menu.height">
                                <div class="menu-item" v-for="submenu in menu.children" :key="submenu.id">
                                    <router-link class="menu-link" :to="submenu.link">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title ml-2">{{ submenu.name }}</span>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            main_menu: [
                {
                    name: 'Dashboard',
                    icon: "/assets/media/icons/duotune/general/gen025.svg",
                    link: "/panel/dashboard",
                    children: null,
                },
                {
                    name: 'Management',
                    icon: "",
                    link: "#",
                    children: [
                        {
                            link: "/panel/admin",
                            name: "Admin",
                        },
                    ],
                },
            ],
            types: [],
        }
    },
    methods: {
        getMenu() {
            this.authGet('menu')
                .then((data) => {
                    this.main_menu = data.result.menu
                    this.project_menu = data.result.projects
                });
        },
        loadType() {
            this.authGet('type/list?sort=type_id&dir=ASC&limit=1000')
                .then((data) => {
                    let asset_arr = [];
                    data.result.data.forEach((type)=>{
                        asset_arr.push({
                            link: '/panel/master-assets?type_id=' + type.type_id,
                            name: type.type_name,
                        })
                    })

                    let asset = this.main_menu.find((item) => {
                        return item.name === 'Master Assets'
                    })

                    asset.children = asset_arr
                });
        }
    },
    created() {
        // this.loadType();
    },
    computed:{
        type_menu(){
            return this.types
        }
    }
}
</script>
