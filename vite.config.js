import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    server: {
        host: 'localhost',
        port: 5173,
        proxy: {
            '/api': 'http://localhost:8000', // Laravel backend
        },
    },
});
