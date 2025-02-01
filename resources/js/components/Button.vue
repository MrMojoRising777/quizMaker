<template>
    <Button v-bind="buttonProps" />
</template>

<script setup>
import { defineProps } from 'vue';
import Button from 'primevue/button';

const props = defineProps({
    buttonProps: {
        type: Object,
    },
});
</script>
