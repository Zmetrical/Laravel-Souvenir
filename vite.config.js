import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import path from 'path'; 

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/admin-shapes.js', 
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    resolve: {                                  
        alias: {
            '@shapes': path.resolve(__dirname, 'public/js/builder/canvas/shapes'),
        },
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});