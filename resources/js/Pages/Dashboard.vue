<template>
    <div class="section">
        <p v-if="auth.user">Hello, {{ auth.user.name }}!</p>

        <div v-if="can('create quiz')">
            <div class="row">
                <div class="col s12">
                    <div class="card off-white-bg">
                        <div class="card-content">
                            <Table :quizzes="quizzes"/>
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

    <Modal v-if="showModal" :show="showModal" title="Create Quiz" @close="closeModal">
        <p>This is the content inside the modal!</p>
        <button class="btn blue-bg" @click="submitQuiz">Submit</button>
    </Modal>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import Modal from "../components/Modal.vue";
import Table from "../components/Table.vue";
import AppLayout from "../Layouts/AppLayout.vue";

export default {
    name: "Home",
    layout: AppLayout,
    components: {
        Link,
        Modal,
        Table,
    },
    props: {
        quizzes: {
            type: Array,
            default: () => [],
        }
    },
    data() {
        return {
            showModal: false,
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
            return this.$page.props.auth;
        },
        can() {
            return (permission) => this.auth.permissions.includes(permission);
        },
        hasRole() {
            return (role) => this.auth.roles.includes(role);
        },
    },
};
</script>
