<template>
    <div class="grid">
        <div class="col-12">
            <div v-if="can('create quiz')">
                <div class="grid">
                    <div class="col-6">
                        <Card>
                            <template #content>
                                <p v-if="auth.user">Hello, {{ auth.user.name }}!</p>
                                <Button
                                    :severity="'info'"
                                    :label="$t('actions.Create quiz')"
                                    @click="isDialogVisible=true"
                                />
                            </template>
                        </Card>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div v-if="hasRole('Player')" class="p-grid">
                <div class="p-col-12 p-md-6 p-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-xl">{{ $t('dashboard.Personal') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <Dialog v-model="isDialogVisible">
        <template #header>
            <h3>{{ $t('Give the quiz a name') }}</h3>
        </template>

        <form @submit.prevent="createQuiz">
            <div class="grid">
                <div class="col-12">
                    <InputText
                        type="text"
                        v-model="form.name"
                        :label="$t('fields.Name')"
                        required
                    />
                </div>

                <div class="col-12">
                    <Textarea
                        :label="$t('fields.Description')"
                        v-model="form.description"
                        required
                    />
                </div>

                <div class="col-12">
                    <SelectButton v-model="form.type" :options="options" />
                </div>
            </div>

            <Button
                type="submit"
                :severity="'info'"
                :label="$t('actions.Save')"
            />
        </form>

        <template #footer>
            <Button label="Close" @click="isDialogVisible = false" />
        </template>
    </Dialog>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage, useForm } from '@inertiajs/vue3'
import Card from 'primevue/card'
import SelectButton from 'primevue/selectbutton'
import AppLayout from "../Layouts/AppLayout.vue"
import Button from "../Components/Button.vue"
import Dialog from '../Components/Dialog.vue'
import InputText from "../Components/InputText.vue"
import Textarea from "../Components/Textarea.vue"

defineOptions({
    name: "Home",
    layout: AppLayout,
});

const errors = ref({})
const options = ref(['Slimste Mens', 'Custom']);

const props = defineProps({
    quizzes: {
        type: Array,
        default: () => [],
    }
});

const form = useForm({
    name: "",
    description: "",
    type: "",
})

const isDialogVisible = ref(false);

const page = usePage();
const auth = computed(() => page.props.auth);
const can = (permission) => auth.value?.permissions?.includes(permission) || false;
const hasRole = (role) => auth.value?.roles?.includes(role) || false;

const createQuiz = () => {
    form.post(route('quiz.create'), {
        onError: (err) => {
            errors.value = err
        },
        onSuccess: () => {
            isDialogVisible.value = false;
            form.reset();
        }
    });
};
</script>
