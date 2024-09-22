<template>
    <section class="py-5">
        <div class="container">
            <div class="grid grid-cols-4 gap-5">
                <div class="col-span-3">
                    <banner />
                </div>
                <div>
                    <week-products />
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import Banner from "./Banner.vue";
import WeekProducts from "./WeekProducts.vue";
export default {
    components: {
        Banner,
        WeekProducts,
    },
};
</script>

<style></style>
