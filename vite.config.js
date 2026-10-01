import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import {viteStaticCopy} from 'vite-plugin-static-copy';
import {glob} from "glob";
import dotenv from 'dotenv';

//Cargar Variables ENV
dotenv.config();

export default defineConfig({
    server: {
        host: process.env.VITE_IP || '0.0.0.0',  // Escuchar en todas las interfaces
        port: process.env.VITE_PORT || 3001,    // Cambia al puerto que prefieras
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.scss',
                "resources/js/app.js",
                ...glob.sync("resources/js/**/*.js"),
                ...glob.sync("resources/css/**/*.css")
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: 'resources/assets',
                    dest: '../'
                }
            ]
        }),
    ],
    build: {
        outDir: 'public/build',
        rollupOptions: {
            output: {
                assetFileNames: '[name].[hash][extname]',
                chunkFileNames: '[name].[hash].js',
                entryFileNames: '[name].[hash].js',
            }
        }
    },
    resolve: {
        alias: {
            'tailwind.config.js': './tailwind.config.cjs',
        },
    },
});
