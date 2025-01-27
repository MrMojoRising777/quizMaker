<template>
    <div class="section">
        <div class="card">
            <div class="card-content">
                <div v-if="can('create quiz')">
                    <div class="row">
                        <div class="col s12">
                            <div class="card off-white-bg">
                                <div class="card-content">
                                    <!-- Include quiz table here if needed -->
                                    <!-- <QuizTable /> -->
                                    <p v-if="auth.user">Hello, {{ auth.user.name }}!</p>
                                </div>
                                <div class="card-action">
                                    <button
                                        class="btn blue-bg"
                                        @click="openNewQuizModal"
                                    >
                                        {{ $t('actions.Create quiz') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="hasRole('Player')" class="row">
                    <div class="col s12 m6">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-title">{{ $t('dashboard.Personal') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col s12 m6">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-title">{{ $t('dashboard.Personal') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="can('play quiz')">
                    <!-- Additional content for playing a quiz can go here -->
                </div>
            </div>
        </div>

        <!-- New Quiz Modal -->
        <Modal v-if="showModal" :show="showModal" title="Create Quiz" @close="closeModal">
            <p>This is the content inside the modal!</p>
            <button class="btn blue-bg" @click="submitQuiz">Submit</button>
        </Modal>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import Modal from "../components/Modal.vue";
import AppLayout from "../Layouts/AppLayout.vue";

export default {
    name: "Home",
    layout: AppLayout,
    components: {
        Link,
        Modal,
    },
    data() {
        return {
            showModal: false, // Controls modal visibility
        };
    },
    methods: {
        openNewQuizModal() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
    },
    computed: {
        auth() {
            return this.$page.props.auth; // Access the shared auth data
        },
        can() {
            // Helper method to check if the user has a specific permission
            return (permission) => this.auth.permissions.includes(permission);
        },
        hasRole() {
            // Helper function to check if the user has a specific role
            return (role) => this.auth.roles.includes(role);
        },
    },
};
</script>
