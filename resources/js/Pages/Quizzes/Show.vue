<template>
    <Card>
        <template #title>{{ quiz.title }}</template>
        <template #content>
            <Tabs v-model="activeTab">
                <TabList>
                    <Tab v-for="(round, index) in quiz.rounds" :key="round.title" :value="index">
                        {{ round.title }}
                    </Tab>
                </TabList>
                <TabPanels>
                    <TabPanel v-for="(round, index) in quiz.rounds" :key="round.title" :value="index">
                        <component :is="getRoundComponent(round.id)" :round="round" />
                    </TabPanel>
                </TabPanels>
            </Tabs>
        </template>
    </Card>
</template>

<script setup>
import { ref } from 'vue';
import Card from 'primevue/card';
import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';
import Tab from 'primevue/tab';
import AppLayout from "../../Layouts/AppLayout.vue";

import Round369 from '../../Components/Rounds/3-6-9.vue';
import OpenDeur from '../../Components/Rounds/OpenDeur.vue';

defineOptions({
    name: "Quiz.Show",
    layout: AppLayout,
});

const props = defineProps({
    quiz: Object,
});

const activeTab = ref(0);

const getRoundComponent = (roundId) => {
    switch (roundId) {
        case 1:
            return Round369;
        case 2:
            return OpenDeur;
        default:
            return null;
    }
};
</script>
