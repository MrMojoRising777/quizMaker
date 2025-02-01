<template>
    <div class="section">
        <div v-if="can('create quiz')">
            <div class="row">
                <div class="col s12">
                    <div class="card off-white-bg">
                        <div class="card-content">
                            <p v-if="auth.user">Hello, {{ auth.user.name }}!</p>
<!--                            <Table :quizzes="quizzes"/>-->
                        </div>
                        <div class="card-action">
                            <Button
                                :severity="'info'"
                                :label="$t('actions.Create quiz')"
                                @click="openNewQuizModal"
                            />
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
        <Button
            :label="$t('actions.Save')"
            :severity="'info'"
            @click="submitQuiz"
        />
    </Modal>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import Modal from "../components/Modal.vue";
import Table from "../components/Table.vue";
import Button from "../components/Button.vue"
import AppLayout from "../Layouts/AppLayout.vue";

export default {
    name: "Home",
    layout: AppLayout,
    components: {
        Link,
        Modal,
        Table,
        Button,
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
