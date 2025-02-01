<!-- NewQuizModal.vue -->
<template>
    <Modal :show="show" :title="$t('Give the quiz a name')" @close="closeModal">
        <form @submit.prevent="createQuiz">
            <div class="row">
                <div class="col s12">
                    <input type="text" v-model="quizName" placeholder="$t('Name')" required />
                </div>

                <div class="col s12">
                    <textarea v-model="quizDescription" placeholder="$t('Description')" class="materialize-textarea" required></textarea>
                </div>
            </div>

            <button type="submit" class="btn blue-bg">{{ $t('Create') }}</button>
        </form>
    </Modal>
</template>

<script>
import Modal from './Modal.vue';

export default {
    components: {
        Modal
    },
    data() {
        return {
            show: false,
            quizName: '',
            quizDescription: ''
        };
    },
    methods: {
        closeModal() {
            this.show = false;
        },
        createQuiz() {
            // Handle quiz creation logic
        }
    }
};
</script>
