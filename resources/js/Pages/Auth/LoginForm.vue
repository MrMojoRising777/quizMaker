<template>
    <form @submit.prevent="$emit('submit-login')" class="flex flex-column align-items-center gap-3">
        <div class="sm:w-8 md:w-7">
            <InputText
                v-model="loginForm.email"
                :label="$t('fields.Email')"
                id="email"
                type="email"
                required
                autofocus
                autocomplete="username"
                class="w-full"
            />
        </div>

        <div class="sm:w-8 md:w-7">
            <PasswordValidator
                v-model="loginForm.password"
                :label="$t('fields.Password')"
                :show-feedback="false"
                :placeholder="$t('fields.Password')"
                class="w-full"
            />
        </div>

        <Button type="submit" severity="success" :label="$t('auth.Login')" />

        <Link
            v-if="canResetPassword"
            :href="route('password.request')"
            class="blue-text text-darken-2"
        >
            {{ $t('auth.Forgot your password?') }}
        </Link>
    </form>
</template>

<script setup>
import { toRefs } from 'vue'
import { Link } from '@inertiajs/vue3'
import InputText from '../../Components/InputText.vue'
import PasswordValidator from '../../Components/PasswordValidator.vue'
import Button from '../../Components/Button.vue'

const props = defineProps({
    loginForm: {
        type: Object,
        required: true
    },
    canResetPassword: {
        type: Boolean,
        default: false
    }
})


const { loginForm } = toRefs(props)
</script>
