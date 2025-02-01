<template>
    <div class="card m-none">
        <div class="card-content">
            <div class="image-container">
                <img src="/public/svg/logoipsum.svg" alt="Icon" />
            </div>

            <span class="card-title fs-28 fw-600 center-align">
                {{ $t('auth.Register') }}
            </span>

            <div class="row">
                <div class="col s12 right-align">
                    <Link href="/login" class="blue-text">{{ $t('auth.Login') }}</Link>
                </div>
            </div>

            <form @submit.prevent="submitForm">
                <div class="row">
                    <div class="col s12">
                        <input
                            id="name"
                            type="text"
                            :placeholder="$t('fields.Name')"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                            class="validate"
                        />
                        <span v-if="errors.name" class="helper-text red-text">
                            {{ errors.name }}
                        </span>
                    </div>

                    <div class="col s12">
                        <input
                            id="email"
                            type="email"
                            :placeholder="$t('fields.Email')"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            class="validate"
                        />
                        <span v-if="errors.email" class="helper-text red-text">
                            {{ errors.email }}
                        </span>
                    </div>

                    <div class="col s12">
                        <password-validator
                            :show-header="false"
                            :placeholder="$t('fields.Password')"
                            v-model="form.password"
                        />
                        <span v-if="errors.password" class="helper-text red-text">
                            {{ errors.password }}
                        </span>
                    </div>

                    <div class="col s12">
                        <input
                            id="password_confirmation"
                            type="password"
                            :placeholder="$t('fields.Confirm Password')"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                            class="validate"
                        />
                        <span v-if="errors.password_confirmation" class="helper-text red-text">
                            {{ errors.password_confirmation }}
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 center-align">
                        <Button
                            type="submit"
                            :label="$t('auth.Register')"
                            :severity="'info'"
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import PasswordValidator from "../../components/PasswordValidator.vue";
import Button from "../../components/Button.vue";
import { Link, router } from "@inertiajs/vue3";

export default {
    components: {
        Link,
        PasswordValidator,
        Button,
    },
    setup() {
        const form = ref({
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
        });

        const errors = ref({});

        const submitForm = async () => {
            router.post('/register', form.value, {
                onError: (err) => {
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
</style>
