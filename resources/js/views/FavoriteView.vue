<template>
    <section class="py-5">
        <div class="container">
            <h1 class="mb-3 text-3xl">Избранные товары</h1>
            <div class="grid grid-cols-5 gap-3" v-if="favoriteProducts.length">
                <card
                    v-for="item in favoriteProducts"
                    :key="item.id"
                    :product="item"
                />
            </div>
            <div class="text-center text-2xl" v-else>Список товаров пуст</div>
        </div>
    </section>
</template>

<script setup>
import { useStore } from "vuex";
import { computed } from "vue";
import Card from "@/components/common/Card.vue";

const store = useStore();

const favoriteProducts = computed(() => store.getters.getFavoriteProducts);
</script>

<style></style>
