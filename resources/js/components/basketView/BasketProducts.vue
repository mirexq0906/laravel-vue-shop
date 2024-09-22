<template>
    <section class="pt-5">
        <div class="container">
            <div class="grid grid-cols-5 gap-3">
                <card
                    v-for="item in products"
                    @clickCount="setCount"
                    :key="item.id"
                    :product="item"
                />
            </div>
        </div>
    </section>
</template>

<script setup>
import Card from "@/components/common/Card.vue";

const props = defineProps({
    products: {
        type: Object,
        default: () => {},
    },
});

const emits = defineEmits(["set-count"]);

const setCount = (data) => {
    emits("set-count", data);
};
</script>

<style></style>
