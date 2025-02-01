<template>
    <Rating v-model="value" />
</template>

<script>
import Rating from 'primevue/rating';
import { ref } from 'vue';

export default {
    components: {
        Rating,
    },
}

const value = ref(null);
</script>
