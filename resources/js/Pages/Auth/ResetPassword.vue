<template>
    <div class="card">
        <div class="card-content">
            <form @submit.prevent="submitForm">
                <div class="image-container">
                    <img src="/public/svg/logoipsum.svg" alt="Icon" />
                </div>

                <div class="card-title fs-28 fw-600 center-align">{{ $t('auth.New Password') }}</div>

                <div>
                    <input
                        id="email"
                        type="email"
                        v-model="form.email"
                        :placeholder="$t('fields.Email')"
                        required
                        autofocus
                        autocomplete="username"
                        class="validate"
                    />
                    <span v-if="errors.email" class="red-text">{{ errors.email }}</span>
                </div>

                <div>
                    <password-validator
                        v-model="form.password"
                        :show-feedback="true"
                        :placeholder="$t('fields.Password')"
                    />
                    <span v-if="errors.password" class="red-text">{{ errors.password }}</span>
                </div>

                <div>
                    <input
                        id="password_confirmation"
                        type="password"
                        v-model="form.password_confirmation"
                        :placeholder="$t('fields.Confirm Password')"
                        required
                        autocomplete="new-password"
                        class="validate"
                    />
                    <span v-if="errors.password_confirmation" class="red-text">{{ errors.password_confirmation }}</span>
                </div>

                <div class="right-align">
                    <Button
                        type="submit"
                        :label="$t('auth.Reset Password')"
                        :severity="'success'"
                    />
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import PasswordValidator from "../../components/PasswordValidator.vue";
import Button from "../../components/Button.vue";

export default {
    components: {
        PasswordValidator,
        Button,
    },
    props: {
        token: String,
        email: String,
    },
    setup(props) {
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

        return {
            form,
            errors,
            submitForm,
        };
    },
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
