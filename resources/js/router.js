import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        component: () => import("./Pages/Home.vue"),
    },
    {
        path: "/search",
        component: () => import("./Pages/Search.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
