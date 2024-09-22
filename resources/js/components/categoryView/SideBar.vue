<template>
    <div class="rounded-md bg-slate-200 p-2">
        <div class="mb-3">
            <h3 class="mb-1">Цена</h3>
            <div
                class="mb-3 grid grid-cols-[1fr_20px_1fr] items-center justify-items-center"
            >
                <InputText
                    class="w-full"
                    @input="onFilter"
                    type="number"
                    v-model="rangePrice[0]"
                />
                <span>-</span>
                <InputText
                    class="w-full"
                    @input="onFilter"
                    type="number"
                    v-model="rangePrice[1]"
                />
            </div>
            <div class="px-2">
                <Slider
                    class="w-full"
                    v-model="rangePrice"
                    @slideend="onFilter"
                    :max="props.maxPrice"
                    range
                />
            </div>
        </div>
        <div>
            <h3 class="mb-1">Автор</h3>
            <Dropdown
                class="w-full"
                v-model="author"
                @change="onFilter"
                showClear
                :options="localAuthorsOptions"
                optionLabel="name"
                placeholder="Выберите автора"
            />
        </div>
    </div>
</template>

<script setup>
import InputText from "primevue/inputtext";
import { ref, watch } from "vue";
import Slider from "primevue/slider";
import Dropdown from "primevue/dropdown";

const emits = defineEmits("filter");
const props = defineProps({
    maxPrice: {
        type: Number,
        default: 0,
    },
    authorsOptions: {
        type: Array,
        default: () => [],
    },
});
const rangePrice = ref([0, props.maxPrice]);
const localAuthorsOptions = ref([]);
const author = ref(null);

watch(
    () => props.maxPrice,
    (newValue) => {
        rangePrice.value = [0, newValue];
    },
);

watch(
    () => props.authorsOptions,
    (newValue) => {
        localAuthorsOptions.value = newValue;
    },
);

const onFilter = () => {
    emits("filter", {
        rangePrice: rangePrice.value,
        author: author.value,
    });
};
</script>

<style></style>
