<template>
    <div class="grid">
        <div class="col-12 mt-3">
            <h1 class="text-2xl text-center font-bold">
                {{ currentRound.title }}
            </h1>
        </div>
        <div class="col-6">
            <Card>
                <template #content>
                    <h1 class="text-2xl text-center font-bold">
                        {{ currentQuestion.text }}
                    </h1>

                    <h2 class="text-2xl text-center font-semibold">
                        {{ currentQuestion.answers[0]?.text }}
                    </h2>
                </template>
            </Card>
        </div>
        <div class="col-6">
            <Card>
                <template #content>
                    <h2 class="text-2xl text-center font-bold">
                        {{ $t('fields.Description')}}
                    </h2>

                    {{ currentQuestion.note }}
                </template>
            </Card>
        </div>
        <div class="col-6">
            <Card class="h-160px">
                <template #content>
                    <div class="col-12 flex justify-content-center bottom-0">
                        <div v-for="(name, index) in players" :key="index" :id="'timerDiv' + index"
                             class="border-circle w-6rem h-6rem inline-block mx-2 text-center"
                             :class="{'bg-yellow-700': activePlayerIndex !== index, 'bg-green-500': activePlayerIndex === index}">

                            <h5 class="text-sm text-white font-bold mt-4">
                                {{ name }}
                            </h5>
                            <span class="text-2xl text-white font-semibold">
                                {{ timers[index] }}
                            </span>
                        </div>
                    </div>
                </template>
            </Card>
        </div>
        <div class="col-6">
            <Card class="h-160px">
                <template #content>
                    <h2 class="text-2xl text-center font-bold">
                        {{ $t('Actions')}}
                    </h2>

                    <div class="grid">
                        <div v-if="isRoundComplete" class="col-12">
                            <Button
                                :label="$t('actions.Next Round')"
                                @click="nextRound"
                            />
                        </div>

                        <div v-if="!isRoundComplete" class="col-12 flex justify-content-center">
                            <div class="col-3">
                                <Button
                                    :label="$t('actions.Correct')"
                                    icon="pi pi-check"
                                    @click="nextQuestion"
                                />
                            </div>

                            <div class="col-3">
                                <Button
                                    :label="$t('actions.Wrong/Pass')"
                                    icon="pi pi-ban"
                                    severity="danger"
                                    @click="passQuestion"
                                />
                            </div>
                        </div>
                    </div>
                </template>
            </Card>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import Button from 'primevue/button';
import axios from 'axios'
import Card from 'primevue/card'

const props = defineProps({ quiz: Object });

const players = ref(["Speler 1", "Speler 2", "Speler 3"]);
const timers = ref(players.value.map(() => 60));

const activePlayerIndex = ref(0);
const currentRoundIndex = ref(0);
const currentQuestionIndex = ref(0);
const showAnswer = ref(false);

const currentRound = computed(() => props.quiz.rounds[currentRoundIndex.value] || {});
const currentQuestion = computed(() => currentRound.value.questions[currentQuestionIndex.value] || {});
const isRoundComplete = computed(() => currentQuestionIndex.value >= (currentRound.value.questions.length - 1));

// **Puntenberekening**
const currentQuestionPoints = computed(() => {
    const rules = currentRound.value?.rules || [];
    const questionIndex = currentQuestionIndex.value + 1;

    let points = 0;

    // No points if penalty rule exists
    if (rules.some(rule => rule.rule_name === 'penalty')) return 0;

    // Find reward interval rule
    const rewardIntervalRule = rules.find(rule => rule.rule_name === 'reward_interval');
    if (rewardIntervalRule) {
        const rewardInterval = rewardIntervalRule.value;

        // Reward when the question index is a multiple of the interval
        if (questionIndex > 0 && questionIndex % rewardInterval === 0) {
            points = getRewardValue(rules);
        }
    } else {
        // Default reward for every question
        points = getRewardValue(rules);
    }

    return points;
});

// Get reward value from rules
const getRewardValue = (rules) => {
    return rules.find(rule => rule.rule_name === 'reward_value')?.value || 0;
};

const nextQuestion = () => {
    passCount.value = 0;
    activePlayerIndex.value = 0; // Always start with Player 1

    if (showAnswer.value) {
        currentQuestionIndex.value++;
        showAnswer.value = false;
    } else {
        // Update timer if points are rewarded
        if (currentQuestionPoints.value > 0) {
            timers.value[activePlayerIndex.value] += currentQuestionPoints.value;
        }

        showAnswer.value = true;
        revealAnswer(currentQuestion.value?.id);

        // Automatically move to the next question
        setTimeout(() => {
            currentQuestionIndex.value++;
            showAnswer.value = false;
        }, 1000);
    }
};

const passCount = ref(0);

const passQuestion = () => {
    passCount.value++;

    if (passCount.value >= players.value.length) {
        // Move to the next question if all players pass
        passCount.value = 0;
        activePlayerIndex.value = 0; // Reset to first player

        currentQuestionIndex.value++;
        showAnswer.value = false;
    } else {
        // Move to the next player
        activePlayerIndex.value = (activePlayerIndex.value + 1) % players.value.length;
    }
};

const revealAnswer = (questionId) => {
    if (questionId) {
        axios.post(route('quizzes.reveal-answer', { question: questionId }))
            .then(() => console.log("Event sent successfully"))
            .catch(error => console.error("Error sending event:", error));
    }
};

const nextRound = () => {
    if (currentRoundIndex.value < props.quiz.rounds.length - 1) {
        currentRoundIndex.value++;
        currentQuestionIndex.value = 0;
        showAnswer.value = false;
    }
};
</script>
