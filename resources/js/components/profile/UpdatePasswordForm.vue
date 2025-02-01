<template>
    <section>
        <form @submit.prevent="updatePassword" class="mt-6">
            <div class="mb-4">
                <label for="current_password" class="block text-sm font-medium">{{ $t('fields.Current Password') }}</label>
                <Password id="current_password" v-model="form.current_password" toggleMask class="w-full" autocomplete="current-password" />
                <small class="text-red-500" v-if="errors.current_password">{{ errors.current_password }}</small>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium">{{ $t('auth.New Password') }}</label>
                <Password id="password" v-model="form.password" toggleMask class="w-full" autocomplete="new-password" />
                <small class="text-red-500" v-if="errors.password">{{ errors.password }}</small>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium">{{ $t('fields.Confirm Password') }}</label>
                <Password id="password_confirmation" v-model="form.password_confirmation" toggleMask class="w-full" autocomplete="new-password" />
                <small class="text-red-500" v-if="errors.password_confirmation">{{ errors.password_confirmation }}</small>
            </div>

            <div class="mt-4">
                <Button type="submit" :label="$t('actions.Save')" class="p-button p-button-primary" />
                <p v-if="status === 'password-updated'" class="text-green-500 mt-2">{{ $t('Saved') }}</p>
            </div>
        </form>
    </section>
</template>

<script>
import { defineComponent, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Password from 'primevue/password';
import Button from 'primevue/button';

export default defineComponent({
    components: { Password, Button },
    setup() {
        const form = useForm({
            current_password: '',
            password: '',
            password_confirmation: '',
        });

        const errors = ref({});
        const status = ref(null);

        const updatePassword = () => {
            form.put(route('password.update'), {
                onSuccess: () => {
                    status.value = 'password-updated';
                    form.reset();
                },
                onError: (err) => {
                    errors.value = err;
                },
            });
        };

        return { form, errors, status, updatePassword };
    },
});
</script>

<style scoped>
.mb-4 {
    margin-bottom: 1rem;
}
</style>
