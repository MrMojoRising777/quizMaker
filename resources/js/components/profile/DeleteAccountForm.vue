<template>
    <section class="delete-account-section">
        <Button
            :label="$t('profile.Delete Account')"
            :severity="'danger'"
         />
    </section>
</template>

<script setup>
import Button from "../Button.vue";
</script>
