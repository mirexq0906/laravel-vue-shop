<template>
    <div class="max-w-[500px]">
        <h3 class="mb-1 text-xl">Данные покупателя</h3>
        <div>
            <field-text
                @input="setPhone"
                :modelValue="phone"
                fieldPlaceholder="+7(999)-999-99-99"
                fieldValue="phone"
                fieldType="text"
            />
            <field-text
                @input="setName"
                :modelValue="name"
                fieldPlaceholder="ФИО"
                fieldValue="name"
                fieldType="text"
            />
            <field-text
                @input="setEmail"
                :modelValue="email"
                fieldPlaceholder="Email"
                fieldValue="email"
                fieldType="text"
            />
        </div>
    </div>
</template>

<script setup>
import FieldText from "@/components/common/form/FieldText.vue";

const props = defineProps({
    phone: {
        type: String,
        default: "",
    },
    name: {
        type: String,
        default: "",
    },
    email: {
        type: String,
        default: "",
    },
});
const emits = defineEmits(["update:phone", "update:name", "update:email"]);

const setPhone = (e) => {
    emits("update:phone", e.target.value);
};

const setName = (e) => {
    emits("update:name", e.target.value);
};

const setEmail = (e) => {
    emits("update:email", e.target.value);
};
</script>
