<template>
    <div>
        <Toast />
        <ConfirmDialog />

        <header>
            <NavMenu />
        </header>
        <main class="p-4">
            <slot />
        </main>
        <footer>
            <!-- Footer content -->
        </footer>
    </div>
</template>

<script setup>
// import { provide } from 'vue';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import NavMenu from "../Components/NavMenu.vue";

// const getImageUrl = (file_path) => {
//     if (file_path && !file_path.startsWith('http')) {
//         return `/storage/questions/${file_path}`;
//     }
//     return file_path; // Return the file_path if it's already a full URL
// };
//
// // Make getImageUrl available to all child components
// provide('getImageUrl', getImageUrl);
</script>
