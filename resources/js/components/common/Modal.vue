<template>
    <Dialog
        class="modal relative m-3 w-full"
        :style="{ maxWidth: `${maxWidth}px` }"
        v-model:visible="visible"
        :draggable="false"
        :closable="false"
        modal
    >
        <template #header>
            <slot name="header">
                <div class="flex w-full items-center justify-between">
                    <div class="text-2xl">
                        {{ header }}
                    </div>
                    <Button
                        id="modal-close"
                        @click="closeModal"
                        icon="pi pi-times"
                        rounded
                    />
                </div>
            </slot>
        </template>
        <slot name="content" />
        <template #footer>
            <slot name="footer" />
        </template>

        <div class="mt-2 text-red-600" v-if="isError">{{ errorMessage }}</div>
        <div class="modal__loader" v-if="loading">
            <loader />
        </div>
    </Dialog>
</template>

<script setup>
import Dialog from "primevue/dialog";
import Loader from "./Loader.vue";
import Button from "primevue/button";
import { ref, watch } from "vue";

const props = defineProps({
    header: {
        type: String,
        default: "",
    },
    loading: {
        type: Boolean,
        default: false,
    },
    isError: {
        type: Boolean,
        default: false,
    },
    errorMessage: {
        type: String,
        default: "",
    },
    modelValue: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: [Number, String],
        default: 1000,
    },
});
const emits = defineEmits(["update:modelValue"]);

const visible = ref(false);

const closeModal = () => {
    emits("update:modelValue", false);
};

watch(
    () => props.modelValue,
    () => {
        visible.value = props.modelValue;
    },
);
watch(
    () => visible.value,
    () => {
        emits("update:modelValue", visible.value);
    },
);
</script>

<style lang="scss">
.modal {
    &__loader {
        position: absolute;
        left: 0;
        top: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 5;
        border-radius: 12px;
    }
}
</style>
