<template>
    <header-vue />
    <main class="flex-grow">
        <router-view />
    </main>
    <footer-vue />
    <Toast />
</template>

<script setup>
import FooterVue from "@/components/layouts/Footer.vue";
import HeaderVue from "@/components/layouts/header/Index.vue";
import Toast from "primevue/toast";
import { onMounted } from "vue";
import useApi from "@/composables/FetchApi.js";
import { useStore } from "vuex";

const store = useStore();

const { fetchGet, fetchPost } = useApi();

const handleCheckUser = async () => {
    const response = await fetchPost("/api/check");
    if (response) {
        store.dispatch("handleGetOrRemoveAuthData", response);
    }
};

onMounted(async () => {
    await handleCheckUser();
});
</script>
<style lang="scss">
@import "../css/App.scss";
</style>
