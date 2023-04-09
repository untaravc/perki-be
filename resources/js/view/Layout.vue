<template>
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <TopBar></TopBar>
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            <Sidebar></Sidebar>
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <router-view></router-view>
                <Footer></Footer>
            </div>
        </div>
    </div>
</template>
<script>
import Sidebar from '../components/Sidebar.vue'
import TopBar from '../components/TopBar.vue'
import Footer from '../components/Footer.vue'
export default {
    name: 'App',
    components: { Sidebar, TopBar, Footer }
}
</script>
