<template>
    <form @submit.prevent="submitAnswers">
        <div class="grid grid-nogutter">
            <div v-for="(question, i) in form.questions" :key="i" class="col-3 p-3">
                <InputText
                    :label="$t('fields.Question') + ' ' + (i + 1)"
                    v-model="form.questions[i].text"
                />
                <InputText
                    :label="$t('fields.Answer') + ' ' + (i + 1)"
                    v-model="form.questions[i].answer"
                />
                <div v-if="form.errors.questions?.[i]?.text" class="error-message">
                    {{ form.errors.questions[i].text }}
                </div>
                <div v-if="form.errors.questions?.[i]?.answer" class="error-message">
                    {{ form.errors.questions[i].answer }}
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
import { useForm } from '@inertiajs/vue3';
import InputText from "../InputText.vue";
import Button from '../Button.vue';

const props = defineProps({
    round: Object,
});

const form = useForm({
    questions: [
        ...props.round?.questions?.map(question => ({
            text: question.text,
            answer: question.answers?.[0]?.text ?? '',
        })) || [],
        ...Array.from({ length: 15 - (props.round?.questions?.length || 0) }, () => ({
            text: '',
            answer: ''
        }))
    ]
});

const submitAnswers = () => {
    if (!props.round?.id) return;

    form.post(route('rounds.store', {round: props.round.id}), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>
