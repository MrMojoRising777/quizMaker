<template>
    <div>
        <Table :quizzes="quizzes"/>
    </div>
</template>

<script>
import Table from "../Components/Table.vue";
import AppLayout from "../Layouts/AppLayout.vue";

export default {
    components: {
        Table
    },
    layout: AppLayout,
    props: {
        quizzes: {
            type: Array,
            default: () => [],
        }
    },
    setup() {
        return {}
    }
}
</script>
