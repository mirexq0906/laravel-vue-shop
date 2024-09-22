<template>
    <section class="py-5">
        <div class="container">
            <h2 class="mb-3 text-3xl">Рекомендуемые товары</h2>
            <silder :items="items" classSlideItem="max-w-[300px]">
                <template #item>
                    <card />
                </template>
            </silder>
        </div>
    </section>
</template>
<script>
import Silder from "../common/Silder.vue";
import Card from "@/components/common/Card.vue";
export default {
    components: { Silder, Card },
    data() {
        return {
            items: [
                { id: 1 },
                { id: 2 },
                { id: 3 },
                { id: 4 },
                { id: 5 },
                { id: 6 },
            ],
        };
    },
};
</script>
