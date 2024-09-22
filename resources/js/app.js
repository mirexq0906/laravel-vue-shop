import "./bootstrap";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/free-mode";
import "swiper/css/thumbs";
import { createApp } from "vue/dist/vue.esm-bundler.js";
import PrimeVue from "primevue/config";
import Nora from "@primevue/themes/aura";
import App from "./App.vue";
import "primeicons/primeicons.css";
import router from "./router";
import store from "./store/index";
import ToastService from "primevue/toastservice";

import "../css/app.css";
const app = createApp(App);
app.use(store);
app.use(PrimeVue, {
    theme: {
        preset: Nora,
    },
    options: {
        cssLayer: {
            name: "primevue",
            order: "tailwind-base, primevue, tailwind-utilities",
        },
    },
});

app.use(ToastService);
app.use(router);

app.mount("#app");
