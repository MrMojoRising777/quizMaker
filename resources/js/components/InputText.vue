<template>
    <FloatLabel variant="on">
        <InputText :id="inputId" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" v-bind="$attrs" />
        <label :for="inputId">{{ label }}</label>
    </FloatLabel>
</template>

<script>
import FloatLabel from 'primevue/floatlabel';
import InputText from 'primevue/inputtext';
import {defineComponent} from 'vue';

export default defineComponent({
    components: {
        FloatLabel,
        InputText,
    },
    props: {
        modelValue: String,
        label: {
            type: String,
            required: true,
        },
        inputId: {
            type: String,
            default: () => `input-${Math.random().toString(36).substr(2, 9)}`,
        },
    },
    emits: ['update:modelValue'],
});
</script>
