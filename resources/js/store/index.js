import { createStore } from "vuex";
import config from "../config.json";
import axios from "axios";

const store = createStore({
    state() {
        return {
            config,
            isAuth: false,
            userData: {},
            basketProducts: {},
            favoriteProducts: {},
        };
    },
    mutations: {
        setBasketProducts(state, data) {
            if (Array.isArray(data)) {
                data.forEach((element) => {
                    state.basketProducts[element.id] = element;
                });
            } else {
                state.basketProducts[data.id] = data;
            }
        },
        removeBasketProducts(state, id) {
            delete state.basketProducts[id];
        },
        allRemoveBasketProducts(state) {
            state.basketProducts = {};
        },
        setFavoriteProducts(state, data) {
            if (Array.isArray(data)) {
                data.forEach((element) => {
                    state.favoriteProducts[element.id] = element;
                });
            } else {
                state.favoriteProducts[data.id] = data;
            }
        },
        removeFavoriteProducts(state, id) {
            delete state.favoriteProducts[id];
        },
        allRemoveFavoriteProducts(state) {
            state.favoriteProducts = {};
        },
    },
    getters: {
        getCountBasketProducts(state) {
            return Object.keys(state.basketProducts)?.length ?? 0;
        },
        getCountFavoriteProducts(state) {
            return Object.keys(state.favoriteProducts)?.length ?? 0;
        },
        getBasketProducts(state) {
            return Object.values(state.basketProducts) ?? [];
        },
        getFavoriteProducts(state) {
            return Object.values(state.favoriteProducts) ?? [];
        },
    },
    actions: {
        async handleGetOrRemoveAuthData({ commit, state }, data = null) {
            if (data !== null) {
                state.userData = data;
                state.isAuth = true;
                try {
                    const favorites = await axios.get("/api/favorites", {
                        headers: {
                            Authorization:
                                "Bearer " + localStorage.getItem("token"),
                        },
                    });
                    const baskets = await axios.get("/api/baskets", {
                        headers: {
                            Authorization:
                                "Bearer " + localStorage.getItem("token"),
                        },
                    });
                    commit("setFavoriteProducts", favorites.data);
                    commit("setBasketProducts", baskets.data);
                } catch (e) {
                    console.log(e);
                }
            } else {
                state.isAuth = false;
                commit("allRemoveBasketProducts");
                commit("allRemoveFavoriteProducts");
                localStorage.removeItem("token");
            }
        },
    },
});

export default store;
