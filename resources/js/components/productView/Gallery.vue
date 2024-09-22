<template>
    <div class="grid h-[500px] grid-cols-5 gap-2">
        <swiper
            class="col-span-4 w-full"
            :loop="true"
            :spaceBetween="10"
            :thumbs="{ swiper: thumbsSwiper }"
            :modules="[FreeMode, Navigation, Thumbs]"
            :navigation="{
                nextEl: '#gallery-next',
                prevEl: '#gallery-prev',
            }"
        >
            <swiper-slide>
                <img
                    class="h-full w-full object-cover"
                    :src="$store.state.config.IMAGE_PATH + mainImage"
                />
            </swiper-slide>
            <swiper-slide v-for="(image, index) in gallery" :key="index">
                <img
                    class="h-full w-full object-cover"
                    :src="$store.state.config.IMAGE_PATH + image"
                />
            </swiper-slide>
            <Button
                id="gallery-next"
                class="!absolute left-1 top-1/2 z-10 -translate-y-1/2 !bg-white"
                icon="pi pi-angle-left"
                severity="secondary"
                rounded
                outlined
            />
            <Button
                id="gallery-prev"
                class="!absolute right-1 top-1/2 z-10 -translate-y-1/2 !bg-white"
                icon="pi pi-angle-right"
                severity="secondary"
                rounded
                outlined
            />
        </swiper>
        <swiper
            class="h-full w-full"
            @swiper="setThumbsSwiper"
            :loop="true"
            :spaceBetween="10"
            :slidesPerView="4"
            :freeMode="true"
            :watchSlidesProgress="true"
            direction="vertical"
            :modules="[FreeMode, Navigation, Thumbs]"
        >
            <swiper-slide>
                <img
                    class="h-full w-full object-cover"
                    :src="$store.state.config.IMAGE_PATH + mainImage"
                />
            </swiper-slide>
            <swiper-slide v-for="(image, index) in gallery" :key="index">
                <img
                    class="h-full w-full object-cover"
                    :src="$store.state.config.IMAGE_PATH + image"
                />
            </swiper-slide>
        </swiper>
    </div>
</template>
<script setup>
import { ref } from "vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { FreeMode, Navigation, Thumbs } from "swiper/modules";
import Button from "primevue/button";

const props = defineProps({
    gallery: {
        type: Array,
        default: () => [],
    },
    mainImage: {
        type: String,
        default: "",
    },
});
const thumbsSwiper = ref(null);
const setThumbsSwiper = (swiper) => {
    thumbsSwiper.value = swiper;
};
</script>
