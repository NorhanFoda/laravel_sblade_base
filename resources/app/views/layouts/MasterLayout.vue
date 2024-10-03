<script setup>
import TopBar from "@views/layouts/partials/TopBar.vue";
import SideBar from "@views/layouts/partials/SideBar.vue";
import FooterBar from "@views/layouts/partials/FooterBar.vue";
</script>

<template>
    <!-- start main header -->
    <top-bar/>
    <!-- end main header -->
    <!-- start horizontal menu -->
    <side-bar/>
    <!-- end horizontal menu -->
    <!-- start main content -->
    <router-view :key="$route.fullPath"></router-view>
    <!-- end main content -->
    <!-- start footer -->
    <footer-bar/>
    <!-- end footer -->
</template>
