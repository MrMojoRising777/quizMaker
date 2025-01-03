import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';

// Comment out PrimeVue for a test
import PrimeVue from 'primevue/config';
import Rating from 'primevue/rating';

const app = createApp({});

app.use(PrimeVue);
app.component('Rating', Rating);

app.component('example-component', ExampleComponent);

app.mount('#app');
