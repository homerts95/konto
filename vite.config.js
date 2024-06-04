import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    build: {
        // Enable rollup for building (default in Vite)
        rollupOptions: {
            output: {
                // Enable provided exports for tree-shaking
                exports: 'named',
            },
        },
        define: {
            // Define the flag with a value of false
            __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: true,
        },
    },
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),

    ],
});
