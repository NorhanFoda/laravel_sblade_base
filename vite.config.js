import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin'
import inject from '@rollup/plugin-inject';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js',
                'resources/css/app.css'],
            refresh: true,
        }),
        inject({
            $: 'jquery',
            jQuery: 'jquery'
        })
    ],
    publicDir: 'UI/assets/v1',
});
