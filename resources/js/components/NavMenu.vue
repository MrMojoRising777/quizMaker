<template>
    <div class="card">
        <Menubar :model="items">
            <template #item="{ item }">
                <span :class="item.icon" />
                <Link :href="item.url" class="blue-text">{{ item.label }}</Link>
            </template>

            <template #end>
                <Avatar
                    image="https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png"
                    class="mr-2 cursor-pointer"
                    size="xlarge"
                    shape="circle"
                    @click="toggleMenu"
                />

                <Menu
                    :model="userSubItems"
                    popup
                    ref="menuRef"
                />
            </template>
        </Menubar>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';

import Menubar from 'primevue/menubar';
import Menu from 'primevue/menu';
import Avatar from 'primevue/avatar';

function handleLogout() {
    router.post(route('logout'));
}

const userSubItems = [
    {
        label: 'Profile',
        icon: 'pi pi-user-edit',
        url: route('profile.edit'),
    },
    { separator: true },
    {
        label: 'Logout',
        icon: 'pi pi-sign-out',
        command: handleLogout,
    }
];

const items = [
    {
        label: 'Home',
        icon: 'pi pi-home',
        url: route('dashboard'),
    },
    {
        label: 'Quizzes',
        icon: 'pi pi-pencil',
        url: route('quizzes.index'),
    },
];

const menuRef = ref(null);
function toggleMenu(event) {
    menuRef.value?.toggle(event);
}
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
