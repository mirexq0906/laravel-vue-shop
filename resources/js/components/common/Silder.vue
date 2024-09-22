<template>
    <div class="relative -m-2">
        <swiper
            class="p-2"
            :modules="[Navigation]"
            slides-per-view="auto"
            :space-between="20"
            :navigation="{
                nextEl: '#' + nextButtonId,
                prevEl: '#' + prevButtonId,
            }"
        >
            <swiper-slide
                v-for="(item, index) in items"
                :key="item.id ?? index"
                :class="classSlideItem"
            >
                <slot name="item" :item="item"></slot>
            </swiper-slide>
        </swiper>

        <Button
            :id="prevButtonId"
            class="!absolute left-1 top-1/2 z-10 -translate-y-1/2 !bg-white"
            icon="pi pi-angle-left"
            severity="secondary"
            rounded
            outlined
        />
        <Button
            :id="nextButtonId"
            class="!absolute right-1 top-1/2 z-10 -translate-y-1/2 !bg-white"
            icon="pi pi-angle-right"
            severity="secondary"
            rounded
            outlined
        />
    </div>
</template>
<script>
import { Navigation } from "swiper/modules";
import { Swiper, SwiperSlide } from "swiper/vue";
import Button from "primevue/button";
export default {
    props: {
        items: {
            type: Array,
            default: () => [],
        },
        classSlideItem: {
            type: String,
            default: "",
        },
    },
    components: {
        Swiper,
        SwiperSlide,
        Button,
    },
    data() {
        return {
            prevButtonId: "slider-button-prev-" + this.getRandomId(),
            nextButtonId: "slider-button-next-" + this.getRandomId(),
        };
    },
    methods: {
        getRandomId() {
            return Math.random().toString(36).substr(2, 9);
        },
    },
    setup() {
        return {
            Navigation,
        };
    },
};
</script>
<style lang="scss"></style>
