<template>
    <div>
        <h3 class="mb-1 text-xl">Выберите способ получения</h3>
        <div class="flex flex-col gap-1">
            <div class="flex items-center">
                <RadioButton
                    @change="setDelivery"
                    :modelValue="delivery"
                    inputId="delivery1"
                    name="delivery"
                    value="Доставка в пункт выдачи"
                />
                <label for="delivery1" class="ml-2">
                    Доставка в пункт выдачи
                </label>
            </div>
            <div class="flex items-center">
                <RadioButton
                    @change="setDelivery"
                    :modelValue="delivery"
                    inputId="delivery2"
                    name="delivery"
                    value="Доставка курьером"
                />
                <label for="delivery2" class="ml-2"> Доставка курьером </label>
            </div>
        </div>
    </div>
</template>

<script setup>
import RadioButton from "primevue/radiobutton";
import { ref } from "vue";

const props = defineProps({
    delivery: {
        type: String,
        default: "",
    },
});
const emits = defineEmits(["update:delivery"]);

const setDelivery = (e) => {
    emits("update:delivery", e.target.value);
};
</script>
