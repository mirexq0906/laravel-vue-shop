<template>
    <div>
        <div v-if="products.length">
            <div class="mb-3 grid grid-cols-4 gap-3">
                <card
                    v-for="product in products"
                    :key="product.id"
                    :product="product"
                />
            </div>
            <Paginator
                @page="onPage"
                :rows="limit"
                :totalRecords="totalRecords"
            ></Paginator>
        </div>

        <div class="text-center text-2xl" v-else>Список товаров пуст</div>
    </div>
</template>

<script setup>
import Card from "@/components/common/Card.vue";
import Paginator from "primevue/paginator";
import { ref } from "vue";

const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },
    limit: {
        type: Number,
        required: true,
    },
    totalRecords: {
        type: Number,
        required: true,
    },
});

const emits = defineEmits(["page"]);

const onPage = (data) => {
    emits("page", data);
};
</script>

<style></style>
