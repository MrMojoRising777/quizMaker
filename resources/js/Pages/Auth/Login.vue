<template>
    <div class="card m-none">
        <div class="card-content">
            <div class="image-container">
                <img src="/public/svg/logoipsum.svg" alt="Icon" />
            </div>
            <span class="card-title fs-28 fw-600 center-align">{{ $t('auth.Login') }}</span>
            <div class="row">
                <div class="col s12 right-align">
                    <Link href="/register" class="blue-text">{{ $t('auth.No account?') }}</Link>
                </div>
            </div>
            <div v-if="status" class="mb-4">
                <div class="chip green">{{ status }}</div>
            </div>
            <div v-for="(error, field) in errors" :key="field">
                <span class="helper-text red-text">{{ error }}</span>
            </div>
            <form @submit.prevent="submitForm">
                <div class="row">
                    <div class="col s12">
                        <input
                            v-model="form.email"
                            id="email"
                            type="email"
                            :placeholder="$t('fields.Email')"
                            required
                            autofocus
                            autocomplete="username"
                            class="validate"
                        />
                    </div>
                    <div class="col s12">
                        <password-validator
                            v-model="form.password"
                            :show-feedback="false"
                            :placeholder="$t('fields.Password')"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <Link v-if="canResetPassword" href="/forgot-password" class="blue-text text-darken-2">
                            {{ $t('auth.Forgot your password?') }}
                        </Link>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center-align">
                        <Button
                            type="submit"
                            :severity="'success'"
                            :label="$t('auth.Login')"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<!-- TODO guest layout, login form style -->
<script>
import { ref } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import PasswordValidator from '../../components/PasswordValidator.vue'
import Button from '../../components/Button.vue'

export default {
    components: {
        Link,
        PasswordValidator,
        Button,
    },
    setup() {
        const form = ref({
            email: '',
            password: '',
        });

        const errors = ref({});
        const status = ref('');
        const canResetPassword = true;

        const submitForm = async () => {
            router.post('/login', form.value, {
                onError: (err) => {
                    errors.value = err;
                },
                onSuccess: (page) => {
                    status.value = page.props.flash?.message || '';
                },
            });
        };

        return {
            form,
            errors,
            status,
            canResetPassword,
            submitForm,
        };
    },
}
</script>
