<template>
    <div class="valign-wrapper custom">
        <Password class="style-none" :feedback="showFeedback" v-model="passwordValue" :placeholder="placeholder" :promptLabel="$t('Choose a password')" :weakLabel="$t('Too simple')" :mediumLabel="$t('Average complexity')" :strongLabel="$t('Complex password')" toggleMask >
            <template #header v-if="showFeedback">
<!--                <h6>Pick a password</h6>-->
                <p class="mt-2">{{ $t('Suggestions') }}</p>
                <ul class="pl-2 ml-2 mt-0" style="line-height: 1.5">
                    <li>{{ $t('At least one lowercase')}}</li>
                    <li>{{ $t('At least one uppercase')}}</li>
                    <li>{{ $t('At least one numeric')}}</li>
                    <li>{{ $t('Minimum 8 characters')}}</li>
                </ul>
            </template>
        </Password>
        <input type="hidden" name="password" :value="passwordValue" />
    </div>
</template>

<script setup>
    import { ref } from 'vue';

    defineProps({
        showFeedback: {
            type: Boolean,
            default: true,
        },
        placeholder: {
            type: String,
            default: 'Password',
        },
    });

    const passwordValue = ref('');
</script>
