import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'
import i18n from 'laravel-vue-i18n/vite';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        i18n({
            // you can also change your langPath here
            // langPath: 'locales'
            additionalLangPaths: [
                //'public/locales' // Load translations from this path too!
            ]
        }),
    ],
});
