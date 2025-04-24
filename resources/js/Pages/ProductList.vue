<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">All Products</h1>

        <div v-if="loading" class="text-center">Loading...</div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <ProductCard
                v-for="product in products"
                :key="product.id"
                :product="product"
            />
        </div>

        <div class="mt-6 text-center" v-if="nextPageUrl">
            <button @click="loadMore" class="bg-blue-500 text-white px-4 py-2 rounded">
                Load More
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import ProductCard from '../Components/ProductCard.vue';

const products = ref([]);
const loading = ref(true);
const nextPageUrl = ref(null);

const fetchProducts = async (url = '/api/products') => {
    try {
        const res = await axios.get(url);
        products.value.push(...res.data.data);
        nextPageUrl.value = res.data.next_page_url;
    } catch (error) {
        console.error('Error loading products', error);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchProducts();
});

const loadMore = () => {
    if (nextPageUrl.value) {
        fetchProducts(nextPageUrl.value);
    }
};
</script>
