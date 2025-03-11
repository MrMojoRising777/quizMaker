<template>
    <FloatLabel variant="on">
        <Textarea
            :id="inputId"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            v-bind="$attrs"
            class="w-full"
        />
        <label :for="inputId">{{ label }}</label>
    </FloatLabel>
</template>

<script>
import FloatLabel from 'primevue/floatlabel';
import Textarea from 'primevue/textarea';
import { defineComponent } from 'vue';

export default defineComponent({
    components: {
        FloatLabel,
        Textarea
    },
    props: {
        modelValue: String,
        label: {
            type: String,
            required: true,
        },
        inputId: {
            type: String,
            default: () => `textarea-${Math.random().toString(36).substr(2, 9)}`,
        }
    },
    emits: ['update:modelValue'],
});
</script>
