<template>
    <header class="z-10 bg-stone-200">
        <div class="container">
            <Menubar class="!border-none !bg-transparent" :model="items">
                <template #start>
                    <router-link to="/">
                        <a> SHOP </a>
                    </router-link>
                </template>
                <template #item="{ item, props, hasSubmenu }">
                    <router-link
                        v-if="item.route"
                        v-slot="{ href, navigate }"
                        :to="'/' + item.route"
                        custom
                    >
                        <a :href="href" v-bind="props.action" @click="navigate">
                            <span :class="item.icon" />
                            <span class="ml-2">{{ item.label }}</span>
                        </a>
                    </router-link>
                    <a
                        v-else
                        :href="item.url"
                        :target="item.target"
                        v-bind="props.action"
                    >
                        <span :class="item.icon" />
                        <span class="ml-2">{{ item.label }}</span>
                        <span
                            v-if="hasSubmenu"
                            class="pi pi-fw pi-angle-down ml-2"
                        />
                    </a>
                </template>
                <template #end>
                    <div class="flex items-center gap-2">
                        <InputText placeholder="Поиск" type="text" />
                        <Button
                            v-if="!store.state.isAuth"
                            @click="openAuthModal"
                            label="Войти"
                            icon="pi pi-user"
                        />
                        <template v-else>
                            <Button
                                as="router-link"
                                to="/profile"
                                label="Профиль"
                                icon="pi pi-user"
                            />
                            <Button
                                @click="logout"
                                severity="danger"
                                label="Выйти"
                                icon="pi pi-times"
                            />
                        </template>

                        <Button
                            as="router-link"
                            to="/favorite"
                            label="Избранное"
                            icon="pi pi-heart"
                            :badge="String(countFavoriteProducts)"
                        />
                        <Button
                            as="router-link"
                            to="/basket"
                            label="Корзина"
                            icon="pi pi-cart-arrow-down"
                            :badge="String(countBasketProducts)"
                        />
                    </div>
                </template>
            </Menubar>
            <auth-modal ref="authModal" />
        </div>
    </header>
</template>

<script setup>
import Menubar from "primevue/menubar";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import AuthModal from "./AuthModal.vue";
import { ref, onMounted } from "vue";
import useApi from "@/composables/FetchApi.js";
import { useStore } from "vuex";
import { computed } from "vue";
import { useRouter } from "vue-router";
import { useToast } from "primevue/usetoast";

const store = useStore();
const router = useRouter();
const toast = useToast();
const { fetchGet } = useApi();
const items = ref([
    {
        label: "Категории",
        icon: "pi pi-search",
        items: [],
    },
]);
const authModal = ref(null);
const countFavoriteProducts = computed(
    () => store.getters.getCountFavoriteProducts,
);
const countBasketProducts = computed(
    () => store.getters.getCountBasketProducts,
);

const logout = () => {
    store.dispatch("handleGetOrRemoveAuthData");
    toast.add({
        severity: "success",
        summary: "Успех!",
        detail: "Вы вышли из системы",
        life: 3000,
    });
    router.push("/");
};

const handleGetCategories = async () => {
    const response = await fetchGet("/api/categories");

    if (response) {
        const categoryItem = items.value.find(
            (item) => item.label === "Категории",
        );
        if (categoryItem) {
            categoryItem.items = response.data.map((category) => ({
                label: category.name,
                route: category.slug,
            }));
        }
    }
};

const openAuthModal = () => {
    authModal.value.open();
};

onMounted(() => {
    handleGetCategories();
});
</script>

<style></style>
