import { defineConfig } from 'vite';
import { VitePWA } from 'vite-plugin-pwa';
import legacy from '@vitejs/plugin-legacy';

export default defineConfig({
    plugins: [
        legacy({
            targets: ['defaults', 'not IE 11']
        }),
        VitePWA({
            registerType: 'autoUpdate',
            workbox: {
                globPatterns: ['**/*.{js,css,html,ico,png,webp,jpg,jpeg,svg}'],
                runtimeCaching: [
                    {
                        urlPattern: /^https:\/\/fonts\.googleapis\.com\/.*/i,
                        handler: 'CacheFirst',
                        options: {
                            cacheName: 'google-fonts-cache',
                            expiration: {
                                maxEntries: 10,
                                maxAgeSeconds: 60 * 60 * 24 * 365 // 365 days
                            }
                        }
                    },
                    {
                        urlPattern: /\.(?:png|jpg|jpeg|svg|webp)$/,
                        handler: 'CacheFirst',
                        options: {
                            cacheName: 'images-cache',
                            expiration: {
                                maxEntries: 100,
                                maxAgeSeconds: 60 * 60 * 24 * 30 // 30 days
                            }
                        }
                    }
                ]
            },
            manifest: {
                name: 'Hexacore Industries',
                short_name: 'Hexacore',
                description: 'Industrial-Grade Fasteners & Supplies',
                theme_color: '#dc2626',
                background_color: '#111827',
                display: 'standalone',
                start_url: '/',
                icons: [
                    {
                        src: 'icons/icon-192x192.png',
                        sizes: '192x192',
                        type: 'image/png'
                    },
                    {
                        src: 'icons/icon-512x512.png',
                        sizes: '512x512',
                        type: 'image/png'
                    }
                ]
            }
        })
    ],
    build: {
        outDir: 'public/dist',
        assetsDir: 'assets',
        rollupOptions: {
            input: {
                main: 'resources/js/app.js',
                styles: 'resources/css/app.css'
            }
        },
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true
            }
        }
    },
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
            host: 'localhost'
        }
    },
    css: {
        postcss: {
            plugins: [
                require('tailwindcss'),
                require('autoprefixer')
            ]
        }
    }
});