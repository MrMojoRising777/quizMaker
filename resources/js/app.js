import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import "primeicons/primeicons.css";

// Import PrimeVue and theme
import PrimeVue from 'primevue/config';
import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';
import Lara from '@primevue/themes/lara';
import 'primeflex/themes/primeone-dark.css';

import 'primeflex/primeflex.css';

// PrimeVue components
import Rating from 'primevue/rating';

// Custom components
import WaitingRoom from './Components/WaitingRoom.vue';

// Language packs
import { createI18n } from 'vue-i18n';
import nlMessages from './lang/nl.json';
import enMessages from './lang/en.json';

// Create the Inertia app
createInertiaApp({
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({
            render: () => h(App, props)
        });

        // Configure PrimeVue
        app.use(PrimeVue, {
            theme: {
                preset: Lara,
                options: {
                    prefix: 'p',
                    darkModeSelector: 'false',
                    cssLayer: false,
                },
            },
        });

        // Register PrimeVue components
        app.component('Rating', Rating);

        app.component('waiting-room', WaitingRoom);

        // Configure i18n
        const messages = {
            nl: nlMessages,
            en: enMessages,
        };
        const i18n = createI18n({
            legacy: false,
            locale: document.documentElement.lang || 'en', // Default locale
            messages,
        });
        app.use(i18n);

        // Use Inertia plugin
        app.use(plugin);
        app.mixin({ methods: { route }})

        app.use(ConfirmationService);
        app.use(ToastService);

        // Mount the app
        app.mount(el);
    },
}).then(() => {
    //
}).catch((error) => {
    console.error("Error mounting Inertia app:", error);
});
