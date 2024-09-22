<template>
    <div>
        <h3 class="mb-1 text-xl">Выберите способ оплаты</h3>
        <div class="flex flex-col gap-1">
            <div class="flex items-center">
                <RadioButton
                    @change="setPayment"
                    :modelValue="payment"
                    inputId="payment1"
                    name="payment"
                    value="Картой или наличными при получении"
                />
                <label for="payment1" class="ml-2"
                    >Картой или наличными при получении</label
                >
            </div>
            <div class="flex items-center">
                <RadioButton
                    @change="setPayment"
                    :modelValue="payment"
                    inputId="payment2"
                    name="payment"
                    value="Оплата онлайн"
                />
                <label for="payment2" class="ml-2">Оплата онлайн</label>
            </div>
            <div class="flex items-center">
                <RadioButton
                    @change="setPayment"
                    :modelValue="payment"
                    inputId="payment3"
                    name="payment"
                    value="В рассрочку"
                />
                <label for="payment3" class="ml-2">В рассрочку</label>
            </div>
        </div>
    </div>
</template>

<script setup>
import RadioButton from "primevue/radiobutton";
import { ref } from "vue";

const props = defineProps({
    payment: {
        type: String,
        default: "",
    },
});
const emits = defineEmits(["update:payment"]);

const setPayment = (e) => {
    emits("update:payment", e.target.value);
};
</script>
