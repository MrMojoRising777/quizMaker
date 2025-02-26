<template>
    <form @submit.prevent="submitAnswers">
        <div class="grid grid-nogutter">

            <div v-for="(question, i) in form.questions" :key="i" class="col-6 p-3">

                <InputText
                    :label="$t('fields.Keyword') + ' ' + (i + 1)"
                    v-model="form.questions[i].text"
                    class="w-full"
                />

                <div v-for="(answer, j) in form.questions[i].answers" :key="j" class="mb-2">
                    <InputText
                        :label="$t('fields.Answer') + ' ' + (j + 1)"
                        v-model="form.questions[i].answers[j]"
                        class="w-full"
                    />
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

const props = defineProps({
    round: Object,
});

const form = useForm({
    questions: [
        ...props.round?.questions?.map(question => ({
            text: question.text,
            answers: question.answers?.slice(0, 10).map(answer => answer.text ?? '') || Array(10).fill('')
        })) || [],
        ...Array.from({ length: 4 - (props.round?.questions?.length || 0) }, () => ({
            text: '',
            answers: Array(10).fill('')
        }))
    ]
});

const submitAnswers = () => {
    form.post(route("rounds.store.ingelijst", { round: props.round.id }), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>
