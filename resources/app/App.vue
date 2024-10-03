<template>
    <router-view></router-view>
</template>

<script setup>
import {useI18n} from "vue-i18n";
import {onMounted} from "vue";

const i18n = useI18n();

onMounted(async () => {
    i18n.locale.value = localStorage.getItem("locale") || "en";
});
</script>

<style scoped>

</style>
