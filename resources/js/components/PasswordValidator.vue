<template>
    <div class="valign-wrapper custom">
        <Password class="style-none" :feedback="showFeedback" v-model="passwordValue" :placeholder="placeholder" promptLabel="Choose a password" weakLabel="Too simple" mediumLabel="Average complexity" strongLabel="Complex password" toggleMask >
            <template #header v-if="showFeedback">
<!--                <h6>Pick a password</h6>-->
                <p class="mt-2">Suggestions</p>
                <ul class="pl-2 ml-2 mt-0" style="line-height: 1.5">
                    <li>At least one lowercase</li>
                    <li>At least one uppercase</li>
                    <li>At least one numeric</li>
                    <li>Minimum 8 characters</li>
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
