<template>
    <silder :items="products">
        <template #item="{ item }">
            <card maxWidth="auto" :product="item" />
        </template>
    </silder>
</template>

<script setup>
import Silder from "@/components/common/Silder.vue";
import useApi from "@/composables/FetchApi.js";
import Card from "@/components/common/Card.vue";
import { ref, onMounted } from "vue";

const { fetchGet } = useApi();

const products = ref([]);

const handleGetWeekProducts = async () => {
    const response = await fetchGet("/api/week-products", {
        limit: 10,
    });
    products.value = response.data;
};

onMounted(() => {
    handleGetWeekProducts();
});
</script>

<style></style>
