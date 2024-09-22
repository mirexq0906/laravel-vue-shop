<template>
    <div class="flex flex-col gap-2">
        <label :for="props.fieldValue">{{ props.fieldName }}</label>
        <InputText
            :id="props.fieldValue"
            :value="props.modelValue"
            @input="setField"
            :type="props.fieldType"
            :placeholder="props.fieldPlaceholder ?? props.fieldName"
        />
        <!-- <small> 123 </small> -->
    </div>
</template>

<script setup>
import InputText from "primevue/inputtext";

const props = defineProps({
    fieldName: {
        type: String,
        default: "",
    },
    fieldValue: {
        type: String,
        required: true,
    },
    fieldPlaceholder: {
        type: String,
        default: null,
    },
    fieldType: {
        type: String,
        default: "text",
    },
    modelValue: {
        type: [String, Number],
    },
});

const emits = defineEmits(["update:modelValue"]);

const setField = (e) => {
    emits("update:modelValue", e.target.value);
};
</script>
