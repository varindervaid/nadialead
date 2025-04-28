import '../css/app.css';
import '../css/satoshi.css';
import './bootstrap';

// //import 'jsvectormap/dist/css/jsvectormap.min.css'
// import 'flatpickr/dist/flatpickr.min.css'

// import { createInertiaApp } from '@inertiajs/vue3';
// import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
// import { createApp, h } from 'vue';
// import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// import { createPinia } from 'pinia'
// import VueApexCharts from 'vue3-apexcharts'

// const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// createInertiaApp({
//     title: (title) => `${title} - ${appName}`,
//     resolve: (name) =>
//         resolvePageComponent(
//             `./Pages/${name}.vue`,
//             import.meta.glob('./Pages/**/*.vue'),
//         ),
//     setup({ el, App, props, plugin }) {
//         return createApp({ render: () => h(App, props) })
//             .use(plugin)
//             .use(ZiggyVue)
//             .use(createPinia())
//             .use(VueApexCharts)
//             .mount(el);
//     },
//     progress: {
//         color: '#4B5563',
//     },
// });



import "./bootstrap";
import { createApp } from "vue";
import app from "./App.vue";
import router from "./Router/router";
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);
const vueApp = createApp(app);
vueApp.use(pinia); // Initialize Pinia
vueApp.use(router);
vueApp.mount('#app');

//createApp(app).use(router).mount("#app");