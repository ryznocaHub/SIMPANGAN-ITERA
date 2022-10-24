<template>
    <Show :items=items :noRAB="0" />
</template>

<script setup>
import Show from "@/Layouts/Item/Show.vue";
import InfoDetail from "@/Components/InfoDetail/Index.vue";
import InfoHPS from "@/Components/infoHPS/Index.vue";

const props = defineProps({
	items: { type: Object },
})

</script>