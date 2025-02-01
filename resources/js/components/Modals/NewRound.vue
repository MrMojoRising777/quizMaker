<!-- NewRoundModal.vue -->
<template>
    <Modal :show="show" :title="$t('Add new round')" @close="closeModal">
        <form @submit.prevent="saveRound">
            <div class="row">
                <div class="col s12">
                    <input type="text" v-model="roundTitle" placeholder="$t('Round title')" required />

                    <select v-model="roundType" class="browser-default" required>
                        <option v-for="type in roundTypes" :key="type" :value="type">{{ type }}</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn waves-effect waves-light">{{ $t('Save') }}</button>
        </form>
    </Modal>
</template>

<script>
import Modal from './Modal.vue';

export default {
    components: {
        Modal
    },
    data() {
        return {
            show: false,
            roundTitle: '',
            roundType: '',
            roundTypes: ['Type 1', 'Type 2', 'Type 3'] // Dynamic data could be fetched from the backend
        };
    },
    methods: {
        closeModal() {
            this.show = false;
        },
        saveRound() {
            // Handle round saving logic
        }
    }
};
</script>
