<template>
    <div class="grid">
        <div class="col-12">
            <div v-if="can('create quiz')">
                <div class="grid">
                    <div class="col-6">
                        <Card>
                            <template #content>
                                <p v-if="auth.user">Hello, {{ auth.user.name }}!</p>
                            </template>
                        </Card>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div v-if="hasRole('Player')" class="p-grid">
                <div class="p-col-12 p-md-6 p-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-xl">{{ $t('dashboard.Personal') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import Card from 'primevue/card'
import AppLayout from "../Layouts/AppLayout.vue"

defineOptions({
    name: "Home",
    layout: AppLayout,
});

const props = defineProps({
    quizzes: {
        type: Array,
        default: () => [],
    }
});

const page = usePage();
const auth = computed(() => page.props.auth);
const can = (permission) => auth.value?.permissions?.includes(permission) || false;
const hasRole = (role) => auth.value?.roles?.includes(role) || false;
</script>
