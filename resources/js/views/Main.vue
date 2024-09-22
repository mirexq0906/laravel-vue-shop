<template>
    <banners-section />
    <popular-products-section />
    <!-- <recommend-products-section /> -->
</template>

<script>
import BannersSection from "@/components/main/bannersSection/Index.vue";
import PopularProductsSection from "@/components/main/PopularProductsSection.vue";
import RecommendProductsSection from "@/components/main/RecommendProductsSection.vue";
export default {
    components: {
        BannersSection,
        PopularProductsSection,
        RecommendProductsSection,
    },
};
</script>
