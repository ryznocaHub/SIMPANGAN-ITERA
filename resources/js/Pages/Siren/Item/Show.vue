<template>
    <Show :items=items />
</template>

<script setup>
import Show from "@/Layouts/Item/Show.vue";

const props = defineProps({
	items: { type: Object },
})

</script>