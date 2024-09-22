<template>
    <modal
        v-model="visible"
        :loading="isLoader"
        :header="isRegisterMode ? 'Регистрация пользователя' : 'Вход в систему'"
        maxWidth="500"
    >
        <template #content>
            <div class="flex flex-col gap-2">
                <field-text
                    v-if="isRegisterMode"
                    v-model="data.name"
                    fieldName="Наименование"
                    fieldValue="name"
                />
                <field-text
                    v-model="data.email"
                    fieldName="Email"
                    fieldValue="email"
                />
                <field-text
                    v-model="data.password"
                    fieldName="Пароль"
                    fieldValue="password"
                    fieldType="password"
                />
                <field-text
                    v-if="isRegisterMode"
                    v-model="data.passwordConfirmation"
                    fieldName="Поддтверждение пароля"
                    fieldValue="passwordConfirmation"
                    fieldType="password"
                />
            </div>
            <div
                @click="changeMode"
                class="mt-2 cursor-pointer select-none underline"
                v-text="
                    isRegisterMode
                        ? 'Есть аккаунт ? Войдите'
                        : 'Нет аккаунта ? Зарегистрируйтесь'
                "
            ></div>
        </template>
        <template #footer>
            <Button
                @click="closeModal"
                icon="pi pi-times"
                severity="danger"
                label="Отменить"
                outlined
            />
            <Button
                v-if="isRegisterMode"
                @click="handleRegister"
                icon="pi pi-check"
                label="Зарегистрировать"
                outlined
            />
            <Button
                v-else
                @click="handleLogin"
                icon="pi pi-check"
                label="Войти"
                outlined
            />
        </template>
    </modal>
</template>

<script setup>
import { ref } from "vue";
import FieldText from "@/components/common/form/FieldText.vue";
import Modal from "@/components/common/Modal.vue";
import Button from "primevue/button";
import useApi from "@/composables/FetchApi.js";
import { useToast } from "primevue/usetoast";
import { useStore } from "vuex";

defineExpose({
    open() {
        visible.value = true;
    },
});

const store = useStore();
const toast = useToast();
const { fetchPost } = useApi();
const visible = ref(false);
const isRegisterMode = ref(false);
const data = ref({
    name: "",
    email: "",
    password: "",
    passwordConfirmation: "",
});
const isLoader = ref(false);

const handleRegister = async () => {
    isLoader.value = true;
    const response = await fetchPost("/api/register", {
        name: data.value.name,
        email: data.value.email,
        password: data.value.password,
        password_confirmation: data.value.passwordConfirmation,
    });
    if (response) {
        isRegisterMode.value = false;
        toast.add({
            severity: "success",
            summary: "Успех!",
            detail: "Вы зарегистрировались",
            life: 3000,
        });
    }
    isLoader.value = false;
};

const handleLogin = async () => {
    isLoader.value = true;
    const response = await fetchPost("/api/login", {
        email: data.value.email,
        password: data.value.password,
    });
    if (response) {
        localStorage.setItem("token", response.token);
        store.dispatch("handleGetOrRemoveAuthData", response.data);
        visible.value = false;
        toast.add({
            severity: "success",
            summary: "Успех!",
            detail: "Вы вошли в систему",
            life: 3000,
        });
    }
    isLoader.value = false;
};

const changeMode = () => {
    isRegisterMode.value = !isRegisterMode.value;
};

const closeModal = () => {
    visible.value = false;
};
</script>
