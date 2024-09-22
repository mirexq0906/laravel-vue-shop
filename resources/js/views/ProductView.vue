<template>
    <section class="py-5">
        <div class="container">
            <div class="grid grid-cols-2 gap-3">
                <gallery
                    :gallery="product.gallery"
                    :mainImage="product.image"
                />
                <div>
                    <h1 class="text-4xl font-medium">{{ product.name }}</h1>
                    <div class="flex gap-3">
                        <span class="text-2xl"> {{ product.price }} руб. </span>
                        <span class="text-2xl line-through">
                            {{ product.oldPrice }} руб.
                        </span>
                    </div>
                </div>
            </div>
            <div>
                {{ product.description }}
            </div>
        </div>
    </section>
</template>

<script setup>
import Gallery from "@/components/productView/Gallery.vue";
import useApi from "@/composables/FetchApi.js";
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

const { fetchGet } = useApi();
const product = ref({});
const route = useRoute();
const handleGetProduct = async () => {
    const response = await fetchGet(`/api/product/${route.params.product}`);

    if (response) {
        product.value = response;
    }
};

onMounted(() => {
    handleGetProduct();
});
</script>
