<template>
    <div class="card">
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
</template>

<script setup>
import { defineProps } from 'vue';
import { router } from "@inertiajs/vue3";
import AppLayout from "../../Layouts/AppLayout.vue";
import Column from "primevue/column";
import DataTable from "primevue/datatable";

defineOptions({
    name: "Quizzes.Index",
    layout: AppLayout,
});

const props = defineProps({
    quizzes: {
        type: Array,
        default: () => [],
    },
})

const viewQuiz = (event) => {
    const quiz = event.data;
    router.get(route('quizzes.show', { quiz: quiz.id }));
};
</script>
