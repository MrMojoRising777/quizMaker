<template>
    <div v-if="show" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h2>{{ title }}</h2>
                <Button
                    :label="'×'"
                    @click="closeModal"
                    class="modal-close"
                />
            </div>
            <div class="modal-body">
                <slot></slot>
            </div>
            <div class="modal-footer">
                <Button
                    :label="$t('actions.Close')"
                    class="btn"
                    @click="closeModal"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Button from '../components/Button.vue';
export default {
    components: {
        Button,
    },
    props: {
        show: {
            type: Boolean,
            required: true,
        },
        title: {
            type: String,
            default: "Modal Title",
        },
    },
    emits: ["close"],
    methods: {
        closeModal() {
            this.$emit("close");
        },
    },
};
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    width: 500px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
}

.modal-body {
    margin: 20px 0;
}

.modal-footer {
    text-align: right;
}
</style>
