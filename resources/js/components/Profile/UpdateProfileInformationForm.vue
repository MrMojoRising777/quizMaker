<template>
    <section v-if="user" class="p-4">
        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <!-- Avatar Upload -->
            <div class="flex justify-center">
                <CustomFileUpload :avatar-path="user.avatar ? `/storage/${user.avatar}` : ''" />
            </div>

            <!-- Name & Email Fields -->
            <div class="flex flex-wrap gap-4">
                <div class="w-full md:w-6">
                    <InputText
                        type="text"
                        v-model="form.name"
                        :label="$t('fields.Name')"
                        required
                        class="w-full"
                    />
                </div>

                <div class="w-full md:w-6">
                    <InputText
                        type="email"
                        v-model="form.email"
                        :label="$t('fields.Email')"
                        required
                    />

                    <div v-if="user.email_verified_at === null" class="mt-2">
                        <p class="text-red-500">{{ $t('profile.Unverified Email') }}</p>
                        <Button
                            :label="$t('profile.Verify Email')"
                            @click.prevent="sendVerification"
                            class="mt-2"
                        />
                        <p v-if="status === 'verification-link-sent'" class="text-green-500 mt-2">
                            {{ $t('profile.Verify Email Text') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-center mt-4">
                <Button :label="$t('actions.Save')" type="submit" />
            </div>
        </form>
    </section>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import Button from '../Button.vue';
import CustomFileUpload from '../../Components/CustomFileUpload.vue';
import InputText from '../InputText.vue';

const props = defineProps({
    user: Object,
    status: String
});

const form = useForm({
    name: props.user?.name || '',
    email: props.user?.email || ''
});

const sendVerification = () => {
    router.post(route('verification.send'));
};

const submit = () => {
    form.patch(route('profile.update'), {
        preserveScroll: true,
        onError: (errors) => {
            console.error('Validation Errors:', errors);
        }
    });
};
</script>
