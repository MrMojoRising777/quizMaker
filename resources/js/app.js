import { createApp } from 'vue';

// PrimeVue
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/lara';

import Rating from 'primevue/rating';

import Password from 'primevue/password';
import PasswordValidator from "./components/PasswordValidator.vue";

const app = createApp({});

app.use(PrimeVue, {
    theme: {
        preset: Aura,
        options: {
            prefix: 'p',
            darkModeSelector: 'system',
            cssLayer: false
        }
    }
});

app.component('Rating', Rating);

app.component('Password', Password);
app.component('password-validator', PasswordValidator);


// Language packs
import {createI18n} from "vue-i18n";
import nlMessages from './lang/nl.json';

const messages = {
    nl: nlMessages,
};

const i18n = createI18n({
    locale: document.documentElement.lang || 'en', // Default locale
    messages,
});

app.use(i18n);
app.mount('#app');
