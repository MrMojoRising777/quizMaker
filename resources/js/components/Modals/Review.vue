<!-- ReviewModal.vue -->
<template>
    <Modal :show="show" :title="$t('Leave a review')" @close="closeModal">
        <form @submit.prevent="submitReview">
            <label for="rating">{{ $t('Rating') }}:</label>
            <Rating v-model="rating" class="orange-text light-yellow-on-hover" required />

            <label for="review">{{ $t('Review') }}:</label>
            <textarea v-model="reviewText" id="review" rows="4" class="materialize-textarea" required></textarea>

            <Button
                :label="$t('actions.Submit Review')"
                type="submit"
                class="btn-flat black-text"
            />
        </form>
    </Modal>
</template>

<script>
import Modal from '../Modal.vue';
import Button from '../Button.vue';

export default {
    components: {
        Modal,
        Button
    },
    data() {
        return {
            show: false,
            rating: 0,
            reviewText: ''
        };
    },
    methods: {
        closeModal() {
            this.show = false;
        },
        submitReview() {
            // Handle review submission logic
        }
    }
};
</script>
