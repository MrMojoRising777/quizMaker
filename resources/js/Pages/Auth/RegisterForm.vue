<template>
    <form @submit.prevent="$emit('submit-register')" class="flex flex-column align-items-center gap-3">
        <div class="sm:w-8 md:w-7">
            <InputText
                id="name"
                type="text"
                :label="$t('fields.Name')"
                v-model="registerForm.name"
                required
                autofocus
                autocomplete="name"
                class="w-full"
            />
        </div>

        <div class="sm:w-8 md:w-7">
            <InputText
                id="email"
                type="email"
                :label="$t('fields.Email')"
                v-model="registerForm.email"
                required
                autocomplete="username"
                class="w-full"
            />
        </div>

        <div class="sm:w-8 md:w-7">
            <PasswordValidator
                :show-header="false"
                :placeholder="$t('fields.Password')"
                v-model="registerForm.password"
                class="w-full"
            />
        </div>

        <div class="sm:w-8 md:w-7">
            <InputText
                id="password_confirmation"
                type="password"
                :label="$t('fields.Confirm Password')"
                v-model="registerForm.password_confirmation"
                required
                autocomplete="new-password"
                class="w-full"
            />
        </div>

        <Button type="submit" :severity="'info'" :label="$t('auth.Register')" />
    </form>
</template>

<script setup>
import { toRefs } from 'vue'
import InputText from '../../Components/InputText.vue'
import PasswordValidator from '../../Components/PasswordValidator.vue'
import Button from '../../Components/Button.vue'

const props = defineProps({
    registerForm: {
        type: Object,
        required: true
    }
})

const { registerForm } = toRefs(props)
</script>
