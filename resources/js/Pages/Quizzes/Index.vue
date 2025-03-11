<template>
    <div class="card">
        <Button
            :severity="'info'"
            :label="$t('actions.Create quiz')"
            @click="isDialogVisible=true"
        />

        <DataTable
            :value="quizzes"
            paginator
            :rows="5"
            :rowsPerPageOptions="[5, 10, 20, 50]"
            tableStyle="min-width: 50rem"
            @rowClick="viewQuiz"
            :class="{'pointer': quizzes.length > 0}"
        >
            <template #empty>
                <div class="text-center p-4">
                    {{ $t('messages.noQuizzes') }}
                </div>
            </template>

            <!-- TODO: set 'times played', 'rated' & actions -->
            <Column field="title" :header="$t('th.Title')" style="width: 20%"></Column>
            <Column field="rounds.length" :header="$t('th.Rounds')" style="width: 20%"></Column>
            <Column field="" :header="$t('th.Times Played')" style="width: 20%"></Column>
            <Column field="" :header="$t('th.Rated')" style="width: 20%"></Column>
            <Column field="" :header="$t('th.Actions')" style="width: 20%"></Column>
        </DataTable>
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
            <Button
                :label="$t('actions.Close')"
                @click="isDialogVisible = false" />
        </template>
    </Dialog>
</template>

<script setup>
import {defineProps, ref} from 'vue';
import {router, useForm} from "@inertiajs/vue3";
import AppLayout from "../../Layouts/AppLayout.vue";
import Column from "primevue/column";
import DataTable from "primevue/datatable";
import Button from "../../Components/Button.vue";
import Dialog from "../../Components/Dialog.vue";
import SelectButton from "primevue/selectbutton";
import Textarea from "../../Components/Textarea.vue";
import InputText from "../../Components/InputText.vue";

defineOptions({
    name: "Quizzes.Index",
    layout: AppLayout,
});

const form = useForm({
    name: "",
    description: "",
    type: "",
});

const props = defineProps({
    quizzes: {
        type: Array,
        default: () => [],
    },
});

const isDialogVisible = ref(false);
const options = ref(['Slimste Mens', 'Custom']);

const createQuiz = () => {
    form.post(route('quizzes.create'), {
        onError: (err) => {
            errors.value = err
        },
        onSuccess: () => {
            isDialogVisible.value = false;
            form.reset();
        }
    });
};

const viewQuiz = (event) => {
    const quiz = event.data;
    router.get(route('quizzes.show', { quiz: quiz.id }));
};
</script>
