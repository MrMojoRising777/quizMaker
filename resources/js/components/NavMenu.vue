<template>
    <div class="card">
        <Menubar :model="items">
            <template #start>
                <div class="image-container">
                    <img src="/public/svg/logoipsum.svg" alt="Icon" />
                </div>
            </template>
            <template #item="{ item, props, hasSubmenu, root }">
                <a
                    v-if="!item.action"
                    :href="item.href"
                    class="flex items-center"
                    v-bind="props.action"
                >
                    <span>{{ item.label }}</span>
                    <Badge v-if="item.badge" :class="{ 'ml-auto': !root, 'ml-2': root }" :value="item.badge" />
                    <span v-if="item.shortcut" class="ml-auto border border-surface rounded bg-emphasis text-muted-color text-xs p-1">{{ item.shortcut }}</span>
                    <i v-if="hasSubmenu" :class="['pi pi-angle-down ml-auto', { 'pi-angle-down': root, 'pi-angle-right': !root }]"></i>
                </a>
                <button
                    v-else
                    @click="item.action"
                    class="flex items-center p-menubar-item-link"
                >
                    <span>{{ item.label }}</span>
                </button>
            </template>
        </Menubar>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import {router} from "@inertiajs/vue3";

const items = ref([
    {
        label: 'Home',
        icon: 'pi pi-home',
        href: '/dashboard',
    },
    {
        label: 'Quizzes',
        icon: 'pi pi-pencil',
        href: '/quiz/index',
    },
    {
        label: 'User',
        icon: 'pi pi-user',
        items: [
            {
                label: 'Profile',
                icon: 'pi pi-user-edit',
                href: '/profile/edit',
            },
            {
                separator: true,
            },
            {
                label: 'Logout',
                icon: 'pi pi-sign-out',
                href: '',
                action: handleLogout,
            },
        ],
    },
]);

function handleLogout() {
    router.post('/logout');
}
</script>
