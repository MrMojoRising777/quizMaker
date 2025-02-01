<template>
    <div class="card">
        <div class="card-content">
            <div class="image-container">
                <img src="/public/svg/logoipsum.svg" alt="Icon" />
            </div>

            <div class="card-title fs-28 fw-600 center-align">
                {{ $t("auth.Forgot your password?") }}
            </div>

            <p class="center-align">
                {{ $t("auth.Reset Password Text") }}
            </p>

            <form @submit.prevent="submit">
                <div>
                    <input
                        id="email"
                        type="email"
                        v-model="form.email"
                        :placeholder="$t('fields.Email')"
                        required
                        autofocus
                        class="validate"
                    />
                    <span v-if="errors.email" class="red-text">{{ errors.email }}</span>
                </div>

                <div class="left-align mt-4">
                    <Button
                        type="submit"
                        :label="$t('actions.Send')"
                        :severity="'success'"
                        :disabled="form.processing"
                    />
                </div>
            </form>

            <div
                v-if="toastMessage"
                class="toast-message green lighten-4 green-text text-darken-4"
            >
                {{ toastMessage }}
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import {useForm} from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import Button from '../../components/Button.vue';

export default {
    components: {
        Button,
    },
    setup() {
        const { t } = useI18n();
        const form = useForm({
            email: '',
        });

        const errors = ref({});
        const toastMessage = ref(null);

        const submit = () => {
            form.post('/forgot-password', {
                onSuccess: (response) => {
                    errors.value = {};
                    toastMessage.value = form.data.status || t('toasts.Reset Link');
                    setTimeout(() => (toastMessage.value = null), 3000);
                },
                onError: (err) => {
                    errors.value = err;
                },
            });
        };

        return {
            form,
            errors,
            toastMessage,
            submit,
        };
    },
};
</script>

<style scoped>
.toast-message {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 10px 20px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}
</style>
