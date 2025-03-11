<template>
    <form @submit.prevent="submitAnswers">
        <div class="grid grid-nogutter">
            <div v-for="(question, i) in form.questions" :key="i" class="col-4 p-4">
                <div class="flex flex-column gap-2">
                    <i class="pi pi-file-edit" :class="{'text-green-500': form.questions[i].note}" @click="openNoteEditor(i)"></i>
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

        <Dialog v-model="isDialogVisible" class="w-6">
            <template #header>
                <h3>{{ $t('actions.Edit Note') }}</h3>
            </template>

            <div class="grid">
                <div class="col-12">
                    <Textarea
                        v-model="currentNote"
                        rows="5"
                        class="w-full"
                        :label="$t('fields.Note')"
                    />
                </div>
            </div>

            <template #footer>
                <Button
                    :label="$t('actions.Save')"
                    @click="saveNote"
                    :severity="'info'"
                />

                <Button
                    :label="$t('actions.Close')"
                    @click="isDialogVisible = false"
                    :severity="'secondary'"
                />
            </template>
        </Dialog>
    </form>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import InputText from "../InputText.vue";
import Button from '../Button.vue';
import Textarea from "@/Components/Textarea.vue";
import Dialog from "@/Components/Dialog.vue";

const toast = useToast();
const props = defineProps({
    round: Object,
});
const isDialogVisible = ref(false);
const activeQuestionIndex = ref(null);
const currentNote = ref('');

const form = useForm({
    questions: [
        ...props.round?.questions?.map(question => ({
            text: question.text,
            answer: question.answers?.[0]?.text ?? '',
            note: question.note,
        })) || [],
        ...Array.from({ length: 15 - (props.round?.questions?.length || 0) }, () => ({
            text: '',
            answer: '',
            note: null,
        }))
    ]
});

const openNoteEditor = (index) => {
    activeQuestionIndex.value = index;
    currentNote.value = form.questions[index].note || '';
    isDialogVisible.value = true;
};

const saveNote = () => {
    if (activeQuestionIndex.value !== null) {
        form.questions[activeQuestionIndex.value].note = currentNote.value;
    }
    isDialogVisible.value = false;
};

const submitAnswers = () => {
    if (!props.round?.id) return;

    form.post(route("rounds.store.369", {round: props.round.id}), {
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
