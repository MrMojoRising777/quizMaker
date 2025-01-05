import { createApp } from 'vue';
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

app.mount('#app');
