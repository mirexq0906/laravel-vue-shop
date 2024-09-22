<template>
    <div class="container pt-5">
        <h1 class="mb-3 text-3xl">Корзина</h1>
    </div>
    <template v-if="countBasketProducts">
        <basket-products
            :products="basketProducts"
            @setCount="setProductCount"
        />
        <basket-form
            :products="basketProducts"
            :countInEveryProduct="countInEveryProduct"
        />
    </template>
    <div class="text-center text-2xl" v-else>Список товаров пуст</div>
</template>

<script setup>
import BasketProducts from "@/components/basketView/BasketProducts.vue";
import BasketForm from "@/components/basketView/BasketForm/Index.vue";
import { useStore } from "vuex";
import { computed, watch, ref } from "vue";

const store = useStore();

const basketProducts = computed(() => {
    return store.state.basketProducts;
});

const countInEveryProduct = ref({});

const countBasketProducts = computed(
    () => store.getters.getCountBasketProducts,
);

const setProductCount = ({ productId, count }) => {
    countInEveryProduct.value[productId] = count;
};

watch(
    () => basketProducts,
    () => {
        let data = {};
        for (var key in basketProducts.value) {
            if (!countInEveryProduct.value[key]) {
                data[key] = 1;
            } else {
                data[key] = countInEveryProduct.value[key]; // Сохраняем предыдущее количество
            }
        }
        countInEveryProduct.value = data;
    },
    { immediate: true, deep: true },
);
</script>
