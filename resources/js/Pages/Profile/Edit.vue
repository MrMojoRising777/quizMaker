<template>
    <div class="grid">
        <div class="col-12 items-center">
            <Card>
                <template #title>
                    {{ $t('profile.Profile') }}
                </template>
                <template #content>
                    <div class="space-y-4">
                        <Card>
                            <template #title>
                                {{ $t('profile.Profile Information') }}
                            </template>
                            <template #content>
                                <UpdateProfileInformationForm :user="user" />
                            </template>
                        </Card>

                        <Card>
                            <template #title>
                                {{ $t('profile.Update Password') }}
                            </template>
                            <template #content>
                                <UpdatePasswordForm />
                            </template>
                        </Card>

                        <Card>
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
import UpdatePasswordForm from "../../Components/Profile/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "../../Components/Profile/UpdateProfileInformationForm.vue";
import DeleteAccountForm from "../../Components/Profile/DeleteAccountForm.vue";

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
