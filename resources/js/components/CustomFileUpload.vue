<template>
    <div class="card shadowNone flex flex-col items-center gap-6">
        <Avatar
            :image="preview || avatarUrl || defaultImage"
            class="mr-2"
            size="xlarge"
            shape="circle"
        />

        <FileUpload
            mode="basic"
            name="image"
            accept="image/*"
            :auto="false"
            :customUpload="false"
            class="p-button-outlined"
            severity="secondary"
            @select="onFileSelect"
        />
    </div>
</template>

<script setup>
import FileUpload from 'primevue/fileupload';
import Avatar from 'primevue/avatar';
import { ref, computed } from "vue";
import { router } from '@inertiajs/vue3';

const props = defineProps({
    avatarPath: {
        type: String,
        default: ''
    }
})

const defaultImage = 'https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png';

const avatarUrl = computed(() => {
    return props.avatarPath || null;
});

const preview = ref(null);
const selectedFile = ref(null);

/**
 * Handle file selection event from PrimeVue FileUpload.
 * Store the selected file and update the preview.
 */
async function onFileSelect(event) {
    const file = event.files?.[0];
    if (!file) return;

    selectedFile.value = file;

    const reader = new FileReader();
    reader.onload = (e) => {
        preview.value = e.target.result;
    };
    reader.readAsDataURL(file);

    const formData = new FormData();
    formData.append('image', file);

    router.post(route('profile.updateProfileImage'), formData, {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            console.log('Image updated successfully');
        },
        onError: (errors) => {
            console.error('Failed to update image:', errors);
        }
    });
}
</script>
