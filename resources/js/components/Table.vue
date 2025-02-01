<template>
    <div class="card">
        <DataTable
            :value="quizzes"
            paginator
            :rows="5"
            :rowsPerPageOptions="[5, 10, 20, 50]"
            tableStyle="min-width: 50rem"
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

const props = defineProps({
    quizzes: {
        type: Array,
        default: () => [],
    },
})
</script>
