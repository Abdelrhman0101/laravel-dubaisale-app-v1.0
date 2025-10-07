import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
<<<<<<< HEAD
            input: ['resources/css/app.css', 'resources/js/app.js'],
=======
            input: ['resources/css/app.css', 'resources/css/landing.css', 'resources/js/app.js'],
>>>>>>> fda813474de423ad737102c50b79531b2338a0a7
            refresh: true,
        }),
        tailwindcss(),
    ],
});
