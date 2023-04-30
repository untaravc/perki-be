<template>
    <div>
        <TopBar></TopBar>
        <SideBar></SideBar>
        <router-view></router-view>
    </div>
</template>

<script>
import TopBar from '../components/Topbar.vue'
import SideBar from '../components/Sidebar.vue'

export default {
    components: {TopBar, SideBar}
}
</script>
