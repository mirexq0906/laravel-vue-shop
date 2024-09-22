<template>
    <Card :style="{ 'max-width': maxWidth }" @click="navigate">
        <template #header>
            <img
                alt="image"
                :src="$store.state.config.IMAGE_PATH + product.image"
            />
        </template>
        <template #title>
            {{ product.name }}
        </template>
        <template #content>
            <div class="mb-2">
                <span> {{ product.price }} руб. </span>
                <span class="line-through"> {{ product.oldPrice }} руб. </span>
            </div>
            <InputNumber
                v-if="isCount"
                @input="setCount"
                @click.stop
                v-model="count"
                showButtons
                buttonLayout="horizontal"
                :step="1"
                fluid
                :min="1"
                :max="99"
            >
                <template #incrementbuttonicon>
                    <span class="pi pi-plus" />
                </template>
                <template #decrementbuttonicon>
                    <span class="pi pi-minus" />
                </template>
            </InputNumber>
        </template>
        <template #footer>
            <div class="mt-1 flex justify-between gap-4">
                <Button
                    @click.stop="handleBasket"
                    icon="pi pi-cart-arrow-down"
                    :label="isBasket ? 'В корзине' : 'В корзину'"
                    :outlined="isBasket"
                />
                <Button
                    @click.stop="handleFavorite"
                    :icon="`pi ${isFavorite ? 'pi-heart-fill' : 'pi-heart'}`"
                    outlined
                    severity="secondary"
                />
            </div>
        </template>
    </Card>
</template>

<script setup>
import Card from "primevue/card";
import Button from "primevue/button";
import { useRouter } from "vue-router";
import useApi from "@/composables/FetchApi.js";
import { useToast } from "primevue/usetoast";
import { ref, computed, onMounted } from "vue";
import { useStore } from "vuex";
import InputNumber from "primevue/inputnumber";

const toast = useToast();
const router = useRouter();
const store = useStore();
const props = defineProps({
    product: {
        type: Object,
        default: () => {},
    },
    isCount: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: "300px",
    },
});
const emits = defineEmits(["click-count"]);
const { fetchPost } = useApi();
const isFavorite = ref(false);
const isBasket = ref(false);
const favoriteProducts = computed(() => store.state.favoriteProducts);
const basketProducts = computed(() => store.state.basketProducts);
const count = ref(1);

const navigate = () => {
    if (props?.product?.slug?.length) {
        router.push(`/${props?.product?.categorySlug}/${props?.product?.slug}`);
    }
};

const handleFavorite = async () => {
    const response = await fetchPost("/api/favorites", {
        product_id: props.product?.id,
    });
    if (typeof response == "object" && Object.keys(response) == 0) {
        store.commit("removeFavoriteProducts", props.product.id);
        showToast("Товар удален из избранного");
        isFavorite.value = false;
    } else if (response) {
        store.commit("setFavoriteProducts", props.product);
        showToast("Товар добавлен в избранное");
        isFavorite.value = true;
    }
};

const handleBasket = async () => {
    const response = await fetchPost("/api/baskets", {
        product_id: props.product?.id,
    });
    if (typeof response == "object" && Object.keys(response) == 0) {
        store.commit("removeBasketProducts", props.product.id);
        showToast("Товар удален из корзины");
        isBasket.value = false;
    } else if (response) {
        store.commit("setBasketProducts", props.product);
        showToast("Товар добавлен в корзину");
        isBasket.value = true;
    }
};

const showToast = (message) => {
    toast.add({
        severity: "success",
        summary: "Успех!",
        detail: message,
        life: 3000,
    });
};

const checkFavoriteProducts = () => {
    if (favoriteProducts.value.hasOwnProperty(props.product.id)) {
        isFavorite.value = true;
    }
};

const checkBasketProducts = () => {
    if (basketProducts.value.hasOwnProperty(props.product.id)) {
        isBasket.value = true;
    }
};

const setCount = () => {
    emits("click-count", { productId: props.product.id, count: count.value });
};

onMounted(() => {
    checkFavoriteProducts();
    checkBasketProducts();
});
</script>
