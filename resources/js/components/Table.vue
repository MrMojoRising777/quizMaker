<template>
    <div class="card">
        <DataTable
            :value="quizzes"
            paginator
            :rows="5"
            :rowsPerPageOptions="[5, 10, 20, 50]"
            tableStyle="min-width: 50rem"
            @rowClick="viewQuiz"
            class="pointer"
        >
            <!-- TODO: set 'times played', 'rated' & actions -->
            <Column field="title" header="Title" style="width: 20%"></Column>
            <Column field="rounds.length" header="Rounds" style="width: 20%"></Column>
            <Column field="" header="Times Played" style="width: 20%"></Column>
            <Column field="" header="Rated" style="width: 20%"></Column>
            <Column field="" header="Actions" style="width: 20%"></Column>
        </DataTable>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import DataTable from "primevue/datatable";
import Column from 'primevue/column';
import { router } from "@inertiajs/vue3";

const props = defineProps({
    quizzes: {
        type: Array,
        default: () => [],
    },
})

const viewQuiz = (event) => {
    const quiz = event.data;
    router.get(route('quiz.show', { quiz: quiz.id }));
};
</script>
