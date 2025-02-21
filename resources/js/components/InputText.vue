<template>
    <FloatLabel variant="on">
        <InputText
            :id="inputId"
            v-model="inputValue"
            v-bind="$attrs"
        />
        <label :for="inputId">{{ label }}</label>
    </FloatLabel>
</template>

<script>
import FloatLabel from 'primevue/floatlabel';
import InputText from 'primevue/inputtext';
import { defineComponent, computed } from 'vue';

export default defineComponent({
    inheritAttrs: false, // Ensure $attrs works properly
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
    setup(props, {emit}) {
        const inputValue = computed({
            get: () => props.modelValue,
            set: (value) => emit('update:modelValue', value),
        });

        return {inputValue};
    },
});
</script>
