import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            component: () => import("../views/Main.vue"),
        },
        {
            path: "/:category",
            component: () => import("../views/CategoryView.vue"),
        },
        {
            path: "/:category/:product",
            component: () => import("../views/ProductView.vue"),
        },
        {
            path: "/favorite",
            component: () => import("../views/FavoriteView.vue"),
        },
        {
            path: "/basket",
            component: () => import("../views/BasketView.vue"),
        },
        {
            path: "/profile",
            component: () => import("../views/ProfileView.vue"),
        },
    ],
});

export default router;
