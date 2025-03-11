<template>
    <div class="valign-wrapper shadowNone">
        <Password
            class="style-none w-full"
            :feedback="showFeedback"
            v-model="internalPassword"
            :placeholder="placeholder"
            :promptLabel="$t('Choose a password')"
            :weakLabel="$t('Too simple')"
            :mediumLabel="$t('Average complexity')"
            :strongLabel="$t('Complex password')"
            toggleMask
        >
        <template #header v-if="showFeedback">
            <p class="mt-2">{{ $t('Suggestions') }}</p>
            <ul class="pl-2 ml-2 mt-0" style="line-height: 1.5">
                <li>{{ $t('At least one lowercase')}}</li>
                <li>{{ $t('At least one uppercase')}}</li>
                <li>{{ $t('At least one numeric')}}</li>
                <li>{{ $t('Minimum 8 characters')}}</li>
            </ul>
        </template>
        </Password>
        <input type="hidden" name="password" :value="internalPassword" />
    </div>
</template>

<script setup>
import Password from 'primevue/password';
import { computed } from 'vue'

const props = defineProps({
    showFeedback: {
        type: Boolean,
        default: true,
    },
    placeholder: {
        type: String,
        default: 'Password',
    },
    modelValue: {
        type: String,
        default: '',
    },
})

const emit = defineEmits(['update:modelValue'])

const internalPassword = computed({
    get() {
        return props.modelValue
    },
    set(newValue) {
        emit('update:modelValue', newValue)
    },
})
</script>
