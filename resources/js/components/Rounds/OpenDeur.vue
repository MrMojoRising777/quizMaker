<template>
    <form @submit.prevent="submitAnswers">
        <div class="grid grid-nogutter">

            <div v-for="(question, i) in form.questions" :key="i" class="col-6 p-3">

                <label>{{ $t('fields.Image') }}</label>

                <div v-if="question.file_path" class="mt-2">
                    <img :src="getImageUrl(question.file_path)" alt="Question image" height="100" />
                </div>
                <div v-else class="mt-2" @click="triggerUpload(i)" style="cursor: pointer;">
                    <Skeleton height="100px" />
                </div>
                <input
                    type="file"
                    accept=".jpg, .jpeg, .png"
                    style="display: none;"
                    :id="'image-' + i"
                    @change="handleImageUpload($event, i)"
                />

                <InputText
                    :label="$t('fields.Question') + ' ' + (i + 1)"
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
import { onMounted } from 'vue';
import { useForm } from "@inertiajs/vue3";
import InputText from "../InputText.vue";
import Button from "../Button.vue";
import Skeleton from "primevue/skeleton";

const props = defineProps({
    round: Object,
});

const form = useForm({
    questions: [
        ...props.round?.questions?.map(question => ({
            text: question.text,
            file_path: question.file_path ?? '',
            answers: question.answers?.slice(0, 4).map(answer => answer.text ?? '') || Array(4).fill('')
        })) || [],
        ...Array.from({ length: 4 - (props.round?.questions?.length || 0) }, () => ({
            text: '',
            image: '',
            answers: Array(4).fill('')
        }))
    ]
});

const triggerUpload = (index) => {
    document.getElementById(`image-${index}`).click();
};

const getImageUrl = (file_path) => {
    if (!file_path) return '';

    if (file_path.startsWith('data:image')) {
        return file_path;
    }

    return `/storage/${file_path}`;
};

const handleImageUpload = (event, index) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            form.questions[index].file_path = e.target.result; // Store as base64
        };
        reader.readAsDataURL(file);
    }
};

const submitAnswers = () => {
    form.post(route("rounds.store.open-deur", { round: props.round.id }), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>
