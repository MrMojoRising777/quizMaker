import { createApp } from 'vue';

import './bootstrap';

// PrimeVue
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/lara';

import Rating from 'primevue/rating';
import Button from 'primevue/button';

import Password from 'primevue/password';
import PasswordValidator from "./components/PasswordValidator.vue";

import WaitingRoom from "./components/WaitingRoom.vue";
import PlayerScreen from './components/PlayerScreen.vue';

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
app.component('Button', Button);

app.component('Password', Password);
app.component('password-validator', PasswordValidator);

app.component('waiting-room', WaitingRoom);
app.component('player-screen', PlayerScreen);

// Language packs
import {createI18n} from "vue-i18n";
import nlMessages from './lang/nl.json';

const messages = {
    nl: nlMessages,
};

const i18n = createI18n({
    legacy: false,
    locale: document.documentElement.lang || 'en', // Default locale
    messages,
});

app.use(i18n);
app.mount('#app');
