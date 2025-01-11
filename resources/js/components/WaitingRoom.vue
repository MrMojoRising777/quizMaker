<template>
    <div id="waiting-room">
        <h1>Waiting Room - {{ quiz.title }}</h1>
        Hosted by
        <h3>Players:</h3>
        <ul id="player-list">
            <li v-for="player in players" :key="player.id">{{ player.name }}</li>
        </ul>

        <div v-if="isHost">
            <button @click="startQuiz" :disabled="isStarting">
                {{ isStarting ? 'Starting...' : 'Start Quiz' }}
            </button>
        </div>
        <div v-else>
            <p>Waiting for the host to start the quiz...</p>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        quizData: Object,
        userData: Object,
    },
    data() {
        return {
            quiz: this.quizData,
            players: [],
            isHost: this.userData.id === this.quizData.user_id,
            isStarting: false,
        };
    },
    mounted() {
        this.listenForQuizStarted();
    },
    methods: {
        startQuiz() {
            if (!this.isHost || this.isStarting) return;
            this.isStarting = true;
            axios.post(`/api/quizzes/${this.quiz.id}/start`, {}, { withCredentials: true })
                .then(() => { this.isStarting = false; })
                .catch(error => {
                    console.error(error);
                    this.isStarting = false;
                });
        },
        listenForQuizStarted() {
            window.Echo.channel(`quiz.${this.quiz.id}`)
                .listen('QuizStarted', () => {
                    this.$router.push({ name: 'Quiz', params: { quizId: this.quiz.id } });
                });
        },
    },
};
</script>

<style scoped>
#waiting-room {
    text-align: center;
    padding: 20px;
}
#player-list {
    list-style-type: none;
    padding: 0;
}
#player-list li {
    margin: 5px 0;
}
button#start-quiz {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
}
button#start-quiz:disabled {
    cursor: not-allowed;
    opacity: 0.6;
}
</style>
