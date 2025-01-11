<template>
    <div class="card">
        <div class="card-content">
            <div class="card-title">Player Screen</div>

            <div v-if="loading">
                <p>Loading quiz data...</p>
            </div>

            <div v-else-if="error">
                <p class="error">{{ error }}</p>
            </div>

            <div v-else>
                <h2>{{ quiz.title }}</h2>
                <p>Current Question: {{ currentQuestion }}</p>
                <p>Score: {{ score }}</p>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    props: {
        quizId: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            quiz: null,
            currentQuestion: null,
            score: 0,
            loading: true,
            error: null,
            intervalId: null
        };
    },
    mounted() {
        this.fetchQuizData();

        this.intervalId = setInterval(() => {
            this.updateQuestionAndScore();
        }, 3000);
    },
    beforeUnmount() {
        if (this.intervalId) {
            clearInterval(this.intervalId);
        }
    },
    methods: {
        async fetchQuizData() {
            try {
                const response = await axios.get(`/api/quiz/${this.quizId}/fetch-data`);
                this.quiz = response.data;
                console.log(this.quiz);
            } catch (err) {
                this.error = "Failed to load quiz data. Please try again later.";
            } finally {
                this.loading = false;
            }
        },
        updateQuestionAndScore() {
            // if (this.quiz && this.quiz.questions.length > 0) {
            //     // Example logic to cycle through questions
            //     const currentIndex = this.quiz.questions.findIndex(q => q.text === this.currentQuestion);
            //     const nextIndex = (currentIndex + 1) % this.quiz.questions.length;
            //     this.currentQuestion = this.quiz.questions[nextIndex].text;
            //     this.score += 10; // Update scoring logic as per your requirements
            // } else {
            //     this.currentQuestion = "No questions available.";
            // }
        }
    }
};
</script>

<style scoped>
.card {
    border: 1px solid #ccc;
    padding: 20px;
    border-radius: 8px;
}

.card-title {
    font-size: 1.5em;
    margin-bottom: 10px;
}

.error {
    color: red;
}
</style>
