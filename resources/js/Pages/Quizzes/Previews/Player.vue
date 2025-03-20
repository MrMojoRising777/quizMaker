<template>
    <div class="grid">
        <div class="col-12 mt-3">
            <h1 class="text-2xl text-center text-white font-bold">
                {{ quiz.rounds[0].title }}
            </h1>
        </div>
        <div class="col-12 mt-8">
            <h2 class="text-4xl text-center text-white font-bold">
                {{ currentQuestion.text || 'No question available' }} <!-- quiz.rounds[0].questions[0].text -->
            </h2>
        </div>

        <div class="col-12">
            <h4 v-if="showAnswer" class="text-2xl text-center text-white font-bold">
                {{ currentAnswers.text || 'No answer available' }} <!-- quiz.rounds[0].questions[0].answers[0].text -->
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
import { ref, onMounted } from 'vue';

const props = defineProps({
    quiz: Object,
    currentQuestion: Object,
    currentAnswers: Object,
});

const showAnswer = ref(false);
const players = ref(["Speler 1", "Speler 2", "Speler 3"]);
const timers = ref(players.value.map(() => 60));

const currentQuestion = ref(props.quiz.rounds[0].questions[0]);
const currentAnswers = ref(currentQuestion.value.answers[0]);

const startTimers = () => {
    setInterval(() => {
        timers.value = timers.value.map(time => (time > 0 ? time - 1 : 0));
    }, 1000);
};

onMounted(() => {
    // Pusher.logToConsole = true; // DEBUG

    let pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
       cluster: 'eu',
    });

    let channel = pusher.subscribe(`quiz.${props.quiz.id}`);

    // Handle Answer Reveal
    channel.bind('AnswerRevealed', function (data) {
        showAnswer.value = true;
    });

    channel.bind('NewQuestion', function (data) {
        currentQuestion.value = data.question;
        currentAnswers.value = data.question.answers[0];
        console.log("answers",data.question.answers);
        showAnswer.value = false;
    });

    // Start countdown timers
    // startTimers();
});
</script>
