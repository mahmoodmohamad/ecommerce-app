import { createRouter, createWebHistory } from 'vue-router';
import Home from '../Pages/Home.vue';
import ProductList from '../Pages/ProductList.vue';

const routes = [
    { path: '/', name: 'home', component: Home },
    { path: '/products', name: 'products', component: ProductList },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
