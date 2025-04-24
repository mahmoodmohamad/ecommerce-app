<template>
    <div class="min-h-screen bg-gray-100">
        <Navbar />
        <router-view />
    </div>
</template>

<script setup>
import Navbar from './Components/Navbar.vue';
</script>
