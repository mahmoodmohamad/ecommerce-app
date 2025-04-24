<template>
    <div class="border rounded shadow-sm p-4 hover:shadow-md transition">
        <img :src="product.image_url" alt="product image" class="w-full h-48 object-cover" />
        <h2 class="text-lg font-semibold mt-2">{{ product.name }}</h2>
        <p class="text-gray-500">{{ product.price }} EGP</p>
        <router-link :to="'/products/' + product.id" class="text-blue-500">View Details</router-link>
    </div>
</template>

<script setup>
defineProps(['product']);
</script>
