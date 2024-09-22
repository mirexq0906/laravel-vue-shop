<template>
    <section class="py-5">
        <div class="container">
            <h2 class="mb-3 text-3xl">Популярные товары</h2>
            <silder :items="products" classSlideItem="max-w-[300px]">
                <template #item="{ item }">
                    <card :product="item" />
                </template>
            </silder>
        </div>
    </section>
</template>
<script setup>
import Silder from "@/components/common/Silder.vue";
import useApi from "@/composables/FetchApi.js";
import Card from "@/components/common/Card.vue";
import { ref, onMounted } from "vue";

const { fetchGet } = useApi();

const products = ref([]);

const handleGetPopularProducts = async () => {
    const response = await fetchGet("/api/popular-products", {
        limit: 10,
    });
    products.value = response.data;
};

onMounted(() => {
    handleGetPopularProducts();
});
</script>
