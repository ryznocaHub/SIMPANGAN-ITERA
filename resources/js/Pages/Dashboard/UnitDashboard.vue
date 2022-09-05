<template>
    <Master>
        <Header1 title="Form Input RAB"/>
    </Master>
</template>

<script setup>
import Master from "@/Layouts/Master.vue";
import { Link } from "@inertiajs/inertia-vue3";
import Header1 from "@/Components/utils/Header1.vue";
const props = defineProps({
    units: Array,
})
</script>

<style></style>
