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

const props = defineProps({
    avatarPath: {
        type: String,
        default: ''
    }
})

const defaultImage = 'https://primefaces.org/cdn/primevue/images/avatar/amyelsner.png';

const avatarUrl = computed(() => {
    if (!props.avatarPath) {
        return null;
    }
    return props.avatarPath;
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

    // Show a local preview (optional)
    const reader = new FileReader();
    reader.onload = (e) => {
        preview.value = e.target.result;
    };
    reader.readAsDataURL(file);

    const formData = new FormData();
    formData.append('image', file);

    try {
        const response = await axios.post('/profile/profile-image', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });

        console.log('Image updated successfully', response.data);
    } catch (error) {
        console.error('Failed to update image:', error);
    }
}
</script>
