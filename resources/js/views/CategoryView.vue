<template>
    <section class="py-5">
        <div class="container">
            <h1 class="mb-3 text-3xl">{{ category.name }}</h1>
            <div class="grid grid-cols-[300px_1fr] items-start gap-3">
                <side-bar
                    @filter="onFilter"
                    :maxPrice="category.maxProductPrice"
                    :authorsOptions="category.authorsInCategory"
                />
                <category-cards
                    @page="onPage"
                    :products="products"
                    :limit="limit"
                    :totalRecords="totalRecords"
                />
            </div>
        </div>
    </section>
</template>

<script setup>
import SideBar from "@/components/categoryView/SideBar.vue";
import CategoryCards from "@/components/categoryView/CategoryProducts.vue";
import useApi from "@/composables/FetchApi.js";
import { ref, onMounted, watch } from "vue";
import { useRoute } from "vue-router";

const { fetchGet } = useApi();
const route = useRoute();
const products = ref([]);
const category = ref({});

const page = ref(1);
const limit = ref(16);
const totalRecords = ref(0);
const filterData = ref({});

const handleGetCategory = async () => {
    const response = await fetchGet(`/api/category/${route.params.category}`);

    if (response) {
        category.value = response;
        await handleGetProducts();
    }
};

const handleGetProducts = async () => {
    const response = await fetchGet("/api/products", prepareParams());

    if (response) {
        products.value = response.data;
        totalRecords.value = response.rows_count;
    }
};

const prepareParams = () => {
    const filters = [
        {
            field: "category_id",
            operator: "equal",
            value: category.value.id,
        },
    ];
    if (Object.keys(filterData.value).length) {
        if (Array.isArray(filterData.value.rangePrice)) {
            filters.push({
                field: "price",
                operator: "increase",
                value: filterData.value.rangePrice[0],
            });
            filters.push({
                field: "price",
                operator: "decrease",
                value: filterData.value.rangePrice[1],
            });
        }
        if (filterData.value.author) {
            filters.push({
                field: "author_id",
                operator: "equal",
                value: filterData.value.author.id,
            });
        }
    }

    return {
        page: page.value,
        limit: limit.value,
        filters,
    };
};

const onPage = (data) => {
    page.value = data.page + 1;
    limit.value = data.rows;
    handleGetProducts();
};

const onFilter = (data) => {
    filterData.value = data;
    handleGetProducts();
};

watch(
    () => route.params.category,
    () => {
        handleGetCategory();
    },
);

onMounted(() => {
    handleGetCategory();
});
</script>
