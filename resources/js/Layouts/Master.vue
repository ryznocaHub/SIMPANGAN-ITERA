<template>

    <Drawer>
        <Navbar />
        <div class="px-5 py-10">
            <slot />
        </div>
    </Drawer>
</template>

<style></style>

<script>
import Navbar from "@/Components/Navbar/index.vue";
import Drawer from "@/Components/Drawer/index.vue";

export default {
    components: {
        Navbar,
        Drawer
    }
};
</script>
