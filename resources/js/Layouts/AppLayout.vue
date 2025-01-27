<template>
    <div>
        <header>
            <NavMenu />
        </header>
        <main>
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
