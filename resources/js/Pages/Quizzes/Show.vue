<template>
    <Card>
        <template #title>{{ quiz.title }}</template>
        <template #content>
            <Button
                severity="danger"
                label="Delete Quiz"
                @click="confirmDelete"
            />

            <Tabs v-model="activeTab">
                <TabList>
                    <Tab v-for="(round, index) in quiz.rounds" :key="round.title" :value="index">
                        {{ round.title }}
                    </Tab>
                </TabList>
                <TabPanels>
                    <TabPanel v-for="(round, index) in quiz.rounds" :key="round.title" :value="index">
                        <component :is="getRoundComponent(round.order)" :round="round" />
                    </TabPanel>
                </TabPanels>
            </Tabs>
        </template>
    </Card>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';

import Card from 'primevue/card';
import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';
import Tab from 'primevue/tab';
import Button from 'primevue/button';

import AppLayout from '../../Layouts/AppLayout.vue';

import Round369 from '../../Components/Rounds/3-6-9.vue';
import OpenDeur from '../../Components/Rounds/OpenDeur.vue';
import Puzzel from '../../Components/Rounds/Puzzel.vue';
import Ingelijst from '../../Components/Rounds/Ingelijst.vue';
import Finale from '../../Components/Rounds/Finale.vue';

defineOptions({
    name: "Quiz.Show",
    layout: AppLayout,
});

const props = defineProps({
    quiz: Object
});

const activeTab = ref(0);
const toast = useToast();
const confirm = useConfirm();

const getRoundComponent = (order) => {
    switch (order) {
        case 1: return Round369;
        case 2: return OpenDeur;
        case 3: return Puzzel;
        case 4: return Ingelijst;
        case 5: return Finale;
        default: return null;
    }
};

const confirmDelete = () => {
    confirm.require({
        message: 'Are you sure you want to delete this quiz and all its rounds, questions, and answers?',
        header: 'Confirm Deletion',
        icon: 'pi pi-exclamation-triangle',
        acceptClass: 'p-button-danger',
        accept: () => deleteQuiz(),
        reject: () => {
            toast.add({ severity: 'info', summary: 'Cancelled', detail: 'Quiz deletion was cancelled.', life: 3000 });
        }
    });
};

const deleteQuiz = () => {
    router.delete(route('quizzes.delete', props.quiz.id), {
        onSuccess: () => {
            toast.add({ severity: 'success', summary: 'Deleted', detail: 'Quiz successfully deleted.', life: 3000 });
        },
        onError: (errors) => {
            toast.add({ severity: 'error', summary: 'Error', detail: errors.message || 'Failed to delete quiz.', life: 3000 });
        }
    });
};
</script>
