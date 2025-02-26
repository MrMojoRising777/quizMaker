<template>
    <Modal :show="show" :title="$t('Give the quiz a name')">
        <form @submit.prevent="createQuiz">
            <div class="grid">
                <div class="col-12">
                    <InputText
                        type="text"
                        v-model="quizName"
                        :label="$t('Name')"
                        required
                    />
                </div>

                <div class="col-12">
                    <Textarea
                        :label="$t('Description')"
                        v-model="quizDescription"
                        required
                    />
                </div>
            </div>

            <Button
                type="submit"
                :severity="'info'"
                :label="$t('Create')"
            />
        </form>
    </Modal>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import Modal from '../Modal.vue';
import Button from "../Button.vue"
import InputText from "../InputText.vue";
import Textarea from "../Textarea.vue";

const show = ref(false);
const quizName = ref("");
const quizDescription = ref("");
const errors = ref(null);

const form = useForm({
    name: quizName,
    description: quizDescription,
});

const createQuiz = () => {
    form.post(route("quizzes.create"), {
        onError: (err) => {
            errors.value = err;
        },
        onSuccess: () => {
            closeModal();
            form.reset();
        },
    });
};
</script>
