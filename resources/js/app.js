import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import "primeicons/primeicons.css";

// Import PrimeVue and theme
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/lara';

// PrimeVue components
import FileUpload from 'primevue/fileupload';
import Avatar from 'primevue/avatar';
import Rating from 'primevue/rating';
import Button from 'primevue/button';
import Password from 'primevue/password';
import Menubar from 'primevue/menubar';
import Badge from 'primevue/badge';
import InputText from 'primevue/inputtext';
import DataTable from "primevue/datatable";
import Column from 'primevue/column';

// Custom components
import CustomFileUpload from './components/CustomFileUpload.vue';
import PasswordValidator from './components/PasswordValidator.vue';
import WaitingRoom from './components/WaitingRoom.vue';

// Language packs
import { createI18n } from 'vue-i18n';
import nlMessages from './lang/nl.json';
import enMessages from './lang/en.json';

// Create the Inertia app
createInertiaApp({
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        // Configure PrimeVue
        app.use(PrimeVue, {
            theme: {
                preset: Aura,
                options: {
                    prefix: 'p',
                    darkModeSelector: 'system',
                    cssLayer: false,
                },
            },
        });

        // Register PrimeVue components
        app.component('FileUpload', FileUpload);
        app.component('Avatar', Avatar);
        app.component('Rating', Rating);
        app.component('Button', Button);
        app.component('Password', Password);
        app.component('Menubar', Menubar);
        app.component('Badge', Badge);
        app.component('InputText', InputText);
        app.component('DataTable', DataTable);
        app.component('Column', Column);

        // Register custom components
        app.component('file-upload', CustomFileUpload);
        app.component('password-validator', PasswordValidator);
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

        // Mount the app
        app.mount(el);
    },
}).then(() => {
    console.log("Inertia app is mounted successfully.");
}).catch((error) => {
    console.error("Error mounting Inertia app:", error);
});
