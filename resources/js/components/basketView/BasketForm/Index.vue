<template>
    <section class="py-5">
        <div class="container">
            <Divider />
            <buyer-details
                v-model:phone="data.phone"
                v-model:name="data.name"
                v-model:email="data.email"
            />
            <Divider />
            <payment v-model:payment="data.payment" />
            <Divider />
            <delivery v-model:delivery="data.delivery" />
            <Divider />
            <div class="text-3xl font-medium">Итого: {{ total }} руб.</div>

            <Button
                class="mt-2"
                @click="handleCreateOrder"
                label="Оформить заказ"
            />
        </div>
    </section>
</template>

<script setup>
import BuyerDetails from "./BuyerDetails.vue";
import Payment from "./Payment.vue";
import Delivery from "./Delivery.vue";
import Divider from "primevue/divider";
import { ref, computed } from "vue";
import Button from "primevue/button";
import useApi from "@/composables/FetchApi.js";
import { useToast } from "primevue/usetoast";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const props = defineProps({
    countInEveryProduct: {
        type: Object,
        default: () => {},
    },
    products: {
        type: Object,
        default: () => {},
    },
});

const toast = useToast();
const { fetchPost } = useApi();
const store = useStore();
const router = useRouter();
const data = ref({
    phone: "",
    name: "",
    email: "",
    payment: "Картой или наличными при получении",
    delivery: "Доставка в пункт выдачи",
    address: "",
});

const total = computed(() => {
    let total = 0;
    for (let key in props.countInEveryProduct) {
        if (props.products.hasOwnProperty(key)) {
            total += props.products[key].price * props.countInEveryProduct[key];
        }
    }
    return total;
});

const handleCreateOrder = async () => {
    const response = await fetchPost("/api/order", {
        phone: data.value.phone,
        name: data.value.name,
        email: data.value.email,
        payment: data.value.payment,
        delivery: data.value.delivery,
        products: props.countInEveryProduct,
    });
    if (response) {
        toast.add({
            severity: "success",
            summary: "Успех!",
            detail: "Заказ оформлен",
            life: 3000,
        });
        store.commit("allRemoveBasketProducts");
        router.push("/");
    }
};
</script>
