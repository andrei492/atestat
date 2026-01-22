import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  server: {
    host: true,
    port: 5199,
  },
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/css/social.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
});