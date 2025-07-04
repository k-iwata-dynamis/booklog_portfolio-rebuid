

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
    server: {
        host: '0.0.0.0',
        port:5173,

        //hot module replacementの設定（ホットリロード）
        hmr: {
            host: 'localhost', // ←ここを"localhost"に！
            protocol: 'ws',
            port: 5173,
        },
    },
});
