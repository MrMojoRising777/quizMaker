<template>
    <div class="grid">
        <div class="col-12 items-center">
            <Card class="blue-bg">
                <template #title>
                    {{ $t('profile.Profile') }}
                </template>
                <template #content>
                    <div class="space-y-4">
                        <Card class="blue-bg">
                            <template #title>
                                {{ $t('profile.Profile Information') }}
                            </template>
                            <template #content>
                                <UpdateProfileInformationForm :user="user" />
                            </template>
                        </Card>

                        <Card class="blue-bg">
                            <template #title>
                                {{ $t('profile.Update Password') }}
                            </template>
                            <template #content>
                                <UpdatePasswordForm />
                            </template>
                        </Card>

                        <Card class="blue-bg">
                            <template #title>
                                {{ $t('profile.Delete Account') }}
                            </template>
                            <template #content>
                                <DeleteAccountForm />
                            </template>
                        </Card>
                    </div>
                </template>
            </Card>
        </div>
    </div>
</template>

<script>
import Card from 'primevue/card';
import AppLayout from "../../Layouts/AppLayout.vue";
import UpdatePasswordForm from "../../components/profile/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "../../components/profile/UpdateProfileInformationForm.vue";
import DeleteAccountForm from "../../components/profile/DeleteAccountForm.vue";

export default {
    name: "Edit",
    layout: AppLayout,
    components: {
        Card,
        UpdatePasswordForm,
        UpdateProfileInformationForm,
        DeleteAccountForm
    },
    props: {
        user: {
            type: Object,
            required: true,
        }
    },
};
</script>
