<template>
    <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
        data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
        data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
        <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
            <router-link to="/panel/dashboard">
                <div class="app-sidebar-logo-default">
                    <div class="d-flex align-items-center">
<!--                        <img alt="" src="https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2Fperki-logo.jpg?alt=media&token=9eec70ac-f79c-4c19-b2c3-fc23a2cde454" class="h-35px app-sidebar-logo-default">-->
                        <div class="text-white fw-bold ms-3 text-lg">
                            <span class="text-white">Perki</span> <span class="text-danger">Jogja</span>
                        </div>
                    </div>
                </div>
                <img alt="Logo" src="https://firebasestorage.googleapis.com/v0/b/unt-dev.firebasestorage.app/o/Perki%2Fperki-logo.jpg?alt=media&token=9eec70ac-f79c-4c19-b2c3-fc23a2cde454" class="h-20px app-sidebar-logo-minimize">
            </router-link>
            <div id="kt_app_sidebar_toggle"
                class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
                data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                data-kt-toggle-name="app-sidebar-minimize">
                <span class="svg-icon svg-icon-2 rotate-180">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.5"
                            d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                            fill="currentColor"></path>
                        <path
                            d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                            fill="currentColor"></path>
                    </svg>
                </span>
                <i class="ki-duotone ki-abstract-26">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
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
                data-kt-scroll-save-state="true" style="height: 771px;">
                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">
                    <div v-for="menu in sidebar.menu">
                        <div class="menu-item" v-if="!menu.children && menu.type !== 'title'">
                            <!--begin:Menu link-->
                            <router-link class="menu-link" :to="menu.url">
                                <span class="menu-icon">
                                    <v-icon :name="menu.icon" />
                                </span>
                                <span class="menu-title">{{ menu.title }}</span>
                            </router-link>
                        </div>
                        <div data-kt-menu-trigger="click" v-if="menu.children && menu.children.length > 0"
                            class="menu-item menu-accordion">
                            <span class="menu-link">
                                <span class="menu-icon">
                                    <v-icon :name="menu.icon" />
                                </span>
                                <span class="menu-title">{{ menu.title }}</span>
                                <span class="menu-arrow"></span>
                            </span>
                            <!--end:Menu link-->
                            <!--begin:Menu sub-->
                            <div class="menu-sub menu-sub-accordion" :kt-hidden-height="menu.children.length * 40"
                                style="display: none; overflow: hidden;">
                                <div class="menu-item" v-for="cld in menu.children">
                                    <router-link class="menu-link" :to="cld.url">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">{{ cld.title }}</span>
                                    </router-link>
                                </div>
                            </div>
                            <!--end:Menu sub-->
                        </div>
                        <div class="menu-item pt-5" v-if="menu.type === 'title'">
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">{{ menu.title }}</span>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!--end::sidebar menu-->
        <!--begin::Footer-->
        <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
            <div @click="logout"
                class="btn btn-flex flex-center btn-custom btn-primary overflow-hidden text-nowrap px-0 h-40px w-100"
                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss-="click" data-kt-initialized="1">
                <span class="btn-label">Logout</span>
                <!--begin::Svg Icon | path: icons/duotune/general/gen005.svg-->
                <span class="svg-icon btn-icon svg-icon-2 m-0">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3"
                            d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z"
                            fill="currentColor"></path>
                        <rect x="7" y="17" width="6" height="2" rx="1" fill="currentColor"></rect>
                        <rect x="7" y="12" width="10" height="2" rx="1" fill="currentColor"></rect>
                        <rect x="7" y="7" width="6" height="2" rx="1" fill="currentColor"></rect>
                        <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"></path>
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
        </div>
        <!--end::Footer-->
    </div>
    <!--end::sidebar-->
</template>

<script>
import useAxios from "../src/service";
import { reactive, onMounted } from "vue";
import { useFilterStore } from "../src/store_filter";

export default {
    mounted() {

    },
    setup() {
        const { getData } = useAxios()

        const { app_store } = useFilterStore()

        function logout() {
            localStorage.removeItem('user_token')
            window.location = '/auth/login'
        }

        let menu_authorized = [];
        const sidebar = reactive({ menu: {} })

        function loadMenu() {
            getData('menu')
                .then((data) => {
                    sidebar.menu = data.result

                    data.result.forEach((item) => {
                        menu_authorized.push(item.url)
                        if (item.children) {
                            item.children.forEach((cld) => {
                                menu_authorized.push(cld.url)
                            })
                        }
                    })


                })
        }

        loadMenu();

        onMounted(() => {
            emitter.on("sidebar-update-menu", isOpen => {
                loadMenu()
            });
        })

        return {
            logout,
            sidebar,
            app_store
        }
    }
}
</script>
