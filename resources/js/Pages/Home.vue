<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Featured Products</h1>

        <div v-if="loading" class="text-center">Loading...</div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <ProductCard
                v-for="product in products"
                :key="product.id"
                :product="product"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import ProductCard from '../Components/ProductCard.vue';

const products = ref([]);
const loading = ref(true);

onMounted(async () => {
    try {
        const res = await axios.get('/api/products/featured');
        products.value = res.data;
    } catch (error) {
        console.error('Failed to load featured products', error);
    } finally {
        loading.value = false;
    }
});
</script>
