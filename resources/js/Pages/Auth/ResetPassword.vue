<template>
    <div class="grid">
        <div class="col-6 col-offset-3 mt-4">
            <Card>
                <template #content>
                    <div class="image-container">
                        <img src="/public/svg/logoipsum.svg" alt="Icon" />
                    </div>

                    <div class="card-title fs-28 fw-600 text-center">
                        {{ $t('auth.New Password') }}
                    </div>

                    <form @submit.prevent="submitForm" class="flex flex-column align-items-center gap-3">
                        <div class="sm:w-8 md:w-7">
                            <InputText
                                id="email"
                                type="email"
                                v-model="form.email"
                                :label="$t('fields.Email')"
                                required
                                autofocus
                                autocomplete="username"
                                class="validate w-full"
                            />
                                <span v-if="errors.email" class="red-text">
                                {{ errors.email }}
                            </span>
                        </div>

                        <div class="sm:w-8 md:w-7">
                            <password-validator
                                v-model="form.password"
                                :show-feedback="true"
                                :placeholder="$t('fields.Password')"
                            />
                            <span v-if="errors.password" class="red-text">
                                {{ errors.password }}
                            </span>
                        </div>

                        <div class="sm:w-8 md:w-7">
                            <input
                                id="password_confirmation"
                                type="password"
                                v-model="form.password_confirmation"
                                :placeholder="$t('fields.Confirm Password')"
                                required
                                autocomplete="new-password"
                                class="validate"
                            />
                            <span v-if="errors.password_confirmation" class="red-text">
                                {{ errors.password_confirmation }}
                            </span>
                        </div>

                        <div class="text-center mt-4">
                            <Button
                                type="submit"
                                :label="$t('auth.Reset Password')"
                                :severity="'success'"
                            />
                        </div>
                    </form>
                </template>
            </Card>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import PasswordValidator from "../../Components/PasswordValidator.vue";
import Button from "../../Components/Button.vue";
import InputText from '../../Components/InputText.vue';
import Card from 'primevue/card';

const props = defineProps({
    token: String,
    email: String,
});

const form = ref({
    email: props.email || '',
    password: '',
    password_confirmation: '',
    token: props.token,
});

const errors = ref({});

const submitForm = async () => {
    router.post('/reset-password', form.value, {
        onError: (err) => {
            console.error('Error during form submission:', err);
            errors.value = err;
        },
    });
};
</script>

<style scoped>
.image-container {
    text-align: center;
    margin-bottom: 20px;
}

.card-title {
    margin-top: 20px;
}

input {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
}

.red-text {
    font-size: 12px;
    color: red;
}
</style>
