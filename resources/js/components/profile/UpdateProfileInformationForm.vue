<template>
    <section v-if="user">
        <form @submit.prevent="submit" class="mt-6">
            <div class="row">
                <div class="col s12">
                    <CustomFileUpload class="blue-bg" :avatar-path="user.avatar ? `/storage/${user.avatar}` : ''" />
                </div>
            </div>

            <div class="row">
                <div class="col s6">
                    <label for="name">{{ $t('fields.Name')}}</label>
                    <input id="name" v-model="form.name" type="text" class="validate" required autofocus autocomplete="name">
                    <span v-if="form.errors.name" class="red-text text-darken-2">{{ form.errors.name }}</span>
                </div>

                <div class="col s6">
                    <label for="email">Email</label>
                    <input id="email" v-model="form.email" type="email" class="validate" required autocomplete="username">
                    <span v-if="form.errors.email" class="red-text text-darken-2">{{ form.errors.email }}</span>

                    <div v-if="user.email_verified_at === null" class="blue-bg">
                        <p>Your email address is unverified.</p>
                        <Button
                            :label="$t('profile.Verify Email')"
                            @click.prevent="sendVerification"
                        />

                        <p v-if="status === 'verification-link-sent'" class="green-text text-darken-2">
                            {{ $t('profile.Verify Email Text') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <Button
                        :label="$t('actions.Save')"
                        type="submit"
                    />
                </div>
            </div>
        </form>
    </section>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import Button from '../Button.vue';
import CustomFileUpload from '../../components/CustomFileUpload.vue';

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
