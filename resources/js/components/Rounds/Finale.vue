<template>
    <form @submit.prevent="submitAnswers">
        <div class="grid grid-nogutter">
            <div v-for="(question, i) in form.questions" :key="i" class="col-6 p-3">
                <div class="flex flex-column gap-2">
                    <InputText
                        :label="$t('fields.Keyword') + ' ' + (i + 1)"
                        v-model="form.questions[i].text"
                    />

                    <div v-for="(answer, j) in form.questions[i].answers" :key="j">
                        <InputText
                            :label="$t('fields.Answer') + ' ' + (j + 1)"
                            v-model="form.questions[i].answers[j]"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <Button
                :label="$t('actions.Save')"
                type="submit"
                :disabled="form.processing"
            />
        </div>

        <div v-if="form.errors.questions" class="error-message">
            {{ form.errors.questions }}
        </div>
    </form>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import InputText from "../InputText.vue";
import Button from "../Button.vue";
import { useToast } from "primevue/usetoast";

const toast = useToast();
const props = defineProps({
    round: Object,
});

const form = useForm({
    questions: [
        ...props.round?.questions?.map(question => ({
            text: question.text,
            answers: question.answers?.slice(0, 4).map(answer => answer.text ?? '') || Array(4).fill('')
        })) || [],
        ...Array.from({ length: 10 - (props.round?.questions?.length || 0) }, () => ({
            text: '',
            answers: Array(4).fill('')
        }))
    ]
});

const submitAnswers = () => {
    form.post(route("rounds.store.ingelijst", { round: props.round.id }), {
        preserveScroll: true,
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Success', detail: 'Questions saved successfully!', life: 3000 });
        },
        onError: (errors) => {
            toast.add({ severity: 'error', summary: 'Error', detail: 'Failed to save questions.', life: 3000 });
        },
    });
};
</script>
