<template>
    <Show :procurement=procurement >
    </Show>
</template>

<script setup>
import Show from "@/Layouts/Procurement/Show.vue";

const props = defineProps({
	procurement: { type: Object, required: true },
})

</script>