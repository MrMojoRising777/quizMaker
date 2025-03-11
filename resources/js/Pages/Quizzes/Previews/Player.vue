<template>
    <div class="grid">
        <div class="col-12 mt-3">
            <h1 class="text-2xl text-center text-white font-bold">
                {{ quiz.rounds[0].title }}
            </h1>
        </div>
        <div class="col-12 mt-8">
            <h2 class="text-4xl text-center text-white font-bold">
                {{ quiz.rounds[0].questions[0].text }}
            </h2>
        </div>

        <div class="col-12">
            <h4 v-if="showAnswer" class="text-2xl text-center text-white font-bold">
                {{ quiz.rounds[0].questions[0].answers[0].text }}
            </h4>
        </div>

        <div class="col-12 flex justify-content-center absolute bottom-0">
            <div v-for="(name, index) in players" :key="index" :id="'timerDiv' + index"
                 class="border-circle w-6rem h-6rem inline-block mx-2 text-center bg-yellow-700">

                <h5 class="text-sm text-white font-bold mt-4">
                    {{ name }}
                </h5>
                <span class="text-2xl text-white font-semibold">
                    {{ timers[index] }}
                </span>
            </div>
        </div>
    </div>
</template>

<script setup>
import Pusher from 'pusher-js';
import { ref, onMounted, watch } from 'vue';

const props = defineProps({
    quiz: Object,
    questionId: Number,
});

const showAnswer = ref(false);
const players = ref(["Speler 1", "Speler 2", "Speler 3"]);
const timers = ref(players.value.map(() => 60));

const startTimers = () => {
    setInterval(() => {
        timers.value = timers.value.map(time => (time > 0 ? time - 1 : 0));
    }, 1000);
};

onMounted(() => {
    Pusher.logToConsole = true;

    let pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
       cluster: 'eu',
    });

    const subscribeToChannel = (questionId) => {
        if (!questionId) return;
        let channel = pusher.subscribe(`quiz.${questionId}`);

        channel.bind('AnswerRevealed', function (data) {
            showAnswer.value = true; // Show the answer when event is received
        });
    };

    // Start countdown timers
    // startTimers();

    // Subscribe initially
    subscribeToChannel(props.questionId);

    watch(() => props.questionId, (newQuestionId, oldQuestionId) => {
        if (oldQuestionId) {
            pusher.unsubscribe(`quiz.${oldQuestionId}`);
        }
        subscribeToChannel(newQuestionId);
    });
});
</script>
