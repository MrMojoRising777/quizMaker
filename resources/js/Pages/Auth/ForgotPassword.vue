<template>
    <div class="grid">
        <div class="col-6 col-offset-3 mt-4">
            <Card>
                <template #content>
                    <div class="image-container">
                        <img src="/public/svg/logoipsum.svg" alt="Icon" />
                    </div>

                    <div class="card-title fs-28 fw-600 text-center">
                        {{ $t("auth.Forgot your password?") }}
                    </div>

                    <p class="text-center">
                        {{ $t("auth.Reset Password Text") }}
                    </p>

                    <form @submit.prevent="submit" class="mt-5">
                        <InputText
                            id="email"
                            type="email"
                            v-model="form.email"
                            :label="$t('fields.Email')"
                            required
                            autofocus
                            class="validate w-full"
                        />
                        <span v-if="errors.email" class="red-text">{{ errors.email }}</span>

                        <div class="text-center mt-4">
                            <Button
                                type="submit"
                                :label="$t('actions.Send')"
                                :severity="'success'"
                                :disabled="form.processing"
                            />
                        </div>
                    </form>

                    <div v-if="toastMessage" class="toast-message green lighten-4 green-text text-darken-4">
                        {{ toastMessage }}
                    </div>
                </template>
            </Card>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import {useForm} from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import Button from '../../components/Button.vue'
import InputText from '../../components/InputText.vue'
import Card from 'primevue/card'

const { t } = useI18n()
const form = useForm({
    email: '',
})

const errors = ref({})
const toastMessage = ref(null)

const submit = () => {
    form.post('/forgot-password', {
        onSuccess: (response) => {
            errors.value = {}
            toastMessage.value = form.data.status || t('toasts.Reset Link')
            setTimeout(() => (toastMessage.value = null), 3000)
        },
        onError: (err) => {
            errors.value = err
        },
    })
}
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
