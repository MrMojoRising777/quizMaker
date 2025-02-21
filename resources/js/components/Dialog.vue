<template>
    <Dialog v-model:visible="isVisible" modal>
        <template #header>
            <slot name="header"></slot>
        </template>

        <slot></slot>

        <template #footer>
            <slot name="footer"></slot>
        </template>
    </Dialog>
</template>

<script setup>
import { defineProps, defineEmits, ref, watch } from "vue";
import Dialog from 'primevue/dialog'

const props = defineProps({
    modelValue: Boolean // Parent controls visibility with v-model
});

const emit = defineEmits(["update:modelValue"]);

const isVisible = ref(props.modelValue);

watch(() => props.modelValue, (newValue) => {
    isVisible.value = newValue;
});

const closeDialog = () => {
    emit("update:modelValue", false);
};
</script>
