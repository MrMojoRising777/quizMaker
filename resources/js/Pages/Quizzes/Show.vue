<template>
    <Card>
        <template #title>{{ quiz.title }}</template>
        <template #content>
            <Button
                severity="danger"
                :label="$t('actions.Delete')"
                @click="confirmDelete"
            />

            <Button
                v-if="canHostQuiz"
                severity="success"
                :label="$t('actions.Host')"
                @click="hostQuiz"
            />

            <Button
                v-if="previewWindow"
                severity="warning"
                :label="$t('actions.Close')"
                @click="closePreview"
            />

            <Tabs :value="activeTab" @update:value="activeTab = $event">
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
import { ref, computed } from 'vue';
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

const previewWindow = ref(null);
const isPlayerPreview = ref(false);

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

// Function to determine if all rounds, questions, and answers are filled
const canHostQuiz = computed(() => {
    return props.quiz.rounds.every(round =>
        round.questions.length > 0 &&
        round.questions.every(question =>
            question.text.trim() !== "" &&
            question.answers.length > 0 &&
            question.answers.every(answer => answer.text.trim() !== "")
        )
    );
});

const hostQuiz = () => {
    // Open a new window for the host's preview
    const hostPreviewUrl = route('quizzes.preview-host', { quiz: props.quiz.id, host: true });
    const hostWindow = window.open(
        hostPreviewUrl,
        'hostQuizPreview',
        'width=800,height=600,left=200,top=200,resizable=yes,scrollbars=yes'
    );

    // Open the player preview in the current tab using window.location
    const playerPreviewUrl = route('quizzes.preview-player', { quiz: props.quiz.id });
    window.location.href = playerPreviewUrl;  // This ensures the current tab navigates correctly

    // Optionally, you can listen for the host window close event and handle window closing
    hostWindow.onunload = () => {
        // Handle closing of the host window
        isPlayerPreview.value = false;
        router.push(route('quizzes.show', props.quiz.id));  // Revert back to the show route
    };
};

// Function to close the preview window manually
const closePreview = () => {
    if (previewWindow.value) {
        previewWindow.value.close();  // Close the host preview window
        previewWindow.value = null;
    }

    // Revert back to the show route after closing the preview
    isPlayerPreview.value = false;
    router.push(route('quizzes.show', props.quiz.id));
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
