<template>
    <div>
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

<script>
import NavMenu from "../components/NavMenu.vue";
export default {
    components: {
        NavMenu,
    }
}
</script>
