import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/siswa-search.js",
                "resources/js/guru-search.js",
                "resources/css/admin/guru.css",
                "resources/js/admin/guru.js",
                "resources/js/guru-scroll.js",
                "resources/css/pages/ppdb-admin.css",
                "resources/js/pages/ppdb-admin.js",
                "resources/css/components/siswa-detail.css",
                "resources/js/components/siswa-detail.js",
                "resources/css/components/ppdb-detail.css",
                "resources/js/components/ppdb-detail.js",
                "resources/js/components/ppdb-edit.js",
            ],
            refresh: true,
        }),
    ],
    server: {
        // host: '0.0.0.0',
        // hmr: {
        //     host: 'polysepalous-candyce-unprohibitively.ngrok-free.dev',
        // },
    },
});